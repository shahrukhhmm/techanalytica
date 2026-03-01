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
                'features' => ['feature1', 'feature2'],
            ],
            [
                'name' => 'Pro',
                'monthly_price' => 10.00,
                'annual_price' => 100.00,
                'features' => ['feature1', 'feature2', 'feature3'],
            ],
            [
                'name' => 'Enterprise',
                'monthly_price' => 100.00,
                'annual_price' => 1000.00,
                'features' => ['feature1', 'feature2', 'feature3', 'feature4'],
            ],
        ];

        foreach ($tiers as $tier) {
            PricingTier::updateOrCreate(['name' => $tier['name']], $tier);
        }
    }
}
