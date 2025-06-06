<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $brands = [
            [
                'name' => 'ASUS',
                'logo' => 'brands/asus-logo.png',
                'description' => 'ASUS là một trong những nhà sản xuất bo mạch chủ lớn nhất thế giới.'
            ],
            [
                'name' => 'MSI',
                'logo' => 'brands/msi-logo.png',
                'description' => 'MSI là nhà sản xuất phần cứng máy tính, đặc biệt là card đồ họa và bo mạch chủ.'
            ],
            [
                'name' => 'GIGABYTE',
                'logo' => 'brands/gigabyte-logo.png',
                'description' => 'GIGABYTE Technology chuyên sản xuất bo mạch chủ và card đồ họa chất lượng cao.'
            ],
            [
                'name' => 'Intel',
                'logo' => 'brands/intel-logo.png',
                'description' => 'Intel Corporation là nhà sản xuất chip bán dẫn lớn nhất thế giới.'
            ],
            [
                'name' => 'AMD',
                'logo' => 'brands/amd-logo.png',
                'description' => 'AMD là công ty sản xuất chip bán dẫn, vi xử lý và card đồ họa.'
            ],
            [
                'name' => 'Corsair',
                'logo' => 'brands/corsair-logo.png',
                'description' => 'Corsair chuyên sản xuất các thiết bị ngoại vi và linh kiện máy tính chất lượng cao.'
            ]
        ];

        foreach ($brands as $brand) {
            DB::table('brands')->updateOrInsert(
                ['brand_name' => $brand['name']],
                [
                    'brand_logo' => $brand['logo'],
                    'brand_description' => $brand['description']
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('brands')->whereIn('brand_name', ['ASUS', 'MSI', 'GIGABYTE', 'Intel', 'AMD', 'Corsair'])
            ->update(['brand_logo' => null]);
    }
}; 