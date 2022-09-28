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
        'publicize_merchant' => "d-170c383925bf41dc923dd19e282c98b5",
        'claimbusiness' => "d-28d1011e3ec54768b1202168730f818c",
        'merchantusername' => "d-81278b52677249ffbe56aa18dbdfc8ad",
    ],
    'shuftipro' => [
        'baseurl' => 'https://api.shuftipro.com',
        'client_id' => env('SHUFTI_PRO_CLIENT_ID'),
        'current_secret_key' => env('SHUFTI_PRO_CURRENT_SECRET_KEY'),
        'new_secret_key' => env('SHUFTI_PRO_NEW_SECRET_KEY'),
        'basic_auth' => env('SHUFTI_PRO_BASIC_AUTH'),
    ],
    'moex' => [
        'baseurl' => env('MOEX_BASEURL'),
        'username' => env('MOEX_USERNAME'),
        'password' => env('MOEX_PASSWORD'),
        'version' => env('MOEX_VERSION'),
        'sender_licence' => env('MOEX_SENDER_DRL'),
    ],

];
