<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create([
            'name' => 'Electronics',
            'description' => 'Electronic devices and accessories'
        ]);

        Category::create([
            'name' => 'Clothing',
            'description' => 'Apparel and fashion items'
        ]);

        Category::create([
            'name' => 'Books',
            'description' => 'Books and publications'
        ]);
    }
}