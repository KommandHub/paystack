<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Laravel;

use Illuminate\Support\ServiceProvider;
use Kommandhub\Paystack\Paystack;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class PaystackServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/paystack.php', 'paystack');

        $this->app->singleton(Paystack::class, function ($app) {
            $config = $app['config']->get('paystack');

            return new Paystack(
                $config['secret_key'] ?? '',
                null,
                $app->make(ClientInterface::class),
                $app->make(RequestFactoryInterface::class),
                $app->make(StreamFactoryInterface::class)
            );
        });

        $this->app->alias(Paystack::class, 'paystack');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/paystack.php' => config_path('paystack.php'),
            ], 'paystack-config');
        }
    }
}
