<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Tests;

class TransferTest extends ResourceTestCase
{
    public function test_it_can_create_recipient()
    {
        $payload = [
            'type' => 'nuban',
            'name' => 'John Doe',
            'account_number' => '0000000000',
            'bank_code' => '058',
            'currency' => 'NGN',
        ];

        $expectedResponse = [
            'status' => true,
            'message' => 'Transfer recipient created',
            'data' => ['recipient_code' => 'RCP_123'],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->transfers()->recipient($payload);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('POST', $lastRequest->getMethod());
        $this->assertEquals('/transferrecipient', $lastRequest->getUri()->getPath());
    }

    public function test_it_can_initiate_transfer()
    {
        $payload = [
            'source' => 'balance',
            'amount' => 5000,
            'recipient' => 'RCP_123',
            'reason' => 'Holiday allowance',
        ];

        $expectedResponse = [
            'status' => true,
            'message' => 'Transfer has been queued',
            'data' => ['transfer_code' => 'TRF_123'],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->transfers()->initiate($payload);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('POST', $lastRequest->getMethod());
        $this->assertEquals('/transfer', $lastRequest->getUri()->getPath());
    }

    public function test_it_can_verify_transfer()
    {
        $reference = 'ref_123';
        $expectedResponse = [
            'status' => true,
            'message' => 'Transfer retrieved',
            'data' => ['status' => 'success'],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->transfers()->verify($reference);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals("/transfer/verify/{$reference}", $lastRequest->getUri()->getPath());
    }
}
