<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Tests;

class MiscellaneousTest extends ResourceTestCase
{
    public function test_can_list_banks()
    {
        $this->mockClient->addResponse($this->createResponse(['status' => true, 'data' => []]));

        $response = $this->paystack->miscellaneous()->listBanks(['country' => 'nigeria']);

        $this->assertTrue($response['status']);
        $this->assertEquals('GET', $this->mockClient->getLastRequest()->getMethod());
        $this->assertStringContainsString('/bank?country=nigeria', (string) $this->mockClient->getLastRequest()->getUri());
    }

    public function test_can_list_countries()
    {
        $this->mockClient->addResponse($this->createResponse(['status' => true, 'data' => []]));

        $response = $this->paystack->miscellaneous()->listCountries();

        $this->assertTrue($response['status']);
        $this->assertEquals('GET', $this->mockClient->getLastRequest()->getMethod());
        $this->assertStringContainsString('/country', (string) $this->mockClient->getLastRequest()->getUri());
    }

    public function test_can_list_states()
    {
        $this->mockClient->addResponse($this->createResponse(['status' => true, 'data' => []]));

        $response = $this->paystack->miscellaneous()->listStates('CA');

        $this->assertTrue($response['status']);
        $this->assertEquals('GET', $this->mockClient->getLastRequest()->getMethod());
        $this->assertStringContainsString('/address_verification/states?country=CA', (string) $this->mockClient->getLastRequest()->getUri());
    }
}
