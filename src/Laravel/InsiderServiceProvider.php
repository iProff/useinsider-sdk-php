<?php

namespace KaracaTech\UseInsider\Laravel;

use Illuminate\Support\ServiceProvider;
use KaracaTech\UseInsider\Client\InsiderClient;

class InsiderServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/config/insider.php', 'insider');

        $this->app->singleton(InsiderClient::class, function ($app) {
            return new InsiderClient(
                partnerName: config('insider.partner_name'),
                apiKey: config('insider.api_key'),
                config: config('insider.options', [])
            );
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/config/insider.php' => config_path('insider.php'),
            ], 'insider-config');
        }
    }
}
