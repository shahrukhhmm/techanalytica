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

        // 6. Seed sample visitor telemetry & leads for test vendor tools
        if (\App\Models\AnalyticsEvent::whereIn('tool_id', [$freeTool->id, $proTool->id])->count() === 0) {
            $referrers = [
                'https://www.google.com/search?q=ai+productivity+tools',
                'https://techanalytica.com/tools',
                'https://www.linkedin.com/feed',
                'https://twitter.com/ai_discoveries',
                'https://news.ycombinator.com',
                null,
            ];
            $userAgents = [
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
                'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.2 Safari/605.1.15',
                'Mozilla/5.0 (iPhone; CPU iPhone OS 17_3 like Mac OS X) AppleWebKit/605.1.15 Mobile/15E148',
            ];

            // Pro Tool views over past 6 months
            for ($monthOffset = 5; $monthOffset >= 0; $monthOffset--) {
                $baseDate = \Carbon\Carbon::now()->subMonths($monthOffset);
                $viewCount = ($monthOffset === 0) ? 145 : (50 + (5 - $monthOffset) * 28);
                $clickCount = (int) round($viewCount * 0.14);

                for ($i = 0; $i < $viewCount; $i++) {
                    $eventTime = (clone $baseDate)->startOfMonth()->addDays(rand(1, min(27, $baseDate->daysInMonth)))->addHours(rand(1, 23))->addMinutes(rand(1, 59));
                    if ($eventTime->isFuture()) $eventTime = now()->subHours(rand(1, 48));

                    \App\Models\AnalyticsEvent::create([
                        'tool_id' => $proTool->id,
                        'vendor_id' => $vendorProfile->id,
                        'event_type' => 'view',
                        'timestamp' => $eventTime,
                        'referrer' => $referrers[array_rand($referrers)],
                        'session_id' => 'sess_pro_' . $monthOffset . '_' . ($i % 30),
                        'device' => $userAgents[array_rand($userAgents)],
                    ]);
                }

                for ($c = 0; $c < $clickCount; $c++) {
                    $eventTime = (clone $baseDate)->startOfMonth()->addDays(rand(1, min(27, $baseDate->daysInMonth)))->addHours(rand(1, 23))->addMinutes(rand(1, 59));
                    if ($eventTime->isFuture()) $eventTime = now()->subHours(rand(1, 48));

                    \App\Models\AnalyticsEvent::create([
                        'tool_id' => $proTool->id,
                        'vendor_id' => $vendorProfile->id,
                        'event_type' => 'cta_click',
                        'timestamp' => $eventTime,
                        'referrer' => 'https://techanalytica.com/tools/' . $proTool->slug,
                        'session_id' => 'sess_pro_click_' . $monthOffset . '_' . $c,
                        'device' => $userAgents[array_rand($userAgents)],
                    ]);
                }
            }

            // Free Tool views over past 6 months
            for ($monthOffset = 5; $monthOffset >= 0; $monthOffset--) {
                $baseDate = \Carbon\Carbon::now()->subMonths($monthOffset);
                $viewCount = ($monthOffset === 0) ? 68 : (25 + (5 - $monthOffset) * 12);
                $clickCount = (int) round($viewCount * 0.08);

                for ($i = 0; $i < $viewCount; $i++) {
                    $eventTime = (clone $baseDate)->startOfMonth()->addDays(rand(1, min(27, $baseDate->daysInMonth)))->addHours(rand(1, 23))->addMinutes(rand(1, 59));
                    if ($eventTime->isFuture()) $eventTime = now()->subHours(rand(1, 48));

                    \App\Models\AnalyticsEvent::create([
                        'tool_id' => $freeTool->id,
                        'vendor_id' => $vendorProfile->id,
                        'event_type' => 'view',
                        'timestamp' => $eventTime,
                        'referrer' => $referrers[array_rand($referrers)],
                        'session_id' => 'sess_free_' . $monthOffset . '_' . ($i % 15),
                        'device' => $userAgents[array_rand($userAgents)],
                    ]);
                }

                for ($c = 0; $c < $clickCount; $c++) {
                    $eventTime = (clone $baseDate)->startOfMonth()->addDays(rand(1, min(27, $baseDate->daysInMonth)))->addHours(rand(1, 23))->addMinutes(rand(1, 59));
                    if ($eventTime->isFuture()) $eventTime = now()->subHours(rand(1, 48));

                    \App\Models\AnalyticsEvent::create([
                        'tool_id' => $freeTool->id,
                        'vendor_id' => $vendorProfile->id,
                        'event_type' => 'cta_click',
                        'timestamp' => $eventTime,
                        'referrer' => 'https://techanalytica.com/tools/' . $freeTool->slug,
                        'session_id' => 'sess_free_click_' . $monthOffset . '_' . $c,
                        'device' => $userAgents[array_rand($userAgents)],
                    ]);
                }
            }

            // Seed Sample Leads
            \App\Models\Lead::create([
                'tool_id' => $proTool->id,
                'vendor_id' => $vendorProfile->id,
                'name' => 'Sarah Jenkins',
                'email' => 'sarah.j@enterprise-tech.io',
                'company_name' => 'Enterprise Tech Corp',
                'company_size' => '50-200',
                'phone' => '+1 (555) 234-8901',
                'intent_type' => 'demo',
                'message' => 'Interested in enterprise seat licensing and custom API rate limits.',
                'status' => 'new',
            ]);

            \App\Models\Lead::create([
                'tool_id' => $proTool->id,
                'vendor_id' => $vendorProfile->id,
                'name' => 'Marcus Vance',
                'email' => 'm.vance@ai-dynamics.com',
                'company_name' => 'AI Dynamics Labs',
                'company_size' => '200+',
                'phone' => '+1 (555) 876-5432',
                'intent_type' => 'contact',
                'message' => 'Looking for SOC-2 compliance details and procurement process.',
                'status' => 'contacted',
            ]);
        }

        $this->command->info('Vendor Dashboard Test Data Seeded! Login credentials: vendor@gmail.com / 12345678');
    }
}
