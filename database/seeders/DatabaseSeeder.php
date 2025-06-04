<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        Log::info('Seeder is running!');
        \App\Models\Category::create(['name' => 'CPU', 'description' => 'Vi xử lý']);
        \App\Models\Category::create(['name' => 'RAM', 'description' => 'Bộ nhớ']);
        \App\Models\Category::create(['name' => 'Mainboard', 'description' => 'Bo mạch chủ']);

        \App\Models\Product::create([
            'name' => 'Intel Core i5',
            'price' => 5000000,
            'category_id' => 1,
            'description' => 'CPU thế hệ mới',
            'image' => 'https://via.placeholder.com/200',
        ]);
        \App\Models\Product::create([
            'name' => 'Kingston 8GB',
            'price' => 800000,
            'category_id' => 2,
            'description' => 'RAM DDR4 chất lượng',
        ]);
        \App\Models\Product::create([
            'name' => 'ASUS Prime B460M',
            'price' => 2200000,
            'category_id' => 3,
            'description' => 'Mainboard phổ thông',
        ]);
    }
} 