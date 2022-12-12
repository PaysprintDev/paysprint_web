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
        'refer_earn' => "d-d914390186104554bb583144bf77fe57",
        'customer_statement' => "d-41b823ea7b834d7ebcfe9becea2f934b",
        'virtual_account' => "d-ae755c2eac954354a03f7da4db65c39b",
        'publicize_merchant' => "d-e3fb830f20f14848b54f4a63b121b838",
        'claimbusiness' => "d-60d61b8d49b549939e148398eda52321",
        'merchantusername' => "d-5b768115aa3443578f656fa9a9284c68",
        'unverifiedmerchant'=>"d-23424959b107453980037fb3d3debec8",
        'requestreview' => "d-7e9d0e22efa14c0ca98aeb964e2112a2",
        'productlist' => "d-170c383925bf41dc923dd19e282c98b5",
        'sales' => "d-bdd860861ecd4b61b278b391d3d57b72",
    ],
    'marketplace' => [
        'baseurl' => 'https://api.sendgrid.com/v3',
        'api_key' => env('sendgridmarketplace_api_key'),
        'from' => 'businessdev@paysprint.ca',
        'from_name' => 'PaySprint',
        'claimsbusiness' => "d-edb129442335450e8ea09742c826f8e2",

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
    'onesignal' => [
        'api_key' => env('ONESIGNAL_API_KEY'),
        'url' => env('ONESIGNAL_URL'),
        'appId' => env('ONESIGNAL_APP_ID'),
        'safari_web_id' => env('ONESIGNAL_SAFARI_ID')
    ],
    'datazoo' =>[
        'baseurl' => 'https://idu-test.datazoo.com/api/v2/verify',
        'token' => env('DATAZOO_TOKEN'),
    ],
     'vetofx' =>[
        'baseurl' => 'https://api-v3-sandbox.vertofx.com',
        'token' => env('VERTOFX_TOKEN'),
        'clientid' => 'XKDSE0RCKR450QQ3CBSSB2Y6CAPR',
        'apikey' => env('VERTOFX_APIKEY'),
    ],

];
