<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Tests;

use Kommandhub\Paystack\Laravel\Facades\Paystack as PaystackFacade;
use Kommandhub\Paystack\Laravel\PaystackServiceProvider;
use Kommandhub\Paystack\Paystack;
use Kommandhub\Paystack\Resources\Transaction;
use Mockery;
use Orchestra\Testbench\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

class LaravelIntegrationTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            PaystackServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Paystack' => PaystackFacade::class,
        ];
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('paystack.secret_key', 'sk_test_123');

        // Bind PSR interfaces for the service provider to use
        $app->bind(ClientInterface::class, function () {
            return Mockery::mock(ClientInterface::class);
        });
        $app->bind(RequestFactoryInterface::class, function () {
            return Mockery::mock(RequestFactoryInterface::class);
        });
        $app->bind(StreamFactoryInterface::class, function () {
            return Mockery::mock(StreamFactoryInterface::class);
        });
    }

    public function test_it_can_resolve_paystack_from_container()
    {
        $paystack = $this->app->make(Paystack::class);
        $this->assertInstanceOf(Paystack::class, $paystack);
    }

    public function test_it_can_resolve_paystack_using_alias()
    {
        $paystack = $this->app->make('paystack');
        $this->assertInstanceOf(Paystack::class, $paystack);
    }

    public function test_facade_works()
    {
        $this->assertInstanceOf(Transaction::class, PaystackFacade::transactions());
    }

    public function test_it_uses_config_values()
    {
        /** @var Paystack $paystack */
        $paystack = $this->app->make(Paystack::class);

        $reflection = new \ReflectionClass($paystack);
        $httpClientProp = $reflection->getProperty('httpClient');
        $httpClientProp->setAccessible(true);
        $httpClient = $httpClientProp->getValue($paystack);

        $reflectionHttp = new \ReflectionClass($httpClient);
        $secretKeyProp = $reflectionHttp->getProperty('secretKey');
        $secretKeyProp->setAccessible(true);

        $this->assertEquals('sk_test_123', $secretKeyProp->getValue($httpClient));
    }
}
