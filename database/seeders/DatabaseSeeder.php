<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Tool;
use App\Models\PricingTier;
use App\Models\Category;
use App\Models\Blog;
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
        ]);

        // Create Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make(12345678),
            'role' => 'admin',
        ]);

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
    }
}
