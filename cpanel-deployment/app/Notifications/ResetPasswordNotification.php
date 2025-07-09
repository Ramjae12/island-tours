<?php
namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends BaseResetPassword
{
    public function toMail($notifiable)
    {
        $url = $this->resetUrl($notifiable);
        return (new MailMessage)
            ->subject('Reset Your Password - Island Tours')
            ->view('mail.auth.reset-password', [
                'url' => $url,
                'notifiable' => $notifiable,
                'logo' => asset('image/corlogo.png'),
            ]);
    }
}
