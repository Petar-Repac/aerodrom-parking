<?php

return [
    'shop_id' => env('WSPAY_SHOP_ID', ''),
    'secret_key' => env('WSPAY_SECRET_KEY', ''),
    'test_mode' => env('WSPAY_TEST_MODE', true),
    'version' => '2.0',
    'urls' => [
        'test' => [
            'form' => 'https://formtest.wspay.biz/authorization.aspx',
            'api' => 'https://test.wspay.biz/api/services',
            'create_transaction' => 'https://formtest.wspay.biz/api/create-transaction',
        ],
        'production' => [
            'form' => 'https://form.wspay.biz/authorization.aspx',
            'api' => 'https://secure.wspay.biz/api/services',
            'create_transaction' => 'https://form.wspay.biz/api/create-transaction',
        ],
    ],
];
