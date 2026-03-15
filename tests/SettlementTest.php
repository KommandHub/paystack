<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Tests;

class SettlementTest extends ResourceTestCase
{
    public function test_it_can_list_settlements()
    {
        $expectedResponse = [
            'status' => true,
            'message' => 'Settlements retrieved',
            'data' => [],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->settlements()->list();

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals('/settlement', $lastRequest->getUri()->getPath());
    }

    public function test_it_can_fetch_settlement_transactions()
    {
        $id = '123';
        $expectedResponse = [
            'status' => true,
            'message' => 'Transactions retrieved',
            'data' => [],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->settlements()->transactions($id);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals("/settlement/{$id}/transaction", $lastRequest->getUri()->getPath());
    }
}
