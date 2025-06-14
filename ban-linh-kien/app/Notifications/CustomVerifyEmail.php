<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Lang;

class CustomVerifyEmail extends Notification
{
    use Queueable;

    protected $mailer;

    /**
     * Create a new notification instance.
     */
    public function __construct($mailer = null)
    {
        $this->mailer = $mailer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        $mail = (new MailMessage)
            ->subject(Lang::get('Xác thực địa chỉ email'))
            ->line(Lang::get('Vui lòng nhấn vào nút bên dưới để xác thực địa chỉ email.'))
            ->action(Lang::get('Xác thực email'), $verificationUrl)
            ->line(Lang::get('Nếu bạn không tạo tài khoản, bạn không cần thực hiện thêm hành động nào.'));
        if ($this->mailer) {
            $mail->mailer($this->mailer);
        }
        return $mail;
    }

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            ['id' => $notifiable->getKey(), 'hash' => sha1($notifiable->getEmailForVerification())]
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
