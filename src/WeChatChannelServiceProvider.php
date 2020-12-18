<?php

namespace Jncinet\Notifications;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Jncinet\Notifications\Channels\WeChatChannel;

class WeChatChannelServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('easy-wechat', function () {
                return new WeChatChannel();
            });
        });
    }
}