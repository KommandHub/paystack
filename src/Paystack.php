<?php

declare(strict_types=1);

namespace Kommandhub\Paystack;

use Kommandhub\Paystack\Contracts\HttpClientInterface;
use Kommandhub\Paystack\Http\PsrHttpClient;
use Kommandhub\Paystack\Resources\Customer;
use Kommandhub\Paystack\Resources\Miscellaneous;
use Kommandhub\Paystack\Resources\Plan;
use Kommandhub\Paystack\Resources\Refund;
use Kommandhub\Paystack\Resources\Settlement;
use Kommandhub\Paystack\Resources\Split;
use Kommandhub\Paystack\Resources\Subaccount;
use Kommandhub\Paystack\Resources\Subscription;
use Kommandhub\Paystack\Resources\Transaction;
use Kommandhub\Paystack\Resources\Transfer;
use Kommandhub\Paystack\Resources\Verification;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Class Paystack
 */
class Paystack
{
    private HttpClientInterface $httpClient;

    /**
     * Paystack constructor.
     *
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(
        string $secretKey,
        ?HttpClientInterface $httpClient = null,
        ?ClientInterface $client = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null
    ) {
        if ($httpClient === null) {
            if ($client === null || $requestFactory === null || $streamFactory === null) {
                throw new \InvalidArgumentException(
                    'You must provide either an implementation of HttpClientInterface or '.
                    'PSR-18 Client, PSR-17 RequestFactory, and PSR-17 StreamFactory.'
                );
            }
            $httpClient = new PsrHttpClient($secretKey, $client, $requestFactory, $streamFactory);
        }

        $this->httpClient = $httpClient;
    }

    /**
     * Get the transactions resource.
     */
    public function transactions(): Transaction
    {
        return new Transaction($this->httpClient);
    }

    /**
     * Get the customers resource.
     */
    public function customers(): Customer
    {
        return new Customer($this->httpClient);
    }

    /**
     * Get the plans resource.
     */
    public function plans(): Plan
    {
        return new Plan($this->httpClient);
    }

    /**
     * Get the splits resource.
     */
    public function splits(): Split
    {
        return new Split($this->httpClient);
    }

    /**
     * Get the subaccounts resource.
     */
    public function subaccounts(): Subaccount
    {
        return new Subaccount($this->httpClient);
    }

    /**
     * Get the subscriptions resource.
     */
    public function subscriptions(): Subscription
    {
        return new Subscription($this->httpClient);
    }

    /**
     * Get the refunds resource.
     */
    public function refunds(): Refund
    {
        return new Refund($this->httpClient);
    }

    /**
     * Get the miscellaneous resource.
     */
    public function miscellaneous(): Miscellaneous
    {
        return new Miscellaneous($this->httpClient);
    }

    /**
     * Get the transfers resource.
     */
    public function transfers(): Transfer
    {
        return new Transfer($this->httpClient);
    }

    /**
     * Get the settlements resource.
     */
    public function settlements(): Settlement
    {
        return new Settlement($this->httpClient);
    }

    /**
     * Get the verification resource.
     */
    public function verification(): Verification
    {
        return new Verification($this->httpClient);
    }
}
