<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PricingSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Clear existing data (order matters due to FK constraints)
        DB::table('pricing_option_features')->delete();
        DB::table('pricing_package_options')->delete();
        DB::table('pricing_packages')->delete();

        // ── Packages ──────────────────────────────────────────────
        DB::table('pricing_packages')->insert([
            ['id' => 1, 'name' => 'Private Starter',      'slug' => 'private-starter',      'category' => 'private', 'portfolio_label' => 'bis 25.000 CHF Portfolio',  'sort_order' => 1, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => 'Private Secure',       'slug' => 'private-secure',       'category' => 'private', 'portfolio_label' => 'bis 100.000 CHF Portfolio', 'sort_order' => 2, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'name' => 'Business Essential',   'slug' => 'business-essential',   'category' => 'business','portfolio_label' => 'bis 100.000 CHF Portfolio', 'sort_order' => 3, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'name' => 'Business Professional','slug' => 'business-professional','category' => 'business','portfolio_label' => 'bis 500.000 CHF Portfolio', 'sort_order' => 4, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'name' => 'Business Enterprise',  'slug' => 'business-enterprise',  'category' => 'business','portfolio_label' => 'Ab 500.000 CHF Portfolio',  'sort_order' => 5, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // ── Options ───────────────────────────────────────────────
        DB::table('pricing_package_options')->insert([
            ['id' => 1, 'pricing_package_id' => 1, 'type' => 'digital', 'label' => 'Digital Package',  'price_chf' => 799,   'is_recommended' => 1, 'is_only_option' => 0, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'pricing_package_id' => 1, 'type' => 'onsite',  'label' => 'On-Site Service',  'price_chf' => 1250,  'is_recommended' => 0, 'is_only_option' => 0, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'pricing_package_id' => 2, 'type' => 'digital', 'label' => 'Digital Package',  'price_chf' => 1499,  'is_recommended' => 1, 'is_only_option' => 0, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 4, 'pricing_package_id' => 2, 'type' => 'onsite',  'label' => 'On-Site Service',  'price_chf' => 2250,  'is_recommended' => 0, 'is_only_option' => 0, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 5, 'pricing_package_id' => 3, 'type' => 'digital', 'label' => 'Digital Package',  'price_chf' => 1299,  'is_recommended' => 1, 'is_only_option' => 0, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 6, 'pricing_package_id' => 3, 'type' => 'onsite',  'label' => 'On-Site Service',  'price_chf' => 1950,  'is_recommended' => 0, 'is_only_option' => 0, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 7, 'pricing_package_id' => 4, 'type' => 'digital', 'label' => 'Digital Package',  'price_chf' => 2999,  'is_recommended' => 1, 'is_only_option' => 0, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 8, 'pricing_package_id' => 4, 'type' => 'onsite',  'label' => 'On-Site Service',  'price_chf' => 6500,  'is_recommended' => 0, 'is_only_option' => 0, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['id' => 9, 'pricing_package_id' => 5, 'type' => 'onsite',  'label' => 'On-Site Service',  'price_chf' => 11900, 'is_recommended' => 0, 'is_only_option' => 1, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // ── Features ──────────────────────────────────────────────
        DB::table('pricing_option_features')->insert([
            // Option 1 — Private Starter Digital
            ['pricing_package_option_id' => 1, 'feature' => '1× BitBox02',                        'is_inherited' => 0, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 1, 'feature' => '1× Seedor Safe Set',                 'is_inherited' => 0, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 1, 'feature' => '6 video courses (60-day access)',    'is_inherited' => 0, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 1, 'feature' => 'Email support',                      'is_inherited' => 0, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            // Option 2 — Private Starter Onsite
            ['pricing_package_option_id' => 2, 'feature' => 'Everything in Digital Package',      'is_inherited' => 1, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 2, 'feature' => '1.5 hours personal setup',           'is_inherited' => 0, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 2, 'feature' => 'Hands-on training at your location', 'is_inherited' => 0, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            // Option 3 — Private Secure Digital
            ['pricing_package_option_id' => 3, 'feature' => '2× BitBox02',                        'is_inherited' => 0, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 3, 'feature' => '1× Seedor Safe Set',                 'is_inherited' => 0, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 3, 'feature' => '5 video courses: 2-of-2 Multisig',  'is_inherited' => 0, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 3, 'feature' => 'Emergency plan template',            'is_inherited' => 0, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            // Option 4 — Private Secure Onsite
            ['pricing_package_option_id' => 4, 'feature' => 'Everything in Digital Package',      'is_inherited' => 1, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 4, 'feature' => '3 hours comprehensive training',     'is_inherited' => 0, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 4, 'feature' => 'Multi-signature setup assistance',   'is_inherited' => 0, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            // Option 5 — Business Essential Digital
            ['pricing_package_option_id' => 5, 'feature' => '1× BitBox02',                        'is_inherited' => 0, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 5, 'feature' => '1× Seedor Safe Set',                 'is_inherited' => 0, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 5, 'feature' => '5 business video courses',           'is_inherited' => 0, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 5, 'feature' => 'Corporate policy templates',         'is_inherited' => 0, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            // Option 6 — Business Essential Onsite
            ['pricing_package_option_id' => 6, 'feature' => 'Everything in Digital Package',      'is_inherited' => 1, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 6, 'feature' => '2 hours individual training',        'is_inherited' => 0, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 6, 'feature' => 'Professional setup assistance',      'is_inherited' => 0, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            // Option 7 — Business Professional Digital
            ['pricing_package_option_id' => 7, 'feature' => '3× BitBox02 (for 2-of-3 multisig)', 'is_inherited' => 0, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 7, 'feature' => '3× Seedor Safe Sets',               'is_inherited' => 0, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 7, 'feature' => '5 enterprise video courses',         'is_inherited' => 0, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 7, 'feature' => 'Governance templates',               'is_inherited' => 0, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            // Option 8 — Business Professional Onsite
            ['pricing_package_option_id' => 8, 'feature' => 'Everything in Digital Package',              'is_inherited' => 1, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 8, 'feature' => '4 hours team training (up to 4 people)',     'is_inherited' => 0, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 8, 'feature' => '6 months basic email support',               'is_inherited' => 0, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            // Option 9 — Business Enterprise Onsite (only option)
            ['pricing_package_option_id' => 9, 'feature' => 'Gold Membership',                    'is_inherited' => 0, 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 9, 'feature' => 'Custom 3-5 multisig setup',          'is_inherited' => 0, 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 9, 'feature' => '8 hours intensive training',         'is_inherited' => 0, 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 9, 'feature' => '12 months priority support',         'is_inherited' => 0, 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['pricing_package_option_id' => 9, 'feature' => 'Complete custom documentation',      'is_inherited' => 0, 'sort_order' => 5, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}