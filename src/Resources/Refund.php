<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Resources;

use Kommandhub\Paystack\Exceptions\PaystackException;

/**
 * Class Refund
 */
class Refund extends ApiResource
{
    /**
     * Create a refund.
     *
     * @throws PaystackException
     */
    public function create(array $payload): array
    {
        return $this->response($this->httpClient->post('/refund', $payload));
    }

    /**
     * List refunds.
     *
     * @throws PaystackException
     */
    public function list(array $queryParams = []): array
    {
        return $this->response($this->httpClient->get('/refund', $queryParams));
    }

    /**
     * Fetch a refund.
     *
     * @throws PaystackException
     */
    public function fetch(string $reference): array
    {
        return $this->response($this->httpClient->get("/refund/{$reference}"));
    }
}
