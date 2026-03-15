<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Resources;

use Kommandhub\Paystack\Exceptions\PaystackException;

/**
 * Class Customer
 */
class Customer extends ApiResource
{
    /**
     * Create a customer.
     *
     * @throws PaystackException
     */
    public function create(array $payload): array
    {
        return $this->response($this->httpClient->post('/customer', $payload));
    }

    /**
     * List customers.
     *
     * @throws PaystackException
     */
    public function list(array $queryParams = []): array
    {
        return $this->response($this->httpClient->get('/customer', $queryParams));
    }

    /**
     * Fetch a customer.
     *
     * @throws PaystackException
     */
    public function fetch(string $emailOrCode): array
    {
        return $this->response($this->httpClient->get("/customer/{$emailOrCode}"));
    }

    /**
     * Update a customer.
     *
     * @throws PaystackException
     */
    public function update(string $code, array $payload): array
    {
        return $this->response($this->httpClient->put("/customer/{$code}", $payload));
    }
}
