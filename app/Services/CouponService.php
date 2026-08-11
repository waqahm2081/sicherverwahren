<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\CouponGrant;
use App\Models\PricingPackageOption;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class CouponService
{
    /**
     * @return array{coupon: Coupon, grant: ?CouponGrant, original: float, discount: float, final: float, percent: int}
     */
    public function validateForCheckout(string $code, string $packageName, string $email, string $optionType = 'digital'): array
    {
        $coupon = Coupon::findByCode($code);

        if (! $coupon || ! $coupon->is_active) {
            throw ValidationException::withMessages([
                'coupon_code' => 'Dieser Rabattcode ist ungültig oder nicht aktiv.',
            ]);
        }

        if ($coupon->allowed_package && strcasecmp($coupon->allowed_package, $packageName) !== 0) {
            throw ValidationException::withMessages([
                'coupon_code' => 'Dieser Rabattcode gilt nicht für das gewählte Paket.',
            ]);
        }

        $grant = null;
        if ($coupon->requires_grant) {
            $grant = CouponGrant::where('coupon_id', $coupon->id)
                ->whereRaw('LOWER(email) = ?', [strtolower($email)])
                ->whereNull('used_at')
                ->where('expires_at', '>', now())
                ->latest('id')
                ->first();

            if (! $grant) {
                throw ValidationException::withMessages([
                    'coupon_code' => 'Dieser Rabattcode ist für Ihre E-Mail-Adresse nicht gültig oder abgelaufen.',
                ]);
            }
        }

        $option = PricingPackageOption::whereHas('package', fn ($q) => $q->where('name', $packageName))
            ->where('type', $optionType)
            ->first();

        if (! $option) {
            throw ValidationException::withMessages([
                'coupon_code' => 'Paketpreis konnte nicht ermittelt werden.',
            ]);
        }

        $original = (float) $option->price_chf;
        $discount = round($original * ($coupon->discount_percent / 100), 2);
        $final    = max(0, round($original - $discount, 2));

        return [
            'coupon'   => $coupon,
            'grant'    => $grant,
            'original' => $original,
            'discount' => $discount,
            'final'    => $final,
            'percent'  => (int) $coupon->discount_percent,
        ];
    }

    public function markUsed(?CouponGrant $grant, ?User $user = null): void
    {
        if (! $grant) {
            return;
        }

        $grant->update([
            'used_at' => now(),
            'user_id' => $user?->id ?? $grant->user_id,
        ]);
    }

    public function grantUpsellCoupon(Coupon $coupon, User $user, int $validDays = 7): CouponGrant
    {
        return CouponGrant::create([
            'coupon_id'  => $coupon->id,
            'email'      => $user->email,
            'user_id'    => $user->id,
            'expires_at' => Carbon::now()->addDays($validDays),
        ]);
    }
}
