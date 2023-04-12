<?php

namespace App\Notifications;

use App\Notifications\NotificationChannels\MainSms\MainSmsChannel;
use App\Notifications\NotificationChannels\MainSms\MainSmsMessage;
use Illuminate\Bus\Queueable;

class SmsUserCode extends SmsNotification
{
    use Queueable;

    public array $templateArray = [
        'smsCode' => ''
    ];

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MainSmsMessage
     */
    public function toSMS(mixed $notifiable): MainSmsMessage
    {
        return (new MainSmsMessage())->content("{$this->templateArray['smsCode']} - ваш код для входа на rules.su");
    }
}
