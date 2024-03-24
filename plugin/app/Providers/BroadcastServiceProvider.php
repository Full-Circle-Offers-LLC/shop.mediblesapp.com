<?php

namespace MyYouTubeApp\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any SaaS application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes();

        require base_path('cashbot.app/#routes/channels.php');
    }
}
