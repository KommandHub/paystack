<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Tests;

class RefundTest extends ResourceTestCase
{
    public function test_it_can_create_refund()
    {
        $payload = [
            'transaction' => 'ref_123',
            'amount' => 5000,
        ];

        $expectedResponse = [
            'status' => true,
            'message' => 'Refund successful',
            'data' => array_merge($payload, ['id' => 'RFD_123']),
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->refunds()->create($payload);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('POST', $lastRequest->getMethod());
        $this->assertEquals('/refund', $lastRequest->getUri()->getPath());
    }

    public function test_it_can_list_refunds()
    {
        $expectedResponse = [
            'status' => true,
            'message' => 'Refunds retrieved',
            'data' => [],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->refunds()->list();

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals('/refund', $lastRequest->getUri()->getPath());
    }

    public function test_it_can_fetch_refund()
    {
        $reference = 'RFD_123';
        $expectedResponse = [
            'status' => true,
            'message' => 'Refund retrieved',
            'data' => ['id' => $reference],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->refunds()->fetch($reference);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals("/refund/{$reference}", $lastRequest->getUri()->getPath());
    }
}
