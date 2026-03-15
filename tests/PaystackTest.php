<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Tests;

use Http\Mock\Client;
use Kommandhub\Paystack\Paystack;
use Kommandhub\Paystack\Resources\Customer;
use Kommandhub\Paystack\Resources\Plan;
use Kommandhub\Paystack\Resources\Refund;
use Kommandhub\Paystack\Resources\Split;
use Kommandhub\Paystack\Resources\Subaccount;
use Kommandhub\Paystack\Resources\Subscription;
use Kommandhub\Paystack\Resources\Transaction;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;

class PaystackTest extends TestCase
{
    private Paystack $paystack;

    private Client $mockClient;

    protected function setUp(): void
    {
        $this->mockClient = new Client;
        $psr17Factory = new Psr17Factory;

        $this->paystack = new Paystack(
            'sk_test_123',
            null,
            $this->mockClient,
            $psr17Factory,
            $psr17Factory
        );
    }

    public function test_can_access_transactions_resource()
    {
        $this->assertInstanceOf(Transaction::class, $this->paystack->transactions());
    }

    public function test_can_access_customers_resource()
    {
        $this->assertInstanceOf(Customer::class, $this->paystack->customers());
    }

    public function test_can_access_plans_resource()
    {
        $this->assertInstanceOf(Plan::class, $this->paystack->plans());
    }

    public function test_can_access_splits_resource()
    {
        $this->assertInstanceOf(Split::class, $this->paystack->splits());
    }

    public function test_can_access_subaccounts_resource()
    {
        $this->assertInstanceOf(Subaccount::class, $this->paystack->subaccounts());
    }

    public function test_can_access_subscriptions_resource()
    {
        $this->assertInstanceOf(Subscription::class, $this->paystack->subscriptions());
    }

    public function test_can_access_refunds_resource()
    {
        $this->assertInstanceOf(Refund::class, $this->paystack->refunds());
    }
}
