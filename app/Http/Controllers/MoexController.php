<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MoexController extends Controller
{
    public function importPartnerFee()
    {
        $list = [
            'record' => [
                'country' => 'ALBANIA',
                'range' => [
                    '0 - 500 EUR',
                    '500 EUR - ONWARDS',
                    '0 - 60500 LEK',
                    '60500.01 LEK - ONWARDS'
                ],
                'fee' => [
                    '1.50%',
                    '3.00USD + 1.00%',
                    '1.00%',
                    '2.00 USD + 0.80%'
                ],
                'payoutcurrency' => [
                    'EUR',
                    'EUR',
                    'LEK',
                    'LEK'
                ],
                'payoutmethod' => [
                    'CASH',
                    'CASH',
                    'CASH',
                    'CASH'
                ],
            ],
            'record' => [
                'country' => 'ANGOLA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '0.50%'
                ],
                'payoutcurrency' => [
                    'AOA'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
            ],
            'record' => [
                'country' => 'ARGENTINA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '0.50%'
                ],
                'payoutcurrency' => [
                    'ARS'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
            ],
            'record' => [
                'country' => 'ARMENIA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50%'
                ],
                'payoutcurrency' => [
                    'EUR'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
            ],
            'record' => [
                'country' => 'AUSTRALIA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '2.00%'
                ],
                'payoutcurrency' => [
                    'AUD'
                ],
                'payoutmethod' => [
                    'CASH / BANK DEPOSIT'
                ],
            ],
            'record' => [
                'country' => 'BANGLADESH',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '3.50 USD + 0.50%',
                    '1.25 USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'BDT',
                    'BDT'
                ],
                'payoutmethod' => [
                    'CASH',
                    'MOBILE WALLET'
                ],
            ],
            'record' => [
                'country' => 'BANGLADESH',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '3.50 USD + 0.50%',
                    '1.25 USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'BDT',
                    'BDT'
                ],
                'payoutmethod' => [
                    'CASH',
                    'MOBILE WALLET'
                ],
            ],
        ];
    }
}
