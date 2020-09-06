[![N|Solid](https://www.explorer.cash/logo-dark.png)](https://www.explorer.cash/)

## explorer.cash API for PHP

The library provide an access to explorer.cash Blockchain API for PHP applications.
You can easily add payment request and receive a notification when a crypto payment is confirmed on the blockchain.
explorer.cash Blockchain API supports multiple cryptocurrencies like Bitcoin (BTC), Bitcoin Cash (BCH), Tether (USDT), USD Coin (USDC), Ethereum (ETH), Litecoin (LTC) ...

:green_book: [See explorer.cash Blockchain API documentation](https://www.explorer.cash/en/docs.html)

## Requirements

PHP version >= 7.x

## How to install

```
$ composer require explorer-cash/api-php
```

## How to use

### Register a payment request to explorer.cash

```php
use ExplorerCash\PaymentRequest;

$payment_request = new PaymentRequest();

$payment_request->push([
    'unit' => 'BTC',
    'address' => '1R9NpmdVpC4eKajqutKqSSEn5hH4DEkLs',
    'payment_reference' => 'ORD-4579',
    'amount' => '0.084',
    'callback_url' => 'https://your-callback-url',
    'timeout' => 10,
    'confirmations' => 3
]);

// In your code
$cart = Cart::byReference('ORD-4579');

$cart->payment_id = $payment_request->paymentId();
$cart->save();
```

### Retrieve payment request when your callback URL is called

You need to check that "payment_id" associated to the "payment_reference" are the same.

```php
use ExplorerCash\PaymentRequest;

$payment_request = new PaymentRequest();

$payment_data = $payment_request->pull();

// In your code
$cart = Cart::byReference($payment_data['payment_reference']);

if ($cart->payment_id === $payment_data['payment_id']) {
    if ($payment_data['status'] === 'PAID') {
        $cart->isPaid = true;
    }
}
```

### Subscribe to explorer.cash crypto currencies exchange rates

You will receive the exchange rates of top 100 cryptos in the currency you provided.

```php
use ExplorerCash\Api;

Api::subscribeRates([
    'currency' => 'EUR',
    'callback_url' => 'https://your-callback-url'
]);
```

## Support or Contact

Having trouble with this library or explorer.cash API ? Contact our support support@explorer.cash and we’ll help you sort it out.


## License

GNU Lesser General Public License v3.0

© 2020 explorer.cash. All Rights Reserved.


