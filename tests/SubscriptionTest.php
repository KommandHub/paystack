<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Tests;

class SubscriptionTest extends ResourceTestCase
{
    public function test_it_can_create_subscription()
    {
        $payload = [
            'customer' => 'CUST_123',
            'plan' => 'PLN_123',
        ];

        $expectedResponse = [
            'status' => true,
            'message' => 'Subscription created',
            'data' => array_merge($payload, ['subscription_code' => 'SUB_123']),
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->subscriptions()->create($payload);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('POST', $lastRequest->getMethod());
        $this->assertEquals('/subscription', $lastRequest->getUri()->getPath());
    }

    public function test_it_can_list_subscriptions()
    {
        $expectedResponse = [
            'status' => true,
            'message' => 'Subscriptions retrieved',
            'data' => [],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->subscriptions()->list();

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals('/subscription', $lastRequest->getUri()->getPath());
    }

    public function test_it_can_fetch_subscription()
    {
        $code = 'SUB_123';
        $expectedResponse = [
            'status' => true,
            'message' => 'Subscription retrieved',
            'data' => ['subscription_code' => $code],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->subscriptions()->fetch($code);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals("/subscription/{$code}", $lastRequest->getUri()->getPath());
    }

    public function test_it_can_enable_subscription()
    {
        $payload = ['code' => 'SUB_123', 'token' => 'TOK_123'];
        $expectedResponse = ['status' => true, 'message' => 'Subscription enabled'];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->subscriptions()->enable($payload);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('POST', $lastRequest->getMethod());
        $this->assertEquals('/subscription/enable', $lastRequest->getUri()->getPath());
    }

    public function test_it_can_disable_subscription()
    {
        $payload = ['code' => 'SUB_123', 'token' => 'TOK_123'];
        $expectedResponse = ['status' => true, 'message' => 'Subscription disabled'];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->subscriptions()->disable($payload);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('POST', $lastRequest->getMethod());
        $this->assertEquals('/subscription/disable', $lastRequest->getUri()->getPath());
    }

    public function test_it_can_get_manage_link()
    {
        $code = 'SUB_123';
        $expectedResponse = [
            'status' => true,
            'message' => 'Link generated',
            'data' => ['link' => 'https://paystack.com/manage'],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->subscriptions()->manageLink($code);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals("/subscription/{$code}/manage/link", $lastRequest->getUri()->getPath());
    }

    public function test_it_can_send_manage_link()
    {
        $code = 'SUB_123';
        $expectedResponse = ['status' => true, 'message' => 'Email sent'];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->subscriptions()->sendManageLink($code);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('POST', $lastRequest->getMethod());
        $this->assertEquals("/subscription/{$code}/manage/email", $lastRequest->getUri()->getPath());
    }
}
