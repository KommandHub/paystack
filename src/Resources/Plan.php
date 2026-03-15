<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Resources;

use Kommandhub\Paystack\Exceptions\PaystackException;

/**
 * Class Plan
 */
class Plan extends ApiResource
{
    /**
     * Create a plan.
     *
     * @throws PaystackException
     */
    public function create(array $payload): array
    {
        return $this->response($this->httpClient->post('/plan', $payload));
    }

    /**
     * List plans.
     *
     * @throws PaystackException
     */
    public function list(array $queryParams = []): array
    {
        return $this->response($this->httpClient->get('/plan', $queryParams));
    }

    /**
     * Fetch a plan.
     *
     * @throws PaystackException
     */
    public function fetch(string $idOrCode): array
    {
        return $this->response($this->httpClient->get("/plan/{$idOrCode}"));
    }

    /**
     * Update a plan.
     *
     * @throws PaystackException
     */
    public function update(string $idOrCode, array $payload): array
    {
        return $this->response($this->httpClient->put("/plan/{$idOrCode}", $payload));
    }
}
