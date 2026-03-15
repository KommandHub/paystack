<?php

declare(strict_types=1);

namespace Kommandhub\Paystack\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kommandhub\Paystack\Paystack
 *
 * @method static \Kommandhub\Paystack\Resources\Transaction transactions()
 * @method static \Kommandhub\Paystack\Resources\Customer customers()
 * @method static \Kommandhub\Paystack\Resources\Plan plans()
 * @method static \Kommandhub\Paystack\Resources\Split splits()
 * @method static \Kommandhub\Paystack\Resources\Subaccount subaccounts()
 * @method static \Kommandhub\Paystack\Resources\Subscription subscriptions()
 * @method static \Kommandhub\Paystack\Resources\Refund refunds()
 * @method static \Kommandhub\Paystack\Resources\Miscellaneous miscellaneous()
 */
class Paystack extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'paystack';
    }
}
