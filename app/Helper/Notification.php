<?php

use Illuminate\Notifications\ChannelManager;

if (! function_exists('notify')) {
    function notify()
    {
        return app(ChannelManager::class);
    }
}
