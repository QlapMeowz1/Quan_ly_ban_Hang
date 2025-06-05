<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Product::create([
            'name' => 'CPU Intel Core i5-12400F',
            'price' => 4200000,
            'category_id' => 1,
            'description' => 'CPU thế hệ 12, 6 nhân 12 luồng, hiệu năng mạnh mẽ cho game và làm việc.',
            'image' => 'cpu_i5_12400f.jpg',
        ]);
        Product::create([
            'name' => 'Mainboard ASUS B660M-A',
            'price' => 3200000,
            'category_id' => 2,
            'description' => 'Mainboard ASUS chipset B660, hỗ trợ DDR4, PCIe 4.0.',
            'image' => 'asus_b660m_a.jpg',
        ]);
        Product::create([
            'name' => 'RAM Kingston Fury 16GB (2x8GB) DDR4 3200',
            'price' => 1500000,
            'category_id' => 3,
            'description' => 'Bộ nhớ RAM hiệu năng cao, phù hợp cho gaming và đồ họa.',
            'image' => 'kingston_fury_16gb.jpg',
        ]);
        Product::create([
            'name' => 'SSD Samsung 970 EVO Plus 500GB NVMe',
            'price' => 1800000,
            'category_id' => 4,
            'description' => 'Ổ cứng SSD tốc độ cao, chuẩn NVMe PCIe Gen3 x4.',
            'image' => 'samsung_970_evo_plus.jpg',
        ]);
        Product::create([
            'name' => 'VGA MSI RTX 3060 Ventus 2X 12G OC',
            'price' => 8500000,
            'category_id' => 5,
            'description' => 'Card đồ họa mạnh mẽ cho gaming, thiết kế 2 quạt tản nhiệt.',
            'image' => 'msi_rtx_3060_ventus.jpg',
        ]);
    }
}
