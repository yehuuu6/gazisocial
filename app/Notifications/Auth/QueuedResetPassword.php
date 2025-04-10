<?php

namespace App\Notifications\Auth;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class QueuedResetPassword extends ResetPassword implements ShouldQueue
{
    use Queueable;

    /**
     * Get the reset password notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url)
    {
        return (new MailMessage)
            ->subject("Şifre Sıfırlama İsteği")
            ->line("Gazi Social hesabınız için bir şifre sıfırlama isteği aldık. Şifrenizi sıfırlamak için lütfen aşağıdaki butona tıklayın.")
            ->action("Şifremi Sıfırla", $url)
            ->line(
                'Bu bağlantı 60 dakika boyunca geçerlidir.'
            )
            ->line("Eğer bu şifre sıfırlama isteğini siz yapmadıysanız, lütfen bu e-postayı dikkate almayınız.");
    }
}
