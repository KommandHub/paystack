# Paystack PHP Library

A framework-agnostic PHP library for integrating Paystack payments using SOLID principles and PSR standards.

## Installation

```bash
composer require kommandhub/paystack
```

*Note: You will also need to install a PSR-18 HTTP Client and PSR-17 HTTP Factories if your framework doesn't provide them (e.g., `guzzlehttp/guzzle` or `nyholm/psr7`).*

## Usage

### Basic Setup

```php
use Kommandhub\Paystack\Paystack;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\HttpFactory;

$secretKey = 'your-secret-key';
$client = new Client();
$factory = new HttpFactory();

$paystack = new Paystack(
    $secretKey,
    null,
    $client,
    $factory,
    $factory
);
```

### Initialize Transaction

```php
$response = $paystack->transactions()->initialize([
    'amount' => 500000, // 5000 Naira in kobo
    'email' => 'user@example.com',
    'callback_url' => 'https://your-site.com/callback'
]);

if ($response['status']) {
    $authorizationUrl = $response['data']['authorization_url'];
    // Redirect user
}
```

### Verify Transaction

```php
$response = $paystack->transactions()->verify('transaction-reference');

if ($response['status'] && $response['data']['status'] === 'success') {
    // Payment successful
}
```

### Customers

```php
// Create a customer
$paystack->customers()->create([
    'first_name' => 'John',
    'last_name' => 'Doe',
    'email' => 'john@example.com'
]);

// List customers
$paystack->customers()->list();

// Fetch a customer
$paystack->customers()->fetch('john@example.com');
```

### Plans

```php
// Create a plan
$paystack->plans()->create([
    'name' => 'Monthly Subscription',
    'amount' => 500000,
    'interval' => 'monthly'
]);

// List plans
$paystack->plans()->list();
```

### Split Payments

```php
$paystack->splits()->create([
    'name' => 'Test Split',
    'type' => 'percentage',
    'currency' => 'NGN',
    'subaccounts' => [
        ['subaccount' => 'ACCT_xxxxxxxxx', 'share' => 20],
        ['subaccount' => 'ACCT_yyyyyyyyy', 'share' => 30],
    ],
    'bearer_type' => 'subaccount',
    'bearer_subaccount' => 'ACCT_xxxxxxxxx'
]);
```

### Subscriptions

```php
$paystack->subscriptions()->create([
    'customer' => 'CUST_xxxxxxxxx',
    'plan' => 'PLN_xxxxxxxxx'
]);
```

### Refunds

```php
$paystack->refunds()->create([
    'transaction' => 'transaction-reference',
    'amount' => 50000 // Optional: amount to refund in kobo
]);
```

### Miscellaneous

```php
// List banks
$paystack->miscellaneous()->listBanks(['country' => 'nigeria']);

// List countries
$paystack->miscellaneous()->listCountries();

// List states (for AVS)
$paystack->miscellaneous()->listStates('US');
```

## Features

- Framework agnostic with native **Laravel** (^10.0, ^11.0, ^12.0) support.
- Uses PSR-18 (HTTP Client) and PSR-17 (HTTP Factories).
- SOLID design principles.
- Clean and intuitive API.
- Laravel Facade and Service Provider included.
- Supports Transactions, Customers, Plans, Splits, Subscriptions, Refunds, and Miscellaneous (Banks, Countries, AVS States).

## Laravel Support

### 1. Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag="paystack-config"
```

Add your Paystack secret key to your `.env` file:

```env
PAYSTACK_SECRET_KEY=your_secret_key_here
```

### 2. Usage with Facade

```php
use Kommandhub\Paystack\Laravel\Facades\Paystack;

$response = Paystack::transactions()->initialize([
    'amount' => 500000,
    'email' => 'user@example.com'
]);
```

### 3. Usage with Dependency Injection

```php
use Kommandhub\Paystack\Paystack;

public function __construct(Paystack $paystack)
{
    $this->paystack = $paystack;
}

public function pay()
{
    return $this->paystack->transactions()->initialize([...]);
}
```

## Testing

To run the tests, use:

```bash
composer test
```

## Code Styling

This project uses Laravel Pint for code styling. To check for style issues, run:

```bash
composer lint
```

To automatically format the code, run:

```bash
composer format
```

## Examples

You can find ready-to-use examples in the `examples` directory. To run them, check the [Examples README](examples/README.md).

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
