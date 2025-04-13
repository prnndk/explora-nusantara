<?php

namespace Database\Factories;

use App\Models\Buyer;
use App\Models\Seller;
use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
 */
class ContractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => \App\Models\Product::inRandomOrder()->first()->id,
            'buyer_id' => Buyer::inRandomOrder()->first()->id,
            'seller_id' => Seller::inRandomOrder()->first()->id,
            'status' => fake()->randomElement(ProductStatus::getToArray()),
        ];
    }
}