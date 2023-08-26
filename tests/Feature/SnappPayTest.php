<?php

use BackendProgramer\SnappPay\enums\Currency;
use BackendProgramer\SnappPay\Order\Order;
use BackendProgramer\SnappPay\Order\OrderProduct;
use BackendProgramer\SnappPay\Order\ProductCategory;
use BackendProgramer\SnappPay\SnappPay;
use BackendProgramer\SnappPay\SnappPaySetting;

it('snapp pay test with incorrect user data', function () {
    $snappPaySetting = SnappPaySetting::credentials(
        'bamilo-user1',
        '123456789',
        'bamilo1',
        '987654321',
        'https://fms-gateway-staging.apps.public.teh-1.snappcloud.io/'
    );

    $snappPay = new SnappPay($snappPaySetting);

    $this->assertEquals($snappPaySetting->getBaseUrl(), $snappPay->getApiBaseUrl());

    // Test getRequestBasicToken method
    $basicToken = $snappPay->getRequestBasicToken();
    $this->assertIsArray($basicToken);
    $authorization = 'Authorization: Basic '.base64_encode($snappPaySetting->getClientId().':'.str_replace('amp;', '', $snappPaySetting->getClientSecret()));
    $this->assertEquals($authorization, $basicToken['Authorization']);
    $this->assertEquals('Content-Type: application/x-www-form-urlencoded', $basicToken['Content-Type']);

    // Test getRequestBearerToken method
    $this->assertSame(['status' => 'error', 'code' => 401, 'message' => 'خطای دریافت توکن'], $snappPay->getRequestBearerToken());

    // Test isMerchantEligible method
    $merchantEligible = $snappPay->isMerchantEligible(10000, Currency::TOMAN);
    $this->expect($merchantEligible)->toHaveKeys(['status', 'statusCode', 'message', 'url', 'args']);
    $this->expect($merchantEligible)->toHaveKey('status', 'error');

    // Test getPaymentToken method
    $order = new Order(123, 153000, 170000, 10000, 0, 'IRT', '09121231111');
    $category = new ProductCategory('Electronics', 2);
    $orderProduct1 = new OrderProduct(1, 'Product 1', 10000, 9000, 2, $category);
    $orderProduct2 = new OrderProduct(2, 'Product 2', 50000, 45000, 3, $category);
    $order->addProduct($orderProduct1);
    $order->addProduct($orderProduct2);
    $paymentToken = $snappPay->getPaymentToken($order, 'https://examole.com/test-payment', time());
    $this->expect($paymentToken)->toHaveKeys(['status', 'statusCode', 'message', 'url', 'args']);
    $this->expect($paymentToken)->toHaveKey('status', 'error');

    // Test verifyOrder method
    $verifyOrder = $snappPay->verifyOrder('payment-token-test');
    $this->expect($verifyOrder)->toHaveKeys(['status', 'statusCode', 'message', 'url', 'args']);
    $this->expect($verifyOrder)->toHaveKey('status', 'error');

    // Test settleOrder method
    $settleOrder = $snappPay->settleOrder('payment-token-test');
    $this->expect($settleOrder)->toHaveKeys(['status', 'statusCode', 'message', 'url', 'args']);
    $this->expect($settleOrder)->toHaveKey('status', 'error');

    // Test revertOrder method
    $revertOrder = $snappPay->revertOrder('payment-token-test');
    $this->expect($revertOrder)->toHaveKeys(['status', 'statusCode', 'message', 'url', 'args']);
    $this->expect($revertOrder)->toHaveKey('status', 'error');

    // Test getPaymentStatusOrder method
    $paymentStatusOrder = $snappPay->getPaymentStatusOrder('payment-token-test');
    $this->expect($paymentStatusOrder)->toHaveKeys(['status', 'statusCode', 'message', 'url', 'args']);
    $this->expect($paymentStatusOrder)->toHaveKey('status', 'error');

    // Test cancelOrder method
    $cancelOrder = $snappPay->cancelOrder('payment-token-test');
    $this->expect($cancelOrder)->toHaveKeys(['status', 'statusCode', 'message', 'url', 'args']);
    $this->expect($cancelOrder)->toHaveKey('status', 'error');

    // Test updateOrder method
    $updateOrder = $snappPay->updateOrder($order);
    $this->expect($updateOrder)->toHaveKeys(['status', 'statusCode', 'message', 'url', 'args']);
    $this->expect($updateOrder)->toHaveKey('status', 'error');
});

it('snapp pay test with order revert', function () {
    $snappPay = new SnappPay();

    $this->assertEquals(config('snapp-pay.settings.base_url'), $snappPay->getApiBaseUrl());

    // Test getRequestBasicToken method
    $basicToken = $snappPay->getRequestBasicToken();
    $this->assertIsArray($basicToken);
    $authorization = 'Authorization: Basic '.base64_encode(config('snapp-pay.settings.client_id').':'.str_replace('amp;', '', config('snapp-pay.settings.client_secret')));
    $this->assertEquals($authorization, $basicToken['Authorization']);
    $this->assertEquals('Content-Type: application/x-www-form-urlencoded', $basicToken['Content-Type']);

    // Test getRequestBearerToken method
    $requestBearerToken = $snappPay->getRequestBearerToken();
    $this->expect($requestBearerToken['Authorization'])->toStartWith('Authorization: Bearer');
    $this->assertEquals('Content-Type: application/json', $requestBearerToken['Content-Type']);

    // Test isMerchantEligible method
    $merchantEligible = $snappPay->isMerchantEligible(100000, Currency::TOMAN);
    $this->expect($merchantEligible)->toHaveKeys(['response', 'successful', 'response.eligible', 'response.titleMessage', 'response.description']);
    $this->expect($merchantEligible)->toHaveKey('successful', true);

    // Test getPaymentToken method
    $order = new Order(123, 153000, 170000, 10000, 0, 'IRT', '09121231111');
    $category = new ProductCategory('Electronics', 2);
    $orderProduct1 = new OrderProduct(1, 'Product 1', 10000, 9000, 2, $category);
    $orderProduct2 = new OrderProduct(2, 'Product 2', 50000, 45000, 3, $category);
    $order->addProduct($orderProduct1);
    $order->addProduct($orderProduct2);
    $paymentToken = $snappPay->getPaymentToken($order, 'https://examole.com/test-payment', time());
    $this->expect($paymentToken)->toHaveKeys(['response', 'successful', 'response.paymentToken', 'response.paymentPageUrl']);
    $this->expect($paymentToken)->toHaveKey('successful', true);

    // Test verifyOrder method
    $verifyOrder = $snappPay->verifyOrder($paymentToken['response']['paymentToken']);
    $this->expect($verifyOrder)->toHaveKeys(['response', 'successful', 'response.transactionId']);
    $this->expect($verifyOrder)->toHaveKey('successful', true);

    // Test settleOrder method
    $settleOrder = $snappPay->settleOrder($paymentToken['response']['paymentToken']);
    $this->expect($settleOrder)->toHaveKeys(['response', 'successful', 'response.transactionId']);
    $this->expect($settleOrder)->toHaveKey('successful', true);

    // Test revertOrder method
    $revertOrder = $snappPay->revertOrder($paymentToken['response']['paymentToken']);
    $this->expect($revertOrder)->toHaveKeys(['response', 'successful', 'response.transactionId']);
    $this->expect($revertOrder)->toHaveKey('successful', true);

    // Test getPaymentStatusOrder method
    $paymentStatusOrder = $snappPay->getPaymentStatusOrder($paymentToken['response']['paymentToken']);
    $this->expect($paymentStatusOrder)->toHaveKeys(['response', 'successful', 'response.transactionId', 'response.status']);
    $this->expect($paymentStatusOrder)->toHaveKey('successful', true);
})->skip();

it('snapp pay test with order update and cancel', function () {
    $snappPay = new SnappPay();

    $this->assertEquals(config('snapp-pay.settings.base_url'), $snappPay->getApiBaseUrl());

    // Test getRequestBasicToken method
    $basicToken = $snappPay->getRequestBasicToken();
    $this->assertIsArray($basicToken);
    $authorization = 'Authorization: Basic '.base64_encode(config('snapp-pay.settings.client_id').':'.str_replace('amp;', '', config('snapp-pay.settings.client_secret')));
    $this->assertEquals($authorization, $basicToken['Authorization']);
    $this->assertEquals('Content-Type: application/x-www-form-urlencoded', $basicToken['Content-Type']);

    // Test getRequestBearerToken method
    $requestBearerToken = $snappPay->getRequestBearerToken();
    $this->expect($requestBearerToken['Authorization'])->toStartWith('Authorization: Bearer');
    $this->assertEquals('Content-Type: application/json', $requestBearerToken['Content-Type']);

    // Test isMerchantEligible method
    $merchantEligible = $snappPay->isMerchantEligible(100000, Currency::TOMAN);
    $this->expect($merchantEligible)->toHaveKeys(['response', 'successful', 'response.eligible', 'response.titleMessage', 'response.description']);
    $this->expect($merchantEligible)->toHaveKey('successful', true);

    // Test getPaymentToken method
    $order = new Order(123, 153000, 170000, 10000, 0, 'IRT', '09121231111');
    $category = new ProductCategory('Electronics', 2);
    $orderProduct1 = new OrderProduct(1, 'Product 1', 10000, 9000, 2, $category);
    $orderProduct2 = new OrderProduct(2, 'Product 2', 50000, 45000, 3, $category);
    $order->addProduct($orderProduct1);
    $order->addProduct($orderProduct2);
    $paymentToken = $snappPay->getPaymentToken($order, 'https://examole.com/test-payment', time());
    $this->expect($paymentToken)->toHaveKeys(['response', 'successful', 'response.paymentToken', 'response.paymentPageUrl']);
    $this->expect($paymentToken)->toHaveKey('successful', true);

    // Test verifyOrder method
    $verifyOrder = $snappPay->verifyOrder($paymentToken['response']['paymentToken']);
    $this->expect($verifyOrder)->toHaveKeys(['response', 'successful', 'response.transactionId']);
    $this->expect($verifyOrder)->toHaveKey('successful', true);

    // Test settleOrder method
    $settleOrder = $snappPay->settleOrder($paymentToken['response']['paymentToken']);
    $this->expect($settleOrder)->toHaveKeys(['response', 'successful', 'response.transactionId']);
    $this->expect($settleOrder)->toHaveKey('successful', true);

    // Edit order for update
    $order->setPaymentToken($paymentToken['response']['paymentToken']);
    $order->removeProduct(2, true); // must be checked product remove

    // Test getPaymentStatusOrder method
    $paymentStatusOrder = $snappPay->getPaymentStatusOrder($paymentToken['response']['paymentToken']);
    $this->expect($paymentStatusOrder)->toHaveKeys(['response', 'successful', 'response.transactionId', 'response.status']);
    $this->expect($paymentStatusOrder)->toHaveKey('successful', true);

    // Test updateOrder method
    $settleOrder = $snappPay->updateOrder($order);
    $this->expect($settleOrder)->toHaveKeys(['response', 'successful', 'response.transactionId']);
    $this->expect($settleOrder)->toHaveKey('successful', true);

    // Test cancelOrder method
    $cancelOrder = $snappPay->cancelOrder($paymentToken['response']['paymentToken']);
    $this->expect($cancelOrder)->toHaveKeys(['response', 'successful', 'response.transactionId', 'response.status']);
    $this->expect($cancelOrder)->toHaveKey('successful', true);
})->skip();
