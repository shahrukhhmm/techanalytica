<?php

namespace Database\Factories;

use App\Models\Tool;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Claim>
 */
class ClaimFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tool_id' => Tool::inRandomOrder()->first()?->id ?? Tool::factory(),
            'vendor_id' => Vendor::inRandomOrder()->first()?->id ?? Vendor::factory(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'reason' => $this->faker->sentence(),
        ];
    }
}
