<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'code'             => 'SECURE5',
                'discount_percent' => 5,
                'allowed_package'  => 'Private Secure',
                'requires_grant'   => true,
                'is_active'        => true,
                'notes'            => 'Upsell Private Starter → Private Secure (7 Tage ab E-Mail)',
            ],
            [
                'code'             => 'PRO7',
                'discount_percent' => 7,
                'allowed_package'  => 'Business Professional',
                'requires_grant'   => true,
                'is_active'        => true,
                'notes'            => 'Upsell Business Essential → Business Professional (7 Tage ab E-Mail)',
            ],
            [
                'code'             => 'SBV_KULANZ',
                'discount_percent' => 10,
                'allowed_package'  => null,
                'requires_grant'   => false,
                'is_active'        => true,
                'notes'            => 'Manueller Admin-Kulanzcode – kein automatisches Kunden-E-Mail',
            ],
        ];

        foreach ($coupons as $data) {
            Coupon::updateOrCreate(['code' => $data['code']], $data);
        }
    }
};
