<?php

use BackendProgramer\SnappPay\SnappPaySetting;
use Illuminate\Support\Facades\Config;

test('create new instance with credentials', function () {
    $snappPaySetting = SnappPaySetting::credentials(
        'bamilo-user1',
        '123456789',
        'bamilo1',
        '987654321',
        'https://fms-gateway-staging.apps.public.teh-1.snappcloud.io/'
    );
    expect($snappPaySetting->getUsername())->toEqual('bamilo-user1')
        ->and($snappPaySetting->getPassword())->toEqual('123456789')
        ->and($snappPaySetting->getClientId())->toEqual('bamilo1')
        ->and($snappPaySetting->getClientSecret())->toEqual('987654321')
        ->and($snappPaySetting->getBaseUrl())->toEqual('https://fms-gateway-staging.apps.public.teh-1.snappcloud.io/');
});

test('create new instance with config data', function () {
    Config::set('snapp-pay.settings.user_name', 'bamilo-user1');
    Config::set('snapp-pay.settings.password', '123456789');
    Config::set('snapp-pay.settings.client_id', 'bamilo1');
    Config::set('snapp-pay.settings.client_secret', '987654321');
    Config::set('snapp-pay.settings.base_url', 'https://fms-gateway-staging.apps.public.teh-1.snappcloud.io/');
    $snappPaySetting = new SnappPaySetting(true);
    expect($snappPaySetting->getUsername())->toEqual('bamilo-user1')
        ->and($snappPaySetting->getPassword())->toEqual('123456789')
        ->and($snappPaySetting->getClientId())->toEqual('bamilo1')
        ->and($snappPaySetting->getClientSecret())->toEqual('987654321')
        ->and($snappPaySetting->getBaseUrl())->toEqual('https://fms-gateway-staging.apps.public.teh-1.snappcloud.io/');
});

test('create new instance with setter data', function () {
    $snappPaySetting = new SnappPaySetting();
    $snappPaySetting->setUsername('bamilo-user1');
    $snappPaySetting->setPassword('123456789');
    $snappPaySetting->setClientId('bamilo1');
    $snappPaySetting->setClientSecret('987654321');
    $snappPaySetting->setBaseUrl('https://fms-gateway-staging.apps.public.teh-1.snappcloud.io/');
    expect($snappPaySetting->getUsername())->toEqual('bamilo-user1')
        ->and($snappPaySetting->getPassword())->toEqual('123456789')
        ->and($snappPaySetting->getClientId())->toEqual('bamilo1')
        ->and($snappPaySetting->getClientSecret())->toEqual('987654321')
        ->and($snappPaySetting->getBaseUrl())->toEqual('https://fms-gateway-staging.apps.public.teh-1.snappcloud.io/');
});
