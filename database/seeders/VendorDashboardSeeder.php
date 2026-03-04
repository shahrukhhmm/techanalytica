<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Vendor;
use App\Models\PricingTier;
use App\Models\Tool;
use Illuminate\Support\Facades\Hash;

class VendorDashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create a dedicated Vendor User for testing the dashboard
        $vendorUser = User::firstOrCreate([
            'email' => 'vendor@gmail.com'
        ], [
            'name' => 'Test Vendor',
            'password' => Hash::make('12345678'),
            'role' => 'vendor',
            'email_verified' => true,
        ]);

        // 2. Create the Vendor profile
        $vendorProfile = Vendor::firstOrCreate([
            'user_id' => $vendorUser->id
        ], [
            'company_name' => 'Vendor Test Company',
            'billing_email' => 'vendor@gmail.com',
            'company_website' => 'https://vendor-test.com',
        ]);

        // 3. Ensure we have basic pricing tiers with distinct permissions to test the menu switching
        // Basic Tier (No Analytics)
        $freeTier = PricingTier::firstOrCreate(
            ['name' => 'Free Vendor Tier'],
            [
                'monthly_price' => 0,
                'annual_price' => 0,
                'features' => ['Basic Listing'],
                'permissions' => ['Basic Listing'] // intentionally omitting 'view-analytics'
            ]
        );

        // Pro Tier (Has Analytics)
        $proTier = PricingTier::firstOrCreate(
            ['name' => 'Pro Vendor Tier'],
            [
                'monthly_price' => 99,
                'annual_price' => 990,
                'features' => ['Basic Listing', 'Analytics'],
                'permissions' => ['Basic Listing', 'view-analytics', 'upload-videos', 'multiple-ctas']
            ]
        );

        // 4. Create two tools assigned to this vendor, one on Free tier, one on Pro tier
        Tool::firstOrCreate([
            'slug' => 'vendor-free-tool'
        ], [
            'name' => 'Vendor Free Tool',
            'vendor_id' => $vendorProfile->id,
            'tier_id' => $freeTier->id,
            'short_description' => 'A free tool to test basic vendor routing.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Tool::firstOrCreate([
            'slug' => 'vendor-pro-tool'
        ], [
            'name' => 'Vendor Pro Tool',
            'vendor_id' => $vendorProfile->id,
            'tier_id' => $proTier->id,
            'short_description' => 'A premium tool to test advanced dynamic vendor routing like analytics.',
            'status' => 'published',
            'published_at' => now(),
        ]);
        
        $this->command->info('Vendor Dashboard Test Data Seeded! Login credentials: vendor@gmail.com / 12345678');
    }
}
