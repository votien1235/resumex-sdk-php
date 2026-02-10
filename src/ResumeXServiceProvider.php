<?php

namespace ResumeX;

use Illuminate\Support\ServiceProvider;

class ResumeXServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Merge config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/resumex.php',
            'resumex'
        );

        // Register the client as a singleton
        $this->app->singleton('resumex', function ($app) {
            return new Client([
                'api_key' => config('resumex.api_key'),
                'api_secret' => config('resumex.api_secret'),
                'environment' => config('resumex.environment', 'production'),
                'base_url' => config('resumex.base_url'),
                'sandbox_url' => config('resumex.sandbox_url'),
                'timeout' => config('resumex.timeout', 30),
            ]);
        });

        // Alias for the client
        $this->app->alias('resumex', Client::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish config file
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/resumex.php' => config_path('resumex.php'),
            ], 'resumex-config');
        }
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return ['resumex', Client::class];
    }
}
