<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PricingTier>
 */
class PricingTierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'monthly_price' => $this->faker->randomFloat(2, 0, 100),
            'annual_price' => $this->faker->randomFloat(2, 0, 1000),
            'features' => $this->faker->words(3),
        ];
    }
}
