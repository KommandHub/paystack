<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Tests;

class PlanTest extends ResourceTestCase
{
    public function test_it_can_create_plan()
    {
        $payload = [
            'name' => 'Monthly Plan',
            'interval' => 'monthly',
            'amount' => 10000,
        ];

        $expectedResponse = [
            'status' => true,
            'message' => 'Plan created',
            'data' => array_merge($payload, ['plan_code' => 'PLN_123']),
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->plans()->create($payload);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('POST', $lastRequest->getMethod());
        $this->assertEquals('/plan', $lastRequest->getUri()->getPath());
    }

    public function test_it_can_list_plans()
    {
        $expectedResponse = [
            'status' => true,
            'message' => 'Plans retrieved',
            'data' => [],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->plans()->list();

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals('/plan', $lastRequest->getUri()->getPath());
    }

    public function test_it_can_fetch_plan()
    {
        $code = 'PLN_123';
        $expectedResponse = [
            'status' => true,
            'message' => 'Plan retrieved',
            'data' => ['plan_code' => $code],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->plans()->fetch($code);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals("/plan/{$code}", $lastRequest->getUri()->getPath());
    }

    public function test_it_can_update_plan()
    {
        $code = 'PLN_123';
        $payload = ['name' => 'Updated Plan'];
        $expectedResponse = [
            'status' => true,
            'message' => 'Plan updated',
            'data' => ['plan_code' => $code, 'name' => 'Updated Plan'],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->plans()->update($code, $payload);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('PUT', $lastRequest->getMethod());
        $this->assertEquals("/plan/{$code}", $lastRequest->getUri()->getPath());
    }
}
