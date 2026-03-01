<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Newsletter>
 */
class NewsletterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['draft', 'sent']);
        return [
            'subject' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'status' => $status,
            'sent_at' => $status === 'sent' ? $this->faker->dateTimeBetween('-1 month', 'now') : null,
        ];
    }
}
