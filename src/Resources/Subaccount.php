<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Resources;

use Kommandhub\Paystack\Exceptions\PaystackException;

/**
 * Class Subaccount
 */
class Subaccount extends ApiResource
{
    /**
     * Create a subaccount.
     *
     * @throws PaystackException
     */
    public function create(array $payload): array
    {
        return $this->response($this->httpClient->post('/subaccount', $payload));
    }

    /**
     * List subaccounts.
     *
     * @throws PaystackException
     */
    public function list(array $queryParams = []): array
    {
        return $this->response($this->httpClient->get('/subaccount', $queryParams));
    }

    /**
     * Fetch a subaccount.
     *
     * @throws PaystackException
     */
    public function fetch(string $idOrCode): array
    {
        return $this->response($this->httpClient->get("/subaccount/{$idOrCode}"));
    }

    /**
     * Update a subaccount.
     *
     * @throws PaystackException
     */
    public function update(string $idOrCode, array $payload): array
    {
        return $this->response($this->httpClient->put("/subaccount/{$idOrCode}", $payload));
    }
}
