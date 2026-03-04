<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Category;
use App\Models\PricingTier;
use App\Models\Tool;
use App\Models\User;
use App\Models\Vendor;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed static data
        $this->call([
            PricingTierSeeder::class,
            CategorySeeder::class,
            VendorDashboardSeeder::class,
        ]);

        // Create Admin User
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make(12345678),
                'role' => 'admin',
                'email_verified' => true,
            ]
        );

        // Create Users with Vendors and Tools
        User::factory(10)->create()->each(function ($user) {
            // 50% chance to be a vendor
            if (rand(0, 1)) {
                $vendor = Vendor::factory()->create(['user_id' => $user->id]);

                // Create tools for vendor
                Tool::factory(rand(1, 3))->create([
                    'vendor_id' => $vendor->id,
                    'tier_id' => PricingTier::inRandomOrder()->first()->id,
                ])->each(function ($tool) {
                    // Attach random categories
                    $categories = Category::inRandomOrder()->limit(rand(1, 3))->get();
                    $tool->categories()->attach($categories);
                });
            }
        });

        // Create Blogs
        Blog::factory(20)->create();

        // Create Subscribers
        \App\Models\Subscriber::factory(50)->create();

        // Create Newsletters
        \App\Models\Newsletter::factory(10)->create();

        // Scatter Reviews across Tools
        Tool::all()->each(function ($tool) {
            \App\Models\Review::factory(rand(2, 5))->create([
                'tool_id' => $tool->id,
                'user_id' => User::inRandomOrder()->first()->id,
            ]);
        });

        // Create Claims
        \App\Models\Claim::factory(10)->create();
    }
}
