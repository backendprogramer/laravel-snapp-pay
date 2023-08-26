<?php

use BackendProgramer\SnappPay\SnappPayEndpoint;
use Illuminate\Support\Facades\Config;

test('create new instance with config data', function () {
    Config::set('snapp-pay.endpoints.bearer_token', ['url' => 'api/online/v1/oauth/token', 'method' => 'POST']);
    Config::set('snapp-pay.endpoints.merchant_eligible', ['url' => 'api/online/offer/v1/eligible', 'method' => 'GET']);
    Config::set('snapp-pay.endpoints.payment_token', ['url' => 'api/online/payment/v1/token', 'method' => 'POST']);
    Config::set('snapp-pay.endpoints.payment_verify', ['url' => 'api/online/payment/v1/verify', 'method' => 'POST']);
    Config::set('snapp-pay.endpoints.payment_settle', ['url' => 'api/online/payment/v1/settle', 'method' => 'POST']);
    Config::set('snapp-pay.endpoints.payment_revert', ['url' => 'api/online/payment/v1/revert', 'method' => 'POST']);
    Config::set('snapp-pay.endpoints.payment_cancel', ['url' => 'api/online/payment/v1/cancel', 'method' => 'POST']);
    Config::set('snapp-pay.endpoints.payment_update', ['url' => 'api/online/payment/v1/update', 'method' => 'POST']);
    Config::set('snapp-pay.endpoints.payment_status', ['url' => 'api/online/payment/v1/status', 'method' => 'GET']);
    $snappPayEndpoint = new SnappPayEndpoint(true);
    expect($snappPayEndpoint->getBearerToken('url'))->toEqual('api/online/v1/oauth/token')
        ->and($snappPayEndpoint->getBearerToken('method'))->toEqual('POST')
        ->and($snappPayEndpoint->getMerchantEligible('url'))->toEqual('api/online/offer/v1/eligible')
        ->and($snappPayEndpoint->getMerchantEligible('method'))->toEqual('GET')
        ->and($snappPayEndpoint->getPaymentToken('url'))->toEqual('api/online/payment/v1/token')
        ->and($snappPayEndpoint->getPaymentToken('method'))->toEqual('POST')
        ->and($snappPayEndpoint->getVerifyOrder('url'))->toEqual('api/online/payment/v1/verify')
        ->and($snappPayEndpoint->getVerifyOrder('method'))->toEqual('POST')
        ->and($snappPayEndpoint->getSettleOrder('url'))->toEqual('api/online/payment/v1/settle')
        ->and($snappPayEndpoint->getSettleOrder('method'))->toEqual('POST')
        ->and($snappPayEndpoint->getRevertOrder('url'))->toEqual('api/online/payment/v1/revert')
        ->and($snappPayEndpoint->getRevertOrder('method'))->toEqual('POST')
        ->and($snappPayEndpoint->getCancelOrder('url'))->toEqual('api/online/payment/v1/cancel')
        ->and($snappPayEndpoint->getCancelOrder('method'))->toEqual('POST')
        ->and($snappPayEndpoint->getUpdateOrder('url'))->toEqual('api/online/payment/v1/update')
        ->and($snappPayEndpoint->getUpdateOrder('method'))->toEqual('POST')
        ->and($snappPayEndpoint->getStatusOrder('url'))->toEqual('api/online/payment/v1/status')
        ->and($snappPayEndpoint->getStatusOrder('method'))->toEqual('GET');
});

test('create new instance with setter data', function () {
    $snappPayEndpoint = new SnappPayEndpoint();
    $snappPayEndpoint->setBearerToken('api/online/v1/oauth/token', 'POST');
    $snappPayEndpoint->setMerchantEligible('api/online/offer/v1/eligible', 'GET');
    $snappPayEndpoint->setPaymentToken('api/online/payment/v1/token', 'POST');
    $snappPayEndpoint->setVerifyOrder('api/online/payment/v1/verify', 'POST');
    $snappPayEndpoint->setSettleOrder('api/online/payment/v1/settle', 'POST');
    $snappPayEndpoint->setRevertOrder('api/online/payment/v1/revert', 'POST');
    $snappPayEndpoint->setCancelOrder('api/online/payment/v1/cancel', 'POST');
    $snappPayEndpoint->setUpdateOrder('api/online/payment/v1/update', 'POST');
    $snappPayEndpoint->setStatusOrder('api/online/payment/v1/status', 'GET');
    expect($snappPayEndpoint->getBearerToken('url'))->toEqual('api/online/v1/oauth/token')
        ->and($snappPayEndpoint->getBearerToken('method'))->toEqual('POST')
        ->and($snappPayEndpoint->getMerchantEligible('url'))->toEqual('api/online/offer/v1/eligible')
        ->and($snappPayEndpoint->getMerchantEligible('method'))->toEqual('GET')
        ->and($snappPayEndpoint->getPaymentToken('url'))->toEqual('api/online/payment/v1/token')
        ->and($snappPayEndpoint->getPaymentToken('method'))->toEqual('POST')
        ->and($snappPayEndpoint->getVerifyOrder('url'))->toEqual('api/online/payment/v1/verify')
        ->and($snappPayEndpoint->getVerifyOrder('method'))->toEqual('POST')
        ->and($snappPayEndpoint->getSettleOrder('url'))->toEqual('api/online/payment/v1/settle')
        ->and($snappPayEndpoint->getSettleOrder('method'))->toEqual('POST')
        ->and($snappPayEndpoint->getRevertOrder('url'))->toEqual('api/online/payment/v1/revert')
        ->and($snappPayEndpoint->getRevertOrder('method'))->toEqual('POST')
        ->and($snappPayEndpoint->getCancelOrder('url'))->toEqual('api/online/payment/v1/cancel')
        ->and($snappPayEndpoint->getCancelOrder('method'))->toEqual('POST')
        ->and($snappPayEndpoint->getUpdateOrder('url'))->toEqual('api/online/payment/v1/update')
        ->and($snappPayEndpoint->getUpdateOrder('method'))->toEqual('POST')
        ->and($snappPayEndpoint->getStatusOrder('url'))->toEqual('api/online/payment/v1/status')
        ->and($snappPayEndpoint->getStatusOrder('method'))->toEqual('GET');
});
