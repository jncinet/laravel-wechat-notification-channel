<?php

namespace Jncinet\Notifications\Channels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;

class WeChatChannel
{
    /**
     * 发送微信模板消息通知。
     *
     * @param  mixed $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if ($notifiable instanceof Model) {
            $openid = $notifiable->routeNotificationFor('WeChat');
        } elseif ($notifiable instanceof AnonymousNotifiable) {
            if (isset($notifiable->routes['easy-wechat'])) {
                $openid = $notifiable->routes['easy-wechat'];
            } elseif (isset($notifiable->routes[__CLASS__])) {
                $openid = $notifiable->routes[__CLASS__];
            } else {
                return;
            }
        } else {
            return;
        }

        $message = $notification->toWechat($notifiable);
        $message = array_merge(['touser' => $openid], $message);

        app('wechat.official_account')->template_message->send($message);
    }
}