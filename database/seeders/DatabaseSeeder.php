<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Contract;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //        User::factory()->create([
        //            'username' => 'buyerdemo',
        //            'email' => 'buyer@eksplora.com',
        //            'register_status' => 'verified',
        //            'role' => 'buyer',
        //            'password' => 'Buyer123',
        //        ]);
        //
        //        User::factory()->create([
        //            'username' => 'sellerdemo',
        //            'email' => 'seller@eksplora.com',
        //            'register_status' => 'verified',
        //            'role' => 'seller',
        //            'password' => 'Seller123',
        //        ]);
        //
        User::factory()->create([
            'username' => 'admindemo',
            'email' => 'admin@eksplora.com',
            'register_status' => 'verified',
            'role' => 'admin',
            'password' => 'Admin123',
        ]);

        Product::factory()->count(10)->create();
        Contract::factory()->count(10)->create();
    }
}
