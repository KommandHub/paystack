<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Tests;

class SubaccountTest extends ResourceTestCase
{
    public function test_it_can_create_subaccount()
    {
        $payload = [
            'business_name' => 'Test Business',
            'settlement_bank' => '058',
            'account_number' => '0123456789',
            'percentage_charge' => 20,
        ];

        $expectedResponse = [
            'status' => true,
            'message' => 'Subaccount created',
            'data' => array_merge($payload, ['subaccount_code' => 'ACCT_123']),
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->subaccounts()->create($payload);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('POST', $lastRequest->getMethod());
        $this->assertEquals('/subaccount', $lastRequest->getUri()->getPath());
    }

    public function test_it_can_list_subaccounts()
    {
        $expectedResponse = [
            'status' => true,
            'message' => 'Subaccounts retrieved',
            'data' => [],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->subaccounts()->list();

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals('/subaccount', $lastRequest->getUri()->getPath());
    }

    public function test_it_can_fetch_subaccount()
    {
        $code = 'ACCT_123';
        $expectedResponse = [
            'status' => true,
            'message' => 'Subaccount retrieved',
            'data' => ['subaccount_code' => $code],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->subaccounts()->fetch($code);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals("/subaccount/{$code}", $lastRequest->getUri()->getPath());
    }

    public function test_it_can_update_subaccount()
    {
        $code = 'ACCT_123';
        $payload = ['business_name' => 'Updated Business'];
        $expectedResponse = [
            'status' => true,
            'message' => 'Subaccount updated',
            'data' => ['subaccount_code' => $code, 'business_name' => 'Updated Business'],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->subaccounts()->update($code, $payload);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('PUT', $lastRequest->getMethod());
        $this->assertEquals("/subaccount/{$code}", $lastRequest->getUri()->getPath());
    }
}
