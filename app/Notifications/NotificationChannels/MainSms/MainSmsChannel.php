<?php

namespace App\Notifications\NotificationChannels\MainSms;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class MainSmsChannel
{
    protected MainSmsClient $client;
    protected string $sender = 'zemsbaza.ru';

    public function __construct()
    {
        $this->client = new MainSmsClient(env('MAIN_SMS_PROJECT'), env('MAIN_SMS_KEY'), true, env('MAIN_SMS_TEST_MODE'));
    }
    /**
     * Отправить переданное уведомление.
     *
     * @param  mixed  $notifiable
     * @param Notification $notification
     * @return bool|int
     */
    public function send(mixed $notifiable, Notification $notification): bool|int
    {
        $result = false;
        $message = $notification->toSMS($notifiable);
        if($to = $notifiable->routeNotificationFor('MainSms')){
            $message->to($to);
            $result = $this->client->messageSend($message->data['to'], $message->data['content'],$this->sender);
            Log::channel('sms')->info('SMS - '.$notification::class, (array) $message);
            Log::channel('sms')->info('',$this->client->getResponse());
        }

        return $result;
    }
}
