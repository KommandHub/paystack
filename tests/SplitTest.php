<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Tests;

class SplitTest extends ResourceTestCase
{
    public function test_it_can_create_split()
    {
        $payload = [
            'name' => 'Split Plan',
            'type' => 'percentage',
            'currency' => 'NGN',
        ];

        $expectedResponse = [
            'status' => true,
            'message' => 'Split created',
            'data' => array_merge($payload, ['id' => '123']),
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->splits()->create($payload);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('POST', $lastRequest->getMethod());
        $this->assertEquals('/split', $lastRequest->getUri()->getPath());
    }

    public function test_it_can_list_splits()
    {
        $expectedResponse = [
            'status' => true,
            'message' => 'Splits retrieved',
            'data' => [],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->splits()->list();

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals('/split', $lastRequest->getUri()->getPath());
    }

    public function test_it_can_fetch_split()
    {
        $id = '123';
        $expectedResponse = [
            'status' => true,
            'message' => 'Split retrieved',
            'data' => ['id' => $id],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->splits()->fetch($id);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals("/split/{$id}", $lastRequest->getUri()->getPath());
    }

    public function test_it_can_update_split()
    {
        $id = '123';
        $payload = ['active' => false];
        $expectedResponse = [
            'status' => true,
            'message' => 'Split updated',
            'data' => ['id' => $id, 'active' => false],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->splits()->update($id, $payload);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('PUT', $lastRequest->getMethod());
        $this->assertEquals("/split/{$id}", $lastRequest->getUri()->getPath());
    }

    public function test_it_can_add_subaccount_to_split()
    {
        $id = '123';
        $payload = ['subaccount' => 'ACCT_123', 'share' => 20];
        $expectedResponse = [
            'status' => true,
            'message' => 'Subaccount added',
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->splits()->addSubaccount($id, $payload);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('POST', $lastRequest->getMethod());
        $this->assertEquals("/split/{$id}/subaccount/add", $lastRequest->getUri()->getPath());
    }

    public function test_it_can_remove_subaccount_from_split()
    {
        $id = '123';
        $payload = ['subaccount' => 'ACCT_123'];
        $expectedResponse = [
            'status' => true,
            'message' => 'Subaccount removed',
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->splits()->removeSubaccount($id, $payload);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('POST', $lastRequest->getMethod());
        $this->assertEquals("/split/{$id}/subaccount/remove", $lastRequest->getUri()->getPath());
    }
}
