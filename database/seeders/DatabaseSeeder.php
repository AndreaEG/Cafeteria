<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@cafechuzo.com',
            'password' => Hash::make('Admin123!'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Cajero Uno',
            'email' => 'cajero@cafechuzo.com',
            'password' => Hash::make('Cajero123!'),
            'role' => 'trabajador',
        ]);

        $bebidas = Category::create(['name' => 'Bebidas', 'type' => 'bebida']);

        Product::create([
            'category_id' => $bebidas->id,
            'name' => 'Café Americano',
            'cost_price' => 8,
            'sale_price' => 25,
            'stock' => 50,
        ]);
    }
}