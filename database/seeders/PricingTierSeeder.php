<?php

namespace Database\Seeders;

use App\Models\PricingTier;
use Illuminate\Database\Seeder;

class PricingTierSeeder extends Seeder
{
    public function run(): void
    {
        $tiers = [
            [
                'name' => 'Free',
                'monthly_price' => 0.00,
                'annual_price' => 0.00,
                'features' => ['1 Tool Slot', 'Basic Analytics'],
                'permissions' => [],
            ],
            [
                'name' => 'Starter',
                'monthly_price' => 29.00,
                'annual_price' => 290.00,
                'features' => ['1 Tool Slot', 'Full Analytics', 'Long Description', 'Custom CTAs'],
                'permissions' => ['manage_pricing', 'manage_features', 'view_analytics', 'manage_long_description', 'manage_premium_cta'],
            ],
            [
                'name' => 'Growth',
                'monthly_price' => 79.00,
                'annual_price' => 790.00,
                'features' => ['3 Tool Slots', 'Full Analytics', 'All Base Features', 'Multiple Industries'],
                'permissions' => ['manage_pricing', 'manage_features', 'view_analytics', 'manage_reviews', 'manage_long_description', 'manage_premium_cta', 'manage_multiple_industries', 'manage_3_products'],
            ],
            [
                'name' => 'Enterprise',
                'monthly_price' => 199.00,
                'annual_price' => 1990.00,
                'features' => ['Unlimited Tools', 'Priority Support', 'Ads Management'],
                'permissions' => ['manage_pricing', 'manage_features', 'view_analytics', 'manage_reviews', 'manage_ads', 'manage_long_description', 'manage_premium_cta', 'manage_multiple_industries', 'manage_unlimited_products'],
            ],
        ];

        foreach ($tiers as $tier) {
            PricingTier::updateOrCreate(['name' => $tier['name']], $tier);
        }
    }
}
