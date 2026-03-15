<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Resources;

use Kommandhub\Paystack\Exceptions\PaystackException;

/**
 * Class Split
 */
class Split extends ApiResource
{
    /**
     * Create a split.
     *
     * @throws PaystackException
     */
    public function create(array $payload): array
    {
        return $this->response($this->httpClient->post('/split', $payload));
    }

    /**
     * List splits.
     *
     * @throws PaystackException
     */
    public function list(array $queryParams = []): array
    {
        return $this->response($this->httpClient->get('/split', $queryParams));
    }

    /**
     * Fetch a split.
     *
     * @throws PaystackException
     */
    public function fetch(string $id): array
    {
        return $this->response($this->httpClient->get("/split/{$id}"));
    }

    /**
     * Update a split.
     *
     * @throws PaystackException
     */
    public function update(string $id, array $payload): array
    {
        return $this->response($this->httpClient->put("/split/{$id}", $payload));
    }

    /**
     * Add a subaccount to a split.
     */
    public function addSubaccount(string $id, array $payload): array
    {
        return $this->response($this->httpClient->post("/split/{$id}/subaccount/add", $payload));
    }

    /**
     * Remove a subaccount from a split.
     */
    public function removeSubaccount(string $id, array $payload): array
    {
        return $this->response($this->httpClient->post("/split/{$id}/subaccount/remove", $payload));
    }
}
