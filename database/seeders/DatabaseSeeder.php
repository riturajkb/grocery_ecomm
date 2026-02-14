<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Customer User
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
        ]);

        // Sample Products
        Product::create([
            'name' => 'Basmati Rice (5kg)',
            'description' => 'Premium quality Basmati rice.',
            'price' => 850.00,
            'stock' => 50,
            'image' => null, // Or add a placeholder
        ]);

        Product::create([
            'name' => 'Soybean Oil (1L)',
            'description' => 'Healthy cooking oil.',
            'price' => 120.00,
            'stock' => 100,
            'image' => null,
        ]);

        Product::create([
            'name' => 'Tur Dal (1kg)',
            'description' => 'Protein-rich lentils.',
            'price' => 160.00,
            'stock' => 80,
            'image' => null,
        ]);
    }
}
