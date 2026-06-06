<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

class OnsitePaymentController extends Controller
{
    /**
     * Show the payment page for an onsite user given their unique token.
     */
    public function show(string $token)
    {
        $user = User::where('payment_token', $token)
            ->where('selected_option_type', 'onsite')
            ->firstOrFail();

        if ($user->payment_completed) {
            return view('onsite-payment', [
                'user'          => $user,
                'alreadyPaid'   => true,
            ]);
        }

        // Look up the price from the DB
        $option = \App\Models\PricingPackageOption::whereHas('package', function ($q) use ($user) {
                $q->where('name', $user->selected_package);
            })
            ->where('type', 'onsite')
            ->first();

        return view('onsite-payment', [
            'user'         => $user,
            'alreadyPaid'  => false,
            'option'       => $option,
            'stripeKey'    => env('STRIPE_PUBLISHABLEKEY'),
        ]);
    }

    /**
     * Create a PaymentIntent for the onsite payment page.
     */
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
            ->firstOrFail();

        Stripe::setApiKey(env('STRIPE_SECRETKEY'));

        try {
            $intent = PaymentIntent::create([
                'amount'   => (int) round($option->price_chf * 100),
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

    /**
     * Verify payment server-side and unlock the account.
     */
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

        // Unlock the account
        $user->update([
            'is_approved'       => true,
            'payment_completed' => true,
            'payment_token'     => null,   // invalidate token so link can't be reused
        ]);

        return response()->json(['success' => true]);
    }
}