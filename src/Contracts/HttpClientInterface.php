<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Contracts;

use Kommandhub\Paystack\Exceptions\PaystackException;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface HttpClientInterface
 */
interface HttpClientInterface
{
    /**
     * Send a GET request.
     *
     *
     * @throws PaystackException
     */
    public function get(string $endpoint, array $queryParams = []): ResponseInterface;

    /**
     * Send a POST request.
     *
     *
     * @throws PaystackException
     */
    public function post(string $endpoint, array $payload = []): ResponseInterface;

    /**
     * Send a PUT request.
     *
     *
     * @throws PaystackException
     */
    public function put(string $endpoint, array $payload = []): ResponseInterface;

    /**
     * Send a DELETE request.
     *
     *
     * @throws PaystackException
     */
    public function delete(string $endpoint): ResponseInterface;
}
