<?php

namespace Database\Seeders;

use App\Models\PricingTier;
use App\Models\Tool;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class PricingTierSeeder extends Seeder
{
    public function run(): void
    {
        // Define the 3 core plans: 1 Free, 1 Monthly, 1 Yearly
        $tiers = [
            [
                'name' => 'Free',
                'monthly_price' => 0.00,
                'annual_price' => 0.00,
                'features' => [
                    '100% Free for Public Users & Visitors',
                    '1 Basic Tool Listing Slot',
                    'Community Ratings & Reviews',
                    'Public Side-by-Side Comparison',
                    'Standard Directory Listing',
                ],
                'permissions' => [],
            ],
            [
                'name' => 'Pro Monthly',
                'monthly_price' => 29.00,
                'annual_price' => 348.00,
                'features' => [
                    '1 Tool Listing Slot (Billed Monthly)',
                    'Full Analytics & Traffic Telemetry',
                    'Verified Product Badge',
                    'Long Architecture & Overview Specs',
                    'Custom Call-To-Action (CTA)',
                    'Direct Buyer Lead Capture',
                ],
                'permissions' => [
                    'view_analytics',
                    'manage_pricing',
                    'manage_features',
                    'manage_long_description',
                    'manage_premium_cta',
                    'lead_capture',
                ],
            ],
            [
                'name' => 'Pro Yearly',
                'monthly_price' => 24.00,
                'annual_price' => 290.00,
                'features' => [
                    '3 Tool Listing Slots (Billed Annually — Save $58)',
                    'Priority Directory Ranking & Featured Badge',
                    'Full Analytics & Telemetry',
                    'Multi-Industry Categorization',
                    'Review Responses & Moderation',
                    'Lead Inquiries CSV Export',
                    'Priority 24/7 Support',
                ],
                'permissions' => [
                    'view_analytics',
                    'manage_pricing',
                    'manage_features',
                    'manage_long_description',
                    'manage_premium_cta',
                    'lead_capture',
                    'manage_reviews',
                    'featured_listing',
                    'manage_multiple_industries',
                    'manage_3_products',
                ],
            ],
        ];

        // Ensure 3 standard tier records
        $tierIds = [];
        foreach ($tiers as $tierData) {
            $tier = PricingTier::updateOrCreate(['name' => $tierData['name']], $tierData);
            $tierIds[$tierData['name']] = $tier->id;
        }

        $freeTierId = $tierIds['Free'];

        // Clean up any other obsolete/duplicate tiers (e.g. "Free Vendor Tier", "Starter", "Enterprise", etc.)
        $validNames = array_column($tiers, 'name');
        $obsoleteTiers = PricingTier::whereNotIn('name', $validNames)->get();

        foreach ($obsoleteTiers as $obsolete) {
            Tool::where('tier_id', $obsolete->id)->update(['tier_id' => $freeTierId]);
            Vendor::where('pricing_tier_id', $obsolete->id)->update(['pricing_tier_id' => $freeTierId]);
            $obsolete->delete();
        }
    }
}
