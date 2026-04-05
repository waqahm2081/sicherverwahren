<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PricingPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [

            // ── 1. PRIVATE STARTER ───────────────────────────────────────────
            [
                'name'            => 'Private Starter',
                'slug'            => 'private-starter',
                'category'        => 'private',
                'portfolio_label' => 'bis 25.000 CHF Portfolio',
                'sort_order'      => 1,
                'options' => [
                    [
                        'type'           => 'digital',
                        'label'          => 'Digital Package',
                        'price_chf'      => 799,
                        'is_recommended' => true,
                        'sort_order'     => 1,
                        'features' => [
                            ['feature' => '1× BitBox02',              'sort_order' => 1],
                            ['feature' => '1× Seedor Safe Set',        'sort_order' => 2],
                            ['feature' => '6 video courses (60-day access)', 'sort_order' => 3],
                            ['feature' => 'Email support',             'sort_order' => 4],
                        ],
                    ],
                    [
                        'type'           => 'onsite',
                        'label'          => 'On-Site Service',
                        'price_chf'      => 1250,
                        'is_recommended' => false,
                        'sort_order'     => 2,
                        'features' => [
                            ['feature' => 'Everything in Digital Package',         'is_inherited' => true,  'sort_order' => 1],
                            ['feature' => '1.5 hours personal setup',              'sort_order' => 2],
                            ['feature' => 'Hands-on training at your location',    'sort_order' => 3],
                        ],
                    ],
                ],
            ],

            // ── 2. PRIVATE SECURE ────────────────────────────────────────────
            [
                'name'            => 'Private Secure',
                'slug'            => 'private-secure',
                'category'        => 'private',
                'portfolio_label' => 'bis 100.000 CHF Portfolio',
                'sort_order'      => 2,
                'options' => [
                    [
                        'type'           => 'digital',
                        'label'          => 'Digital Package',
                        'price_chf'      => 1499,
                        'is_recommended' => true,
                        'sort_order'     => 1,
                        'features' => [
                            ['feature' => '2× BitBox02',                        'sort_order' => 1],
                            ['feature' => '1× Seedor Safe Set',                 'sort_order' => 2],
                            ['feature' => '5 video courses: 2-of-2 Multisig',   'sort_order' => 3],
                            ['feature' => 'Emergency plan template',            'sort_order' => 4],
                        ],
                    ],
                    [
                        'type'           => 'onsite',
                        'label'          => 'On-Site Service',
                        'price_chf'      => 2250,
                        'is_recommended' => false,
                        'sort_order'     => 2,
                        'features' => [
                            ['feature' => 'Everything in Digital Package',         'is_inherited' => true,  'sort_order' => 1],
                            ['feature' => '3 hours comprehensive training',        'sort_order' => 2],
                            ['feature' => 'Multi-signature setup assistance',      'sort_order' => 3],
                        ],
                    ],
                ],
            ],

            // ── 3. BUSINESS ESSENTIAL ────────────────────────────────────────
            [
                'name'            => 'Business Essential',
                'slug'            => 'business-essential',
                'category'        => 'business',
                'portfolio_label' => 'bis 100.000 CHF Portfolio',
                'sort_order'      => 3,
                'options' => [
                    [
                        'type'           => 'digital',
                        'label'          => 'Digital Package',
                        'price_chf'      => 1299,
                        'is_recommended' => true,
                        'sort_order'     => 1,
                        'features' => [
                            ['feature' => '1× BitBox02',                    'sort_order' => 1],
                            ['feature' => '1× Seedor Safe Set',             'sort_order' => 2],
                            ['feature' => '5 business video courses',       'sort_order' => 3],
                            ['feature' => 'Corporate policy templates',     'sort_order' => 4],
                        ],
                    ],
                    [
                        'type'           => 'onsite',
                        'label'          => 'On-Site Service',
                        'price_chf'      => 1950,
                        'is_recommended' => false,
                        'sort_order'     => 2,
                        'features' => [
                            ['feature' => 'Everything in Digital Package',     'is_inherited' => true, 'sort_order' => 1],
                            ['feature' => '2 hours individual training',       'sort_order' => 2],
                            ['feature' => 'Professional setup assistance',     'sort_order' => 3],
                        ],
                    ],
                ],
            ],

            // ── 4. BUSINESS PROFESSIONAL ─────────────────────────────────────
            [
                'name'            => 'Business Professional',
                'slug'            => 'business-professional',
                'category'        => 'business',
                'portfolio_label' => 'bis 500.000 CHF Portfolio',
                'sort_order'      => 4,
                'options' => [
                    [
                        'type'           => 'digital',
                        'label'          => 'Digital Package',
                        'price_chf'      => 2999,
                        'is_recommended' => true,
                        'sort_order'     => 1,
                        'features' => [
                            ['feature' => '3× BitBox02 (for 2-of-3 multisig)', 'sort_order' => 1],
                            ['feature' => '3× Seedor Safe Sets',               'sort_order' => 2],
                            ['feature' => '5 enterprise video courses',        'sort_order' => 3],
                            ['feature' => 'Governance templates',              'sort_order' => 4],
                        ],
                    ],
                    [
                        'type'           => 'onsite',
                        'label'          => 'On-Site Service',
                        'price_chf'      => 6500,
                        'is_recommended' => false,
                        'sort_order'     => 2,
                        'features' => [
                            ['feature' => 'Everything in Digital Package',             'is_inherited' => true, 'sort_order' => 1],
                            ['feature' => '4 hours team training (up to 4 people)',    'sort_order' => 2],
                            ['feature' => '6 months basic email support',              'sort_order' => 3],
                        ],
                    ],
                ],
            ],

            // ── 5. BUSINESS ENTERPRISE ───────────────────────────────────────
            [
                'name'            => 'Business Enterprise',
                'slug'            => 'business-enterprise',
                'category'        => 'business',
                'portfolio_label' => 'Ab 500.000 CHF Portfolio',
                'sort_order'      => 5,
                'options' => [
                    [
                        'type'           => 'onsite',
                        'label'          => 'On-Site Service',
                        'price_chf'      => 11900,
                        'is_recommended' => false,
                        'is_only_option' => true,
                        'sort_order'     => 1,
                        'features' => [
                            ['feature' => 'Gold Membership',                            'sort_order' => 1],
                            ['feature' => 'Custom 3-5 multisig setup',                  'sort_order' => 2],
                            ['feature' => '8 hours intensive training',                 'sort_order' => 3],
                            ['feature' => '12 months priority support',                 'sort_order' => 4],
                            ['feature' => 'Complete custom documentation',              'sort_order' => 5],
                        ],
                    ],
                ],
            ],

        ];

        foreach ($packages as $pkgData) {
            $options = $pkgData['options'];
            unset($pkgData['options']);

            $packageId = DB::table('pricing_packages')->insertGetId(array_merge(
                $pkgData,
                ['created_at' => now(), 'updated_at' => now()]
            ));

            foreach ($options as $optData) {
                $features = $optData['features'];
                unset($optData['features']);

                $optionId = DB::table('pricing_package_options')->insertGetId(array_merge(
                    $optData,
                    [
                        'pricing_package_id' => $packageId,
                        'is_only_option'     => $optData['is_only_option'] ?? false,
                        'created_at'         => now(),
                        'updated_at'         => now(),
                    ]
                ));

                foreach ($features as $feat) {
                    DB::table('pricing_option_features')->insert(array_merge(
                        [
                            'pricing_package_option_id' => $optionId,
                            'is_inherited'              => false,
                        ],
                        $feat,
                        ['created_at' => now(), 'updated_at' => now()]
                    ));
                }
            }
        }
    }
}