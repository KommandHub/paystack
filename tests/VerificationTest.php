<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Tests;

class VerificationTest extends ResourceTestCase
{
    public function test_it_can_resolve_account()
    {
        $accountNumber = '0001234567';
        $bankCode = '058';
        $expectedResponse = [
            'status' => true,
            'message' => 'Account number resolved',
            'data' => [
                'account_number' => $accountNumber,
                'account_name' => 'John Doe',
            ],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->verification()->resolveAccount($accountNumber, $bankCode);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals('/bank/resolve', $lastRequest->getUri()->getPath());
        $this->assertEquals("account_number={$accountNumber}&bank_code={$bankCode}", $lastRequest->getUri()->getQuery());
    }

    public function test_it_can_resolve_card_bin()
    {
        $bin = '539983';
        $expectedResponse = [
            'status' => true,
            'message' => 'Bin resolved',
            'data' => ['bin' => $bin],
        ];

        $this->mockClient->addResponse($this->createResponse($expectedResponse));

        $response = $this->paystack->verification()->resolveCardBin($bin);

        $this->assertEquals($expectedResponse, $response);
        $lastRequest = $this->mockClient->getLastRequest();
        $this->assertEquals('GET', $lastRequest->getMethod());
        $this->assertEquals("/decision/bin/{$bin}", $lastRequest->getUri()->getPath());
    }
}
