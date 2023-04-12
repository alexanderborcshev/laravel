<?php

namespace App\Notifications;

use App\Notifications\NotificationChannels\MainSms\MainSmsChannel;
use App\Notifications\NotificationChannels\MainSms\MainSmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

abstract class SmsNotification extends Notification
{
    use Queueable;

    public array $templateArray = [];
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $data = [])
    {
        $this->templateArray = array_merge($this->templateArray, $data);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return [MainSmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MainSmsMessage
     */
    public function toSMS(mixed $notifiable): MainSmsMessage
    {
        return (new MainSmsMessage())->content("");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray(mixed $notifiable): array
    {
        return [
            //
        ];
    }
}
