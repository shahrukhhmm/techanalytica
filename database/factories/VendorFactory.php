<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vendor>
 */
class VendorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'company_name' => $this->faker->company,
            'company_website' => $this->faker->url,
            'company_size' => $this->faker->randomElement(['1-10', '11-50', '51-200', '201-500', '500+']),
            'designation' => $this->faker->jobTitle,
            'department' => $this->faker->bs,
            'phone' => $this->faker->phoneNumber,
            'billing_email' => $this->faker->companyEmail,
            'billing_address' => $this->faker->address,
        ];
    }
}
