<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buyer>
 */
class BuyerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => fake()->unique()->phoneNumber(),
            'address' => fake()->address(),
            'country' => fake()->country(),
            'nik' => fake()->unique()->numerify('##########'),
            'photo_file_id' => fake()->uuid(),
            'ktp_file_id' => fake()->uuid(),
            'company_name' => fake()->company(),
            'company_address' => fake()->address(),
            'company_phone_number' => fake()->unique()->phoneNumber(),
            'bank_name' => fake()->company(),
            'bank_account_number' => fake()->unique()->numerify('##########'),
            'legality_file_id' => fake()->uuid(),
        ];
    }
}
