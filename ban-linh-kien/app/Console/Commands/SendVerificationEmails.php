<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class SendVerificationEmails extends Command
{
    protected $signature = 'users:send-verification-emails';
    protected $description = 'Gửi email xác thực cho tất cả người dùng chưa xác thực';

    public function handle()
    {
        $users = User::whereNull('email_verified_at')->get();
        
        foreach ($users as $user) {
            $user->sendEmailVerificationNotification();
            $this->info("Đã gửi email xác thực đến: {$user->email}");
        }

        $this->info('Hoàn thành gửi email xác thực!');
    }
} 