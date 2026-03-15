<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Tests;

class TransactionTest extends ResourceTestCase
{
    public function test_it_can_initialize_transaction()
    {
        $payload = [
            'amount' => 5000,
            'email' => 'test@example.com',
        ];

        $expectedResponse = [
            'status' => true,
            'message' => 'Authorization URL created',
            'data' => [
                'authorization_url' => 'https://checkout.paystack.com/code',
                'access_code' => 'code',
                'reference' => 'ref',
            ],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->transactions()->initialize($payload);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('POST', $lastRequest->getMethod());
        $this->assertEquals('/transaction/initialize', $lastRequest->getUri()->getPath());
        $this->assertEquals(json_encode($payload), (string) $lastRequest->getBody());
    }

    public function test_it_can_verify_transaction()
    {
        $reference = 'ref';
        $expectedResponse = [
            'status' => true,
            'message' => 'Verification successful',
            'data' => [
                'status' => 'success',
                'reference' => $reference,
            ],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->transactions()->verify($reference);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals("/transaction/verify/{$reference}", $lastRequest->getUri()->getPath());
    }

    public function test_it_can_list_transactions()
    {
        $expectedResponse = [
            'status' => true,
            'message' => 'Transactions retrieved',
            'data' => [],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->transactions()->list(['perPage' => 10]);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals('/transaction', $lastRequest->getUri()->getPath());
        $this->assertEquals('perPage=10', $lastRequest->getUri()->getQuery());
    }

    public function test_it_can_fetch_transaction()
    {
        $id = '123';
        $expectedResponse = [
            'status' => true,
            'message' => 'Transaction retrieved',
            'data' => ['id' => $id],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->transactions()->fetch($id);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals("/transaction/{$id}", $lastRequest->getUri()->getPath());
    }
}
