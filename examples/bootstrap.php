<?php

require_once __DIR__.'/../vendor/autoload.php';

use Dotenv\Dotenv;
use Kommandhub\Paystack\Paystack;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Component\HttpClient\Psr18Client;

/**
 * Load .env if it exists
 */
if (file_exists(__DIR__.'/../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__.'/../');
    $dotenv->safeLoad();
}

/**
 * Replace with your secret key from Paystack dashboard
 */
$secretKey = $_ENV['PAYSTACK_SECRET_KEY'] ?? $_SERVER['PAYSTACK_SECRET_KEY'] ?? getenv('PAYSTACK_SECRET_KEY') ?: 'sk_test_your_secret_key';

/**
 * Using Nyholm PSR-7 and Symfony PSR-18 Client for this example.
 * You can use any PSR-18 and PSR-17 implementations.
 */
$psr17Factory = new Psr17Factory;
$httpClient = new Psr18Client;

$paystack = new Paystack(
    $secretKey,
    null,
    $httpClient,
    $psr17Factory,
    $psr17Factory
);

return $paystack;
