<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends BaseVerifyEmail
{
    public function toMail($notifiable)
    {
        // Gunakan template kustom dari Visual Builder
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->view('user-verify-email', [
                'verificationUrl' => $verificationUrl,
                'user' => $notifiable,
            ]);
    }
}