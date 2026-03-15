<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Resources;

use Kommandhub\Paystack\Exceptions\PaystackException;

/**
 * Class Transaction
 */
class Transaction extends ApiResource
{
    /**
     * Initialize a transaction.
     *
     * @throws PaystackException
     */
    public function initialize(array $payload): array
    {
        return $this->response($this->httpClient->post('/transaction/initialize', $payload));
    }

    /**
     * Verify a transaction.
     *
     * @throws PaystackException
     */
    public function verify(string $reference): array
    {
        return $this->response($this->httpClient->get("/transaction/verify/{$reference}"));
    }

    /**
     * List transactions.
     *
     * @throws PaystackException
     */
    public function list(array $queryParams = []): array
    {
        return $this->response($this->httpClient->get('/transaction', $queryParams));
    }

    /**
     * Fetch a transaction.
     *
     * @throws PaystackException
     */
    public function fetch(string $id): array
    {
        return $this->response($this->httpClient->get("/transaction/{$id}"));
    }
}
