<?php

namespace NotificationChannels\Exponent;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

/**
 * Class ExponentServiceProvider.
 */
class ExponentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->when(ExponentChannel::class)
            ->needs(Client::class)
            ->give(function () {
                return new Client([
                    'base_uri' => config('broadcasting.connections.exponent.url', ExponentChannel::DEFAULT_API_URL),
                ]);
            });
    }
}
