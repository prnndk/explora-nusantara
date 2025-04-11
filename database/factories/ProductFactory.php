<?php

namespace Database\Factories;

use App\Enums\ProductStatus;
use App\Enums\RegisterStatus;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama'=> fake()->word(),
            'deskripsi'=> fake()->sentence(),
            'harga'=> fake()->numberBetween(10000, 1000000),
            'stok'=> fake()->numberBetween(1, 100),
            'terjual'=> fake()->numberBetween(1, 100),
            'status'=> fake()->randomElement(ProductStatus::getToArray()),
            'seller_id'=> Seller::where('id','9ea49a2a-efb7-4929-8581-39d640337d57')->firstOrFail()->id,
        ];
    }
}
