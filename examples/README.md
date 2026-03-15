# Paystack PHP Library Examples

These examples demonstrate how to use the Paystack PHP library for various common tasks using a browser-friendly interface.

## Setup

Before running the examples, ensure you have installed the development dependencies:

```bash
composer install --dev
```

This installs `nyholm/psr7`, `symfony/http-client`, and `vlucas/phpdotenv` which are used in the examples.

All examples require a Paystack Secret Key. You can set it in a `.env` file in the project root, as an environment variable, or edit `bootstrap.php`.

**Using .env file:**
Create a `.env` file in the root of the project:
```env
PAYSTACK_SECRET_KEY='your_secret_key'
```

**Using environment variable:**
```bash
export PAYSTACK_SECRET_KEY='your_secret_key'
```

## Running the Examples

The recommended way to run the examples is via a local web server.

### Local Web Server

Start a local PHP server from the project root:

```bash
php -S localhost:8000 -t examples
```

Then visit `http://localhost:8000` in your browser.

## Available Examples

### 1. Full Payment Flow
This demonstrates the complete transaction lifecycle:
- Initializing a transaction with a web form.
- Redirecting to Paystack's secure payment page.
- Handling the callback and verifying the transaction status automatically.

### 2. Create Customer
A web form to create a new customer in your Paystack account.

### 3. Create Plan
A web form to create a new subscription plan.

### 4. Create Refund
A web form to process a refund for a successful transaction. You can also initiate this directly from the "Full Payment Flow" success page.

### 5. Create Subaccount
A web form to create a subaccount, which is required for split payments.

### 6. Create Split Payment
A web form to create a split payment configuration, allowing you to share transaction amounts with subaccounts.

### 7. Miscellaneous
A tool to list supported banks, countries, and AVS states from the Paystack API.

## Note on Dependencies
These examples use `nyholm/psr7` and `symfony/http-client` (via `Psr18Client`) to demonstrate library usage in a framework-agnostic way. You can replace these with any PSR-17 and PSR-18 compliant libraries of your choice.
