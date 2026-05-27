<?php

declare(strict_types=1);

namespace Mivo\LaravelMikrotikRos7;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class MikrotikRos7ServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/mikrotik-ros7.php',
            'mikrotik-ros7'
        );

        $this->app->singleton('mikrotik.ros7', function (Application $app) {
            return new MikrotikManager($app);
        });

        // Register alias for the Manager
        $this->app->alias('mikrotik.ros7', MikrotikManager::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/mikrotik-ros7.php' => config_path('mikrotik-ros7.php'),
            ], 'mikrotik-ros7-config');
        }
    }
}
