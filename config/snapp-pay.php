<?php

// config for BackendProgramer/SnappPay
return [
    /**
     * Basic information for Snapp Pay; obtain this information from Snapp Pay support.
     */
    'settings' => [
        'user_name'     => env('SNAPPPAY_USERNAME', ''),
        'password'      => env('SNAPPPAY_PASSWORD', ''),
        'client_id'     => env('SNAPPPAY_CLIENT_ID', ''),
        'client_secret' => env('SNAPPPAY_CLIENT_SECRET', ''),
        'base_url'      => env('SNAPPPAY_BASE_URL', ''),
    ],

    /**
     * Endpoints and methods of Snapp Pay
     * These endpoints are defined by Snap Pay; edit them if they change.
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
