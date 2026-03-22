<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Resources;

use Kommandhub\Paystack\Contracts\HttpClientInterface;

/**
 * Class ApiResource
 */
abstract class ApiResource
{
    /**
     * ApiResource constructor.
     */
    public function __construct(protected HttpClientInterface $httpClient)
    {
    }

    /**
     * Parse the response from the API.
     */
    protected function response(mixed $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
