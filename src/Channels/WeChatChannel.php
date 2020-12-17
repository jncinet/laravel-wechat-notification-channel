<?php

namespace Jncinet\Notifications\Channels;

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
        if (! $openid = $notifiable->routeNotificationFor('WeChat')) {
            return;
        }

        $message = $notification->toWechat($notifiable);
        $message = array_merge(['touser' => $openid], $message);

        app('wechat.official_account')->template_message->send($message);
    }
}