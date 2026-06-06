<?php

namespace App\Http\Controllers;

use App\Mail\UserRegistered;
use App\Mail\UserWelcome;
use App\Models\PricingPackage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

class PricingController extends Controller
{
    public function index()
    {
        $packages = PricingPackage::active()
            ->with([
                'options'          => fn ($q) => $q->orderBy('sort_order'),
                'options.features' => fn ($q) => $q->orderBy('sort_order'),
            ])
            ->orderBy('sort_order')
            ->get();

        return view('pricing', compact('packages'));
    }

    /**
     * Create a Stripe PaymentIntent — only for digital packages.
     */
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'selected_package'     => ['required', 'string', 'max:255'],
            'selected_option_type' => ['required', 'string', 'in:digital'],  // onsite never calls this
            'option_id'            => ['required', 'integer'],
        ]);

        Stripe::setApiKey(env('STRIPE_SECRETKEY'));

        try {
            $option = \App\Models\PricingPackageOption::findOrFail($request->option_id);

            $amountRappen = (int) round($option->price_chf * 100);

            $intent = PaymentIntent::create([
                'amount'   => $amountRappen,
                'currency' => 'chf',
                'metadata' => [
                    'package'     => $request->selected_package,
                    'option_type' => $request->selected_option_type,
                ],
            ]);

            return response()->json([
                'client_secret' => $intent->client_secret,
            ]);
        } catch (ApiErrorException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Stripe-Fehler: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Register user.
     * - Digital: payment_intent_id required, verified against Stripe before account creation.
     * - Onsite:  no payment now; account created pending admin approval + later payment.
     */
    public function register(Request $request)
    {
        $isOnsite = $request->input('selected_option_type') === 'onsite';

        $rules = [
            'name'                 => ['required', 'string', 'max:255'],
            'email'                => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'                => ['required', 'string', 'max:50'],
            'password'             => ['required', 'confirmed', Password::min(8)],
            'selected_package'     => ['required', 'string', 'max:255'],
            'selected_option_type' => ['required', 'string', 'in:digital,onsite'],
            'preferred_language'   => ['required', 'string', 'in:de,en'],
        ];

        if (! $isOnsite) {
            $rules['payment_intent_id'] = ['required', 'string'];
        }

        $validated = $request->validate($rules);

        // ── Digital: verify payment before creating account ──
        if (! $isOnsite) {
            Stripe::setApiKey(env('STRIPE_SECRETKEY'));

            try {
                $intent = PaymentIntent::retrieve($validated['payment_intent_id']);

                if ($intent->status !== 'succeeded') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Zahlung nicht abgeschlossen. Bitte versuchen Sie es erneut.',
                    ], 402);
                }
            } catch (ApiErrorException $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Zahlungsverifizierung fehlgeschlagen: ' . $e->getMessage(),
                ], 500);
            }
        }

        // ── Create user ──
        $user = User::create([
            'name'                 => $validated['name'],
            'email'                => $validated['email'],
            'phone'                => $validated['phone'],
            'password'             => Hash::make($validated['password']),
            'selected_package'     => $validated['selected_package'],
            'selected_option_type' => $validated['selected_option_type'],
            'preferred_language'   => $validated['preferred_language'],
            // onsite users start unapproved and unpaid; digital users are also unapproved
            // (admin must still approve digital users too — existing behaviour unchanged)
            'is_approved'          => false,
            'payment_completed'    => $isOnsite ? false : true,  // digital paid already
        ]);

        // Email to admin
        Mail::to(config('mail.from.address'))->send(new UserRegistered($user));

        // Email to user
        Mail::to($user->email)->send(new UserWelcome($user));

        return response()->json([
            'success' => true,
            'message' => $isOnsite
                ? 'Ihre Anfrage wurde eingereicht. Wir prüfen Ihre Angaben und melden uns in Kürze.'
                : 'Ihr Konto wurde erfolgreich erstellt.',
        ]);
    }
}