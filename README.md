# Paystack PHP Library

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kommandhub/paystack.svg?style=flat-square)](https://packagist.org/packages/kommandhub/paystack)
[![Total Downloads](https://img.shields.io/packagist/dt/kommandhub/paystack.svg?style=flat-square)](https://packagist.org/packages/kommandhub/paystack)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

![Paystack PHP Library Banner](paystack.png)

A framework-agnostic PHP library for integrating Paystack payments using SOLID principles and PSR standards. This library provides a clean, object-oriented interface to the Paystack API while remaining flexible enough to work in any PHP environment.

## Table of Contents
- [Installation](#installation)
- [Basic Usage](#basic-usage)
  - [Initialization](#initialization)
  - [Using Guzzle and Nyholm PSR-7](#using-guzzle-and-nyholm-psr-7)
- [Resources](#resources)
  - [Transactions](#transactions)
  - [Customers](#customers)
  - [Transfers](#transfers)
  - [Subscriptions](#subscriptions)
  - [Plans](#plans)
  - [Splits](#splits)
  - [Subaccounts](#subaccounts)
  - [Refunds](#refunds)
  - [Verification](#verification)
  - [Settlements](#settlements)
  - [Miscellaneous](#miscellaneous)
- [Laravel Integration](#laravel-integration)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

---

## Installation

You can install the package via composer:

```bash
composer require kommandhub/paystack
```

### Requirements
This library is framework-agnostic and relies on PSR-18 (HTTP Client) and PSR-17 (HTTP Factories) interfaces. You will need to provide your own implementations, such as Guzzle or Symfony HTTP Client.

If you don't have these already, you can install popular implementations:

```bash
composer require guzzlehttp/guzzle nyholm/psr7
```

## Basic Usage

### Initialization

To use the library, instantiate the `Paystack` gateway class with your secret key and PSR-18/17 implementations.

```php
use Kommandhub\Paystack\Paystack;

$paystack = new Paystack(
    secretKey: 'your_secret_key_here',
    client: $psr18Client,         // Instance of Psr\Http\Client\ClientInterface
    requestFactory: $psr17Factory, // Instance of Psr\Http\Message\RequestFactoryInterface
    streamFactory: $psr17Factory   // Instance of Psr\Http\Message\StreamFactoryInterface
);
```

### Using Guzzle and Nyholm PSR-7

```php
use Kommandhub\Paystack\Paystack;
use GuzzleHttp\Client;
use Nyholm\Psr7\Factory\Psr17Factory;

$secretKey = 'your-secret-key';
$client = new Client();
$factory = new Psr17Factory();

$paystack = new Paystack(
    $secretKey,
    null,
    $client,
    $factory,
    $factory
);
```

---

## Resources

### Transactions

Handle payment initialization, verification, and retrieval.

```php
// Initialize a transaction
$response = $paystack->transactions()->initialize([
    'amount' => 500000, // in kobo
    'email' => 'user@example.com',
    'callback_url' => 'https://your-site.com/callback'
]);

if ($response['status']) {
    $authUrl = $response['data']['authorization_url'];
}

// Verify a transaction
$response = $paystack->transactions()->verify('reference');

// List transactions
$transactions = $paystack->transactions()->list(['perPage' => 10]);

// Fetch a transaction
$transaction = $paystack->transactions()->fetch('id');
```

### Customers

Manage your customer database.

```php
// Create a customer
$customer = $paystack->customers()->create([
    'email' => 'customer@example.com',
    'first_name' => 'John',
    'last_name' => 'Doe'
]);

// List customers
$customers = $paystack->customers()->list();

// Fetch a customer
$customer = $paystack->customers()->fetch('email_or_code');

// Update a customer
$paystack->customers()->update('CUS_code', ['first_name' => 'Jane']);
```

### Transfers

Send money to your customers or vendors.

```php
// Create a transfer recipient
$recipient = $paystack->transfers()->recipient([
    'type' => 'nuban',
    'name' => 'John Doe',
    'account_number' => '0001234567',
    'bank_code' => '058',
    'currency' => 'NGN'
]);

// Initiate a transfer
$transfer = $paystack->transfers()->initiate([
    'source' => 'balance',
    'amount' => 50000,
    'recipient' => $recipient['data']['recipient_code'],
    'reason' => 'Payment for services'
]);

// Verify a transfer
$paystack->transfers()->verify('reference');
```

### Subscriptions

Manage recurring payments.

```php
// Create a subscription
$subscription = $paystack->subscriptions()->create([
    'customer' => 'CUS_code',
    'plan' => 'PLN_code'
]);

// Enable/Disable subscription
$paystack->subscriptions()->enable(['code' => 'SUB_code', 'token' => 'token']);
$paystack->subscriptions()->disable(['code' => 'SUB_code', 'token' => 'token']);

// Manage link
$link = $paystack->subscriptions()->manageLink('SUB_code');
```

### Plans

Create and manage payment plans.

```php
$plan = $paystack->plans()->create([
    'name' => 'Monthly Premium',
    'amount' => 500000,
    'interval' => 'monthly'
]);
```

### Splits

Split payments between multiple subaccounts.

```php
$split = $paystack->splits()->create([
    'name' => 'Revenue Split',
    'type' => 'percentage',
    'currency' => 'NGN',
    'subaccounts' => [
        ['subaccount' => 'ACCT_123', 'share' => 20]
    ],
    'bearer_type' => 'subaccount'
]);
```

### Subaccounts

Manage subaccounts for split payments.

```php
// Create a subaccount
$subaccount = $paystack->subaccounts()->create([
    'business_name' => 'Subaccount Name',
    'settlement_bank' => '058',
    'account_number' => '0001234567',
    'percentage_charge' => 20
]);

// List subaccounts
$subaccounts = $paystack->subaccounts()->list();
```

### Refunds

Process refunds for transactions.

```php
$paystack->refunds()->create([
    'transaction' => 'transaction-reference',
    'amount' => 50000 // Optional: amount to refund in kobo
]);
```

### Verification

Verify customer information.

```php
// Resolve Account Number
$account = $paystack->verification()->resolveAccount('0001234567', '058');

// Resolve Card BIN
$bin = $paystack->verification()->resolveCardBin('539983');
```

### Settlements

List settlements and transactions.

```php
$settlements = $paystack->settlements()->list();
$transactions = $paystack->settlements()->transactions('settlement_id');
```

### Miscellaneous

Access miscellaneous Paystack features.

```php
// List banks
$banks = $paystack->miscellaneous()->listBanks(['country' => 'nigeria']);

// List countries
$countries = $paystack->miscellaneous()->listCountries();
```

---

## Laravel Integration

The library comes with a built-in Service Provider and Facade for Laravel.

### Setup
The service provider is automatically registered via package discovery.

Publish the config file:
```bash
php artisan vendor:publish --tag="paystack-config"
```

Add your secret key to `.env`:
```env
PAYSTACK_SECRET_KEY=your_secret_key_here
```

### Usage in Laravel
```php
use Kommandhub\Paystack\Laravel\Facades\Paystack;

$response = Paystack::transactions()->initialize([
    'amount' => 5000,
    'email' => 'user@example.com'
]);
```

---

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
