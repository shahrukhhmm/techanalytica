<?php

namespace Database\Seeders;

use App\Models\BillingTransaction;
use App\Models\PricingTier;
use App\Models\Tool;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
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
            'email' => 'vendor@gmail.com',
        ], [
            'name' => 'Test Vendor',
            'password' => Hash::make('12345678'),
            'role' => 'vendor',
            'email_verified' => true,
        ]);

        // 2. Retrieve the standard plans
        $freeTier = PricingTier::where('name', 'Free')->first();
        $monthlyTier = PricingTier::where('name', 'Pro Monthly')->first() ?? $freeTier;
        $annualTier = PricingTier::where('name', 'Pro Yearly')->first() ?? $monthlyTier;

        // 3. Create the Vendor profile
        $vendorProfile = Vendor::firstOrCreate([
            'user_id' => $vendorUser->id,
        ], [
            'company_name' => 'Vendor Test Company',
            'billing_email' => 'vendor@gmail.com',
            'company_website' => 'https://vendor-test.com',
            'pricing_tier_id' => $annualTier->id,
        ]);

        // 4. Create two tools assigned to this vendor: one on Free tier, one on Pro Annual tier
        $freeTool = Tool::updateOrCreate([
            'slug' => 'vendor-free-tool',
        ], [
            'name' => 'Vendor Free Tool',
            'vendor_id' => $vendorProfile->id,
            'tier_id' => $freeTier->id,
            'short_description' => 'A free community tool to test basic vendor routing.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        $proTool = Tool::updateOrCreate([
            'slug' => 'vendor-pro-tool',
        ], [
            'name' => 'Vendor Pro Tool',
            'vendor_id' => $vendorProfile->id,
            'tier_id' => $annualTier->id,
            'short_description' => 'A premium tool to test advanced dynamic vendor routing like analytics.',
            'status' => 'published',
            'published_at' => now(),
        ]);

        // 5. Create sample billing transaction for this test vendor
        BillingTransaction::firstOrCreate([
            'external_tx_id' => 'ch_test_vendor_growth_01',
        ], [
            'vendor_id' => $vendorProfile->id,
            'tool_id' => $proTool->id,
            'amount' => 290.00,
            'currency' => 'USD',
            'type' => 'upgrade',
            'status' => 'paid',
            'created_at' => now()->subDays(15),
        ]);

        $this->command->info('Vendor Dashboard Test Data Seeded! Login credentials: vendor@gmail.com / 12345678');
    }
}
