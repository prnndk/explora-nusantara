<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['id' => '0f62c4ee-1aa3-11f1-9bbc-94bb43cf7e37', 'name' => 'Spices & Herbs', 'created_at' => '2026-03-08 03:58:26', 'updated_at' => '2026-03-08 03:58:26'],
            ['id' => '0f62dfa2-1aa3-11f1-9bbc-94bb43cf7e37', 'name' => 'Coffee & Tea', 'created_at' => '2026-03-08 03:58:26', 'updated_at' => '2026-03-08 03:58:26'],
            ['id' => '0f62e134-1aa3-11f1-9bbc-94bb43cf7e37', 'name' => 'Coconut Derivatives', 'created_at' => '2026-03-08 03:58:26', 'updated_at' => '2026-03-08 03:58:26'],
            ['id' => '0f62e1c1-1aa3-11f1-9bbc-94bb43cf7e37', 'name' => 'Natural Fiber Handicrafts', 'created_at' => '2026-03-08 03:58:26', 'updated_at' => '2026-03-08 03:58:26'],
            ['id' => '0f62e22d-1aa3-11f1-9bbc-94bb43cf7e37', 'name' => 'Essential Oils', 'created_at' => '2026-03-08 03:58:26', 'updated_at' => '2026-03-08 03:58:26'],
            ['id' => '0f62e295-1aa3-11f1-9bbc-94bb43cf7e37', 'name' => 'Sustainable Furniture', 'created_at' => '2026-03-08 03:58:26', 'updated_at' => '2026-03-08 03:58:26'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(['id' => $category['id']], $category);
        }
    }
}
