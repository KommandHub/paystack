<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Tests;

class CustomerTest extends ResourceTestCase
{
    public function test_it_can_create_customer()
    {
        $payload = [
            'email' => 'customer@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
        ];

        $expectedResponse = [
            'status' => true,
            'message' => 'Customer created',
            'data' => array_merge($payload, ['customer_code' => 'CUST_123']),
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->customers()->create($payload);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('POST', $lastRequest->getMethod());
        $this->assertEquals('/customer', $lastRequest->getUri()->getPath());
    }

    public function test_it_can_list_customers()
    {
        $expectedResponse = [
            'status' => true,
            'message' => 'Customers retrieved',
            'data' => [],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->customers()->list();

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals('/customer', $lastRequest->getUri()->getPath());
    }

    public function test_it_can_fetch_customer()
    {
        $code = 'CUST_123';
        $expectedResponse = [
            'status' => true,
            'message' => 'Customer retrieved',
            'data' => ['customer_code' => $code],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->customers()->fetch($code);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals("/customer/{$code}", $lastRequest->getUri()->getPath());
    }

    public function test_it_can_update_customer()
    {
        $code = 'CUST_123';
        $payload = ['first_name' => 'Jane'];
        $expectedResponse = [
            'status' => true,
            'message' => 'Customer updated',
            'data' => ['customer_code' => $code, 'first_name' => 'Jane'],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->customers()->update($code, $payload);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('PUT', $lastRequest->getMethod());
        $this->assertEquals("/customer/{$code}", $lastRequest->getUri()->getPath());
        $this->assertEquals(json_encode($payload), (string) $lastRequest->getBody());
    }
}
