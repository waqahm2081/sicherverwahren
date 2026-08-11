<?php

namespace App\Http\Controllers;

use App\Mail\UserRegistered;
use App\Mail\UserWelcome;
use App\Models\PricingPackage;
use App\Models\PricingPackageOption;
use App\Models\User;
use App\Services\CouponService;
use Illuminate\Http\Request;
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

    public function validateCoupon(Request $request, CouponService $coupons)
    {
        $request->validate([
            'coupon_code'          => ['required', 'string', 'max:50'],
            'selected_package'     => ['required', 'string', 'max:255'],
            'selected_option_type' => ['required', 'string', 'in:digital'],
            'email'                => ['required', 'email'],
        ]);

        $result = $coupons->validateForCheckout(
            $request->coupon_code,
            $request->selected_package,
            $request->email,
            $request->selected_option_type
        );

        return response()->json([
            'success'          => true,
            'discount_percent' => $result['percent'],
            'original'         => $result['original'],
            'discount'         => $result['discount'],
            'final'            => $result['final'],
            'final_fmt'        => number_format($result['final'], 0, '.', "'"),
            'message'          => $result['percent'] . '% Rabatt angewendet.',
        ]);
    }

    public function createPaymentIntent(Request $request, CouponService $coupons)
    {
        $request->validate([
            'selected_package'     => ['required', 'string', 'max:255'],
            'selected_option_type' => ['required', 'string', 'in:digital'],
            'option_id'            => ['required', 'integer'],
            'email'                => ['nullable', 'email'],
            'coupon_code'          => ['nullable', 'string', 'max:50'],
        ]);

        Stripe::setApiKey(env('STRIPE_SECRETKEY'));

        try {
            $option = PricingPackageOption::findOrFail($request->option_id);
            $amountChf = (float) $option->price_chf;
            $couponCode = null;

            if ($request->filled('coupon_code') && $request->filled('email')) {
                $result = $coupons->validateForCheckout(
                    $request->coupon_code,
                    $request->selected_package,
                    $request->email,
                    'digital'
                );
                $amountChf  = $result['final'];
                $couponCode = $result['coupon']->code;
            }

            $amountRappen = (int) round($amountChf * 100);
            if ($amountRappen < 50) {
                $amountRappen = 50; // Stripe CHF minimum
            }

            $intent = PaymentIntent::create([
                'amount'   => $amountRappen,
                'currency' => 'chf',
                'metadata' => [
                    'package'     => $request->selected_package,
                    'option_type' => $request->selected_option_type,
                    'coupon_code' => $couponCode ?? '',
                ],
            ]);

            return response()->json([
                'client_secret' => $intent->client_secret,
                'amount_chf'    => $amountChf,
            ]);
        } catch (ApiErrorException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Stripe-Fehler: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function register(Request $request, CouponService $coupons)
    {
        $isOnsite = $request->input('selected_option_type') === 'onsite';

        $rules = [
            'name'                 => ['required', 'string', 'max:255'],
            'email'                => ['required', 'string', 'email', 'max:255'],
            'phone'                => ['required', 'string', 'max:50'],
            'password'             => ['required', 'confirmed', Password::min(8)],
            'selected_package'     => ['required', 'string', 'max:255'],
            'selected_option_type' => ['required', 'string', 'in:digital,onsite'],
            'preferred_language'   => ['required', 'string', 'in:de,en'],
            'coupon_code'          => ['nullable', 'string', 'max:50'],
        ];

        if (! $isOnsite) {
            $rules['payment_intent_id'] = ['required', 'string'];
        }

        $validated = $request->validate($rules);

        $existingUser = User::where('email', $validated['email'])->where('role', 'user')->first();

        // New registrations must use a unique email unless this is a coupon upsell upgrade
        if ($existingUser && empty($validated['coupon_code'])) {
            return response()->json([
                'success' => false,
                'message' => 'Diese E-Mail-Adresse ist bereits registriert.',
                'errors'  => ['email' => ['Diese E-Mail-Adresse ist bereits registriert.']],
            ], 422);
        }

        $appliedCoupon = null;
        $grant = null;

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

            if (! empty($validated['coupon_code'])) {
                $result = $coupons->validateForCheckout(
                    $validated['coupon_code'],
                    $validated['selected_package'],
                    $validated['email'],
                    'digital'
                );
                $appliedCoupon = $result['coupon']->code;
                $grant = $result['grant'];
            } elseif ($existingUser) {
                return response()->json([
                    'success' => false,
                    'message' => 'Diese E-Mail-Adresse ist bereits registriert.',
                    'errors'  => ['email' => ['Diese E-Mail-Adresse ist bereits registriert.']],
                ], 422);
            }
        } elseif ($existingUser) {
            return response()->json([
                'success' => false,
                'message' => 'Diese E-Mail-Adresse ist bereits registriert.',
                'errors'  => ['email' => ['Diese E-Mail-Adresse ist bereits registriert.']],
            ], 422);
        }

        if ($existingUser) {
            $existingUser->update([
                'name'                 => $validated['name'],
                'phone'                => $validated['phone'],
                'password'             => $validated['password'],
                'selected_package'     => $validated['selected_package'],
                'selected_option_type' => $validated['selected_option_type'],
                'preferred_language'   => $validated['preferred_language'],
                'is_approved'          => false,
                'approved_at'          => null,
                'access_ends_at'       => null,
                'payment_completed'    => true,
                'applied_coupon_code'  => $appliedCoupon,
                'shipped_at'           => null,
                'shipping_date'        => null,
                'tracking_number'      => null,
                'reminder_10d_sent_at' => null,
                'expired_email_sent_at'=> null,
            ]);
            $user = $existingUser->fresh();
        } else {
            $user = User::create([
                'name'                 => $validated['name'],
                'email'                => $validated['email'],
                'phone'                => $validated['phone'],
                'password'             => $validated['password'],
                'selected_package'     => $validated['selected_package'],
                'selected_option_type' => $validated['selected_option_type'],
                'preferred_language'   => $validated['preferred_language'],
                'is_approved'          => false,
                'payment_completed'    => $isOnsite ? false : true,
                'applied_coupon_code'  => $appliedCoupon,
            ]);
        }

        if ($grant) {
            $coupons->markUsed($grant, $user);
        }

        Mail::to(config('mail.from.address'))->send(new UserRegistered($user));
        Mail::to($user->email)->send(new UserWelcome($user));

        return response()->json([
            'success' => true,
            'message' => $isOnsite
                ? 'Vielen Dank für Ihre Anfrage. Wir haben Ihre Angaben erhalten und melden uns innerhalb von 1–2 Arbeitstagen persönlich bei Ihnen.'
                : 'Vielen Dank für Ihre Bestellung. Ihre Zahlung wurde erfolgreich verarbeitet. Sie erhalten in Kürze eine Bestätigung per E-Mail.',
        ]);
    }
}
