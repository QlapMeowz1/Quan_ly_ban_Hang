<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerificationOTP extends Notification implements ShouldQueue
{
    use Queueable;

    protected $otp;

    /**
     * Create a new notification instance.
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Xác Thực Email - Linh Kiện Máy Tính')
            ->greeting('Xin chào!')
            ->line('Bạn đã đăng ký tài khoản tại **Linh Kiện Máy Tính**.')
            ->line('Để hoàn tất quá trình đăng ký, vui lòng sử dụng mã OTP bên dưới:')
            ->line('**Mã OTP của bạn: ' . $this->otp . '**')
            ->line('Mã OTP này có hiệu lực trong **10 phút**.')
            ->line('Nếu bạn không đăng ký tài khoản này, vui lòng bỏ qua email này.')
            ->salutation('Trân trọng,<br>Đội ngũ Linh Kiện Máy Tính');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'otp' => $this->otp,
            'expires_at' => now()->addMinutes(10),
        ];
    }
} 