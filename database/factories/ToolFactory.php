<?php

namespace Database\Factories;

use App\Models\PricingTier;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tool>
 */
class ToolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->company . ' Tool';
        return [
            'vendor_id' => Vendor::factory(),
            'tier_id' => PricingTier::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'logo_url' => $this->faker->imageUrl(),
            'short_description' => $this->faker->sentence,
            'long_description' => $this->faker->paragraph,
            'website_url' => $this->faker->url,
            'pricing_structured' => ['plan' => 'basic', 'price' => 10],
            'pricing_text' => 'Starts from $10/mo',
            'cta_type' => 'website',
            'cta_url' => $this->faker->url,
            'status' => 'published',
            'is_claimed' => true,
            'published_at' => now(),
            'last_edited_at' => now(),
        ];
    }
}
