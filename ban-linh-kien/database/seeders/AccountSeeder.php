<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Account;


class AccountSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account
        Account::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'admin123', // sẽ được bcrypt tự động
            'role' => 'admin',
        ]);

        // User account
        Account::create([
            'name' => 'User One',
            'email' => 'user1@example.com',
            'password' => 'user1234',
            'role' => 'user',
        ]);

        Account::create([
            'name' => 'User Two',
            'email' => 'user2@example.com',
            'password' => 'user5678',
            'role' => 'user',
        ]);
    }
}