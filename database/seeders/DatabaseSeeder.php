<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'username'=>'buyerdemo',
            'phone_number'=>'081234567890',
            'status_registrasi'=>'verified',
            'role'=>'buyer',
            'password'=>'Buyer123',
        ]);

        User::factory()->create([
            'username'=>'sellerdemo',
            'phone_number'=>'081234567891',
            'status_registrasi'=>'verified',
            'role'=>'seller',
            'password'=>'Seller123',
        ]);

        User::factory()->create([
            'username'=>'admindemo',
            'phone_number'=>'081234567892',
            'status_registrasi'=>'verified',
            'role'=>'admin',
            'password'=>'Admin123',
        ]);

        User::factory(50)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
