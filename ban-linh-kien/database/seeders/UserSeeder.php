<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 12,
                'name' => 'admin',
                'email' => '23010416@st.phenikaa-uni.edu.vn',
                'email_verified_at' => '2025-06-14 04:48:06',
                'password' => '$2y$12$nsYLHfts/WC0iFeFsTus9.TYiDD5O1hDbs0yQanydXgog9tuPBml.',
                'role' => 'staff',
                'remember_token' => '1l9GfRkyx9OjOtGPl5jcwMem4XjQT9Rs7nVudQNhYO1DZaFSmP3J4uGzztJR',
                'created_at' => '2025-06-14 04:17:52',
                'updated_at' => '2025-06-14 05:15:13',
            ],
        ]);
    }
}