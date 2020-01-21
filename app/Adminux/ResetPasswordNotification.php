<?php

namespace App\Adminux;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// TODO
// Update .env APP_URL because it uses that to generate the reset password link
// Update config/mail.php from name
// https://laravel.com/docs/notifications#mail-notifications
class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', route('password.reset', ['token' => $this->token, 'email' => $this->email]))
            ->line('This password reset link will expire in 60 minutes.')
            ->line('If you did not request a password reset, no further action is required.');
    }
}
