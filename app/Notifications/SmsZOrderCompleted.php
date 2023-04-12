<?php

namespace App\Notifications;

use App\Notifications\NotificationChannels\MainSms\MainSmsChannel;
use App\Notifications\NotificationChannels\MainSms\MainSmsMessage;
use Illuminate\Bus\Queueable;

class SmsZOrderCompleted extends SmsNotification
{
    use Queueable;

    public array $templateArray = [
        'sum' => ''
    ];

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MainSmsMessage
     */
    public function toSMS(mixed $notifiable): MainSmsMessage
    {
        return (new MainSmsMessage())->content("Заказ на сумму {$this->templateArray['sum']} завершён");
    }
}
