<?php

namespace App\Http\Controllers;

use App\Mail\EnterprisePaymentConfirmationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

class OnsitePaymentController extends Controller
{
    public function show(string $token)
    {
        $user = User::where('payment_token', $token)
            ->where('selected_option_type', 'onsite')
            ->firstOrFail();

        if ($user->payment_completed) {
            return view('onsite-payment', [
                'user'        => $user,
                'alreadyPaid' => true,
            ]);
        }

        $option = \App\Models\PricingPackageOption::whereHas('package', function ($q) use ($user) {
            $q->where('name', $user->selected_package);
        })
            ->where('type', 'onsite')
            ->first();

        $amountChf = $user->quoted_amount_chf
            ?? ($option ? (int) $option->price_chf : null);

        return view('onsite-payment', [
            'user'         => $user,
            'alreadyPaid'  => false,
            'option'       => $option,
            'amountChf'    => $amountChf,
            'stripeKey'    => env('STRIPE_PUBLISHABLEKEY'),
        ]);
    }

    public function createIntent(Request $request, string $token)
    {
        $user = User::where('payment_token', $token)
            ->where('selected_option_type', 'onsite')
            ->firstOrFail();

        abort_if($user->payment_completed, 409, 'Already paid.');

        $option = \App\Models\PricingPackageOption::whereHas('package', function ($q) use ($user) {
            $q->where('name', $user->selected_package);
        })
            ->where('type', 'onsite')
            ->first();

        $amountChf = $user->quoted_amount_chf
            ?? ($option ? (float) $option->price_chf : null);

        abort_if(! $amountChf, 422, 'Kein Betrag hinterlegt.');

        Stripe::setApiKey(env('STRIPE_SECRETKEY'));

        try {
            $intent = PaymentIntent::create([
                'amount'   => (int) round($amountChf * 100),
                'currency' => 'chf',
                'metadata' => [
                    'user_id'     => $user->id,
                    'package'     => $user->selected_package,
                    'option_type' => 'onsite',
                ],
            ]);

            return response()->json(['client_secret' => $intent->client_secret]);
        } catch (ApiErrorException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function complete(Request $request, string $token)
    {
        $request->validate(['payment_intent_id' => ['required', 'string']]);

        $user = User::where('payment_token', $token)
            ->where('selected_option_type', 'onsite')
            ->firstOrFail();

        abort_if($user->payment_completed, 409, 'Already paid.');

        Stripe::setApiKey(env('STRIPE_SECRETKEY'));

        try {
            $intent = PaymentIntent::retrieve($request->payment_intent_id);

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

        $user->update([
            'is_approved'       => true,
            'approved_at'       => now(),
            'payment_completed' => true,
            'payment_token'     => null,
            // Enterprise / onsite does not get digital course activation
            'access_ends_at'    => null,
        ]);

        if (stripos((string) $user->selected_package, 'Enterprise') !== false) {
            Mail::to($user->email)->send(new EnterprisePaymentConfirmationMail($user->fresh()));
        }

        return response()->json(['success' => true]);
    }
}
