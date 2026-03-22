<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Http;

use Kommandhub\Paystack\Contracts\HttpClientInterface;
use Kommandhub\Paystack\Exceptions\PaystackException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Class PsrHttpClient
 */
class PsrHttpClient implements HttpClientInterface
{
    private const BASE_URL = 'https://api.paystack.co';

    /**
     * PsrHttpClient constructor.
     */
    public function __construct(
        private readonly string $secretKey,
        private readonly ClientInterface $client,
        private readonly RequestFactoryInterface $requestFactory,
        private readonly StreamFactoryInterface $streamFactory
    ) {
    }

    /**
     * Send a GET request.
     *
     *
     * @throws PaystackException
     */
    public function get(string $endpoint, array $queryParams = []): ResponseInterface
    {
        try {
            $url = self::BASE_URL.$endpoint;
            if (! empty($queryParams)) {
                $url .= '?'.http_build_query($queryParams);
            }

            $request = $this->requestFactory->createRequest('GET', $url)
                ->withHeader('Authorization', 'Bearer '.$this->secretKey)
                ->withHeader('Content-Type', 'application/json');

            return $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new PaystackException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Send a POST request.
     *
     *
     * @throws PaystackException
     */
    public function post(string $endpoint, array $payload = []): ResponseInterface
    {
        try {
            $url = self::BASE_URL.$endpoint;
            $body = $this->streamFactory->createStream(json_encode($payload));

            $request = $this->requestFactory->createRequest('POST', $url)
                ->withHeader('Authorization', 'Bearer '.$this->secretKey)
                ->withHeader('Content-Type', 'application/json')
                ->withBody($body);

            return $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new PaystackException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Send a PUT request.
     *
     *
     * @throws PaystackException
     */
    public function put(string $endpoint, array $payload = []): ResponseInterface
    {
        try {
            $url = self::BASE_URL.$endpoint;
            $body = $this->streamFactory->createStream(json_encode($payload));

            $request = $this->requestFactory->createRequest('PUT', $url)
                ->withHeader('Authorization', 'Bearer '.$this->secretKey)
                ->withHeader('Content-Type', 'application/json')
                ->withBody($body);

            return $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new PaystackException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Send a DELETE request.
     *
     *
     * @throws PaystackException
     */
    public function delete(string $endpoint): ResponseInterface
    {
        try {
            $url = self::BASE_URL.$endpoint;

            $request = $this->requestFactory->createRequest('DELETE', $url)
                ->withHeader('Authorization', 'Bearer '.$this->secretKey)
                ->withHeader('Content-Type', 'application/json');

            return $this->client->sendRequest($request);
        } catch (ClientExceptionInterface $e) {
            throw new PaystackException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
