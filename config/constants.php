<?php

return [
    'flutterwave' => [
        'baseurl' => 'https://api.flutterwave.com/v3',
        'pub_key_dev' => env('FLUTTERWAVE_PUB_DEV'),
        'sec_key_dev' => env('FLUTTERWAVE_SEC_DEV'),
        'pub_key_prod' => env('FLUTTERWAVE_PUB_LIVE'),
        'sec_key_prod' => env('FLUTTERWAVE_SEC_LIVE')
    ],
    'sendgrid' => [
        'baseurl' => 'https://api.sendgrid.com/v3',
        'api_key' => env('sendgrid_api__key'),
        'from' => env('MAIL_FROM_ADDRESS'),
        'from_name' => 'PaySprint',
        'refer_earn' => "d-e395d0c9d765423a91afe82f58822771",
        'customer_statement' => "d-7f88c5270e9f4d848800252afa4228e4",
        'virtual_account' => "d-2a2c67d548e3423eaff7a2b7c79fd960",
        'publicize_merchant' => "d-00d2a801feb9448d8fc8579cce05526a",
    ]
];