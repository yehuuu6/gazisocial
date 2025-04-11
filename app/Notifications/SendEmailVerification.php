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
     * Get the mail message for verification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // Generate a new verification code
        $code = $notifiable->generateVerificationCode();

        // Create the code HTML for the email
        $codeHtml = <<<HTML
<div style="text-align: center; margin: 15px 0;">
    <div style="display: inline-block; background-color: #f7f9fc; border: 1px solid #e1e4e8; border-radius: 6px; padding: 16px 24px; margin: 15px 0;">
        <span style="font-family: 'Courier New', monospace; font-size: 32px; font-weight: 700; letter-spacing: 3px; color: #3498db;">{$code}</span>
    </div>
</div>
HTML;

        return (new MailMessage)
            ->subject("E-posta Adresinizi Doğrulayın")
            ->line("Gazi Social'a hoş geldiniz! Hesabınızı etkinleştirmek için aşağıdaki doğrulama kodunu kullanın.")
            ->line(new \Illuminate\Support\HtmlString($codeHtml))
            ->line("Bu kod 24 saat boyunca geçerlidir.")
            ->line(
                "Eğer bu hesabı siz oluşturmadıysanız, lütfen bu e-postayı dikkate almayınız."
            );
    }
}
