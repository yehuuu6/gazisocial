<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class SendEmailVerification extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Get the verify email notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject("E-posta Adresinizi Doğrulayın")
            ->line("Gazi Social'a hoş geldiniz! Hesabınızı etkinleştirmek için lütfen aşağıdaki doğrulama butonuna tıklayın.")
            ->action("Hesabımı Doğrula", $url)
            ->line(
                "Eğer bu hesabı siz oluşturmadıysanız, lütfen bu e-postayı dikkate almayınız."
            );
    }
}
