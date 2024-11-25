<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'category_id' => 1,
            'name' => 'Smartphone',
            'description' => 'Latest model smartphone',
            'price' => 599.99,
            'stock' => 50
        ]);

        Product::create([
            'category_id' => 2,
            'name' => 'T-Shirt',
            'description' => 'Cotton T-Shirt',
            'price' => 19.99,
            'stock' => 100
        ]);

        Product::create([
            'category_id' => 3,
            'name' => 'Programming Book',
            'description' => 'Learn programming basics',
            'price' => 39.99,
            'stock' => 30
        ]);
    }
}