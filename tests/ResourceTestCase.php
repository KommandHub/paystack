<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Tests;

use Http\Mock\Client;
use Kommandhub\Paystack\Paystack;
use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;

abstract class ResourceTestCase extends TestCase
{
    protected Paystack $paystack;

    protected Client $mockClient;

    protected Psr17Factory $psr17Factory;

    protected function setUp(): void
    {
        $this->mockClient = new Client();
        $this->psr17Factory = new Psr17Factory();

        $this->paystack = new Paystack(
            'sk_test_123',
            null,
            $this->mockClient,
            $this->psr17Factory,
            $this->psr17Factory
        );
    }

    protected function createResponse(array $data, int $status = 200)
    {
        return $this->psr17Factory->createResponse($status)
            ->withBody($this->psr17Factory->createStream(json_encode($data)));
    }
}
