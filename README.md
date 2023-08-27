<p align="center"><img width="250px" src="resources/images/snappPay.png" alt="SnappPay"></p>

# Payment Gateway, SnappPay

[![Latest Version on Packagist](https://img.shields.io/packagist/v/backendprogramer/snapp-pay.svg?style=flat-square)](https://packagist.org/packages/backendprogramer/snapp-pay)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/backendprogramer/laravel-snapp-pay/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/backendprogramer/laravel-snapp-pay/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/backendprogramer/laravel-snapp-pay/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/backendprogramer/laravel-snapp-pay/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/backendprogramer/snapp-pay.svg?style=flat-square)](https://packagist.org/packages/backendprogramer/snapp-pay)

This is a Laravel package for the SnappPay payment gateway. This package supports Laravel 10+.

[Persian documentation for Snappay service](/resources/documents/SnappPay%20Rest%20API%20document-%20Installment%20service%20_Fa.pdf)

[English documentation for Snappay service](/resources/documents/SnappPay%20Rest%20API%20document-%20Installment%20service%20_Fa.pdf)

## Installation

You can install the package via composer:

```bash
composer require backendprogramer/snapp-pay
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="snapp-pay-config"
```

This is the contents of the published config file:

```php
return [
    /**
     * Basic information for SnappPay; obtain this information from SnappPay support.
     */
    'settings' => [
        'user_name'     => env('SNAPPPAY_USERNAME', ''),
        'password'      => env('SNAPPPAY_PASSWORD', ''),
        'client_id'     => env('SNAPPPAY_CLIENT_ID', ''),
        'client_secret' => env('SNAPPPAY_CLIENT_SECRET', ''),
        'base_url'      => env('SNAPPPAY_BASE_URL', ''),
    ],

    /**
     * Endpoints and methods of SnappPay
     * These endpoints are defined by SnappPay; edit it if you need.
     */
    'endpoints' => [
        'bearer_token' => [
            'url'    => env('SNAPPPAY_BEARER_TOKEN_URL', 'api/online/v1/oauth/token'),
            'method' => env('SNAPPPAY_BEARER_TOKEN_METHODE', 'POST'),
        ],
        'merchant_eligible' => [
            'url'    => env('SNAPPPAY_MERCHANT_ELIGIBLE_URL', 'api/online/offer/v1/eligible'),
            'method' => env('SNAPPPAY_MERCHANT_ELIGIBLE_METHODE', 'GET'),
        ],
        'payment_token' => [
            'url'    => env('SNAPPPAY_PAYMENT_TOKEN_URL', 'api/online/payment/v1/token'),
            'method' => env('SNAPPPAY_PAYMENT_TOKEN_METHODE', 'POST'),
        ],
        'payment_verify' => [
            'url'    => env('SNAPPPAY_PAYMENT_VERIFY_URL', 'api/online/payment/v1/verify'),
            'method' => env('SNAPPPAY_PAYMENT_VERIFY_METHODE', 'POST'),
        ],
        'payment_settle' => [
            'url'    => env('SNAPPPAY_PAYMENT_SETTLE_URL', 'api/online/payment/v1/settle'),
            'method' => env('SNAPPPAY_PAYMENT_SETTLE_METHODE', 'POST'),
        ],
        'payment_revert' => [
            'url'    => env('SNAPPPAY_PAYMENT_REVERT_URL', '/api/online/payment/v1/revert'),
            'method' => env('SNAPPPAY_PAYMENT_REVERT_METHODE', 'POST'),
        ],
        'payment_cancel' => [
            'url'    => env('SNAPPPAY_PAYMENT_CANCEL_URL', 'api/online/payment/v1/cancel'),
            'method' => env('SNAPPPAY_PAYMENT_CANCEL_METHODE', 'POST'),
        ],
        'payment_update' => [
            'url'    => env('SNAPPPAY_PAYMENT_UPDATE_URL', 'api/online/payment/v1/update'),
            'method' => env('SNAPPPAY_PAYMENT_UPDATE_METHODE', 'POST'),
        ],
        'payment_status' => [
            'url'    => env('SNAPPPAY_PAYMENT_STATUS_URL', 'api/online/payment/v1/status'),
            'method' => env('SNAPPPAY_PAYMENT_STATUS_METHODE', 'GET'),
        ],
    ],
];
```

## Usage

```php
// You can make manual settings as follows
// $snappPaySetting = SnappPaySetting::credentials(
//        'user',
//        'pass',
//        'clientId',
//        'secretSecret',
//        'baseUrl'
//    );
// $snappPay = new SnappPay($snappPaySetting);

// get setting from env or config file snapp-pay
$snappPay = new SnappPay();


$order = new Order(123, 153000, 170000, 10000, 0, Currency::TOMAN, '09121231111');
$category = new ProductCategory('Electronics', 2);
$orderProduct1 = new OrderProduct(1, 'Product 1', 10000, 9000, 2, $category);
$orderProduct2 = new OrderProduct(2, 'Product 2', 50000, 45000, 3, $category);

// You can add the amount of each product to the total price and price of the order as follows
// $order->addProduct($orderProduct1, true);
// $order->addProduct($orderProduct2, true);

$order->addProduct($orderProduct1);
$order->addProduct($orderProduct2);

// Check isMerchantEligible
$merchantEligible = $snappPay->isMerchantEligible($order->getPrice(), Currency::TOMAN);
// Check response $merchantEligible

// Get paymentToken
$paymentToken = $snappPay->getPaymentToken($order, 'https://example.com/payment/succsses/'.$order->getId(), now());
// Check response $paymentToken
    
// Verify order
$resultVerify = $snappPay->verifyOrder($this->order->getPaymentToken());
// Check response $resultVerify

// Revert order
$resultRevert = $snappPay->revertOrder($this->order->getPaymentToken());
// Check response $resultRevert

// Settle order
$resultSettle = $snappPay->settleOrder($this->order->getPaymentToken());
// Check response $resultSettle

// Remove product from order
$order->removeProduct(2,true);
// Update order
$resultUpdate = $snappPay->updateOrder($order);
// Check response $resultUpdate

// Cancel order
$resultCancel = $snappPay->cancelOrder($order->getPaymentToken());
// Check response $resultCancel
```
For more information about how it works, please refer to the example below.

https://github.com/backendprogramer/laravel-snapp-pay-example

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Ali Ghorbani](https://github.com/backendprogramer)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
