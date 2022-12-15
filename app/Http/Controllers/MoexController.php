<?php

namespace App\Http\Controllers;

use App\User;
use App\Traits\Moex;
use App\AllCountries;
use App\Classes\TWSauth;
use App\MoexTransaction;
use App\MoexToPsTransaction;
use Illuminate\Http\Request;
use App\Classes\TWSPhoneConfig;

class MoexController extends Controller
{
    use Moex;

    public function importData()
    {

        $data = $this->importPartnerFee();
        // dd($data);

        for ($i = 0; $i < count($data); $i++) {
            Allcountries::where('name', ucfirst(strtolower($data[$i]['country'])))->update([
                'range' => json_encode($data[$i]['range']),
                'fee' => json_encode($data[$i]['fee']),
                'payoutmethod' => json_encode($data[$i]['payoutmethod']),
                'payoutcurrency' => json_encode($data[$i]['payoutcurrency']),
                'partner' => json_encode($data[$i]['partner']),
                'collection' => json_encode($data[$i]['collection'])

            ]);
        }
    }

    public function importPartnerFee()
    {
        $list = [
            '0' => [
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
                'partner' => [
                    'RAEA FINANCIAL SERVICES LTD'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '1' => [
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
                'partner' => [
                    'MAXPAY'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '2' => [
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
                'partner' => [
                    'ARGENPER SRL',
                    'JET PERU S.A',
                    'LATIN EXPRESS'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '3' => [
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
                'partner' => [
                    'INTEL EXPRESS'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '4' => [
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
                'partner' => [
                    'JET PERU S.A'
                ],
                'collection' => [
                    'PARTNER,PAYSPRINT',

                ],
            ],
            '5' => [
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
                'partner' => [
                    'PRABHU GROUP INC',
                    'TERRAPAY'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '6' => [
                'country' => 'BELGIUM',
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
                'partner' => [
                    'ATENA MONEY TRANSFER'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT'
                ],
            ],
            '7' => [
                'country' => 'BENIN',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.75%',
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'XOF',
                    'XOF'
                ],
                'payoutmethod' => [
                    'CASH',
                    'MOBILE WALLET'
                ],
                'partner' => [
                    'BANQUE REGIONALE DE MARCHES(BRM)',
                    'JUBA EXPRESS',
                    'TERRAPAY'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '8' => [
                'country' => 'BOLIVIA',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '0.80%',
                    '0.80%'
                ],
                'payoutcurrency' => [
                    'BOB',
                    'USD'
                ],
                'payoutmethod' => [
                    'CASH',
                    'CASH'
                ],
                'partner' => [
                    'EUROENIVOS',
                    'MORE MT'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '9' => [
                'country' => 'BRAZIL',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '2.00USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'BRL'
                ],
                'payoutmethod' => [
                    'CASH / BANK DEPOSIT'
                ],
                'partner' => [
                    'BANCO RENDIMENTO',
                    'MORE MT'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '10' => [
                'country' => 'BULGARIA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50%',
                ],
                'payoutcurrency' => [
                    'BGN'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'MONEYTRANS'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT'
                ],
            ],
            '11' => [
                'country' => 'BURKINA FASO',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.75%',
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'XOF',
                    'XOF'
                ],
                'payoutmethod' => [
                    'CASH',
                    'MOBILE WALLET'
                ],
                'partner' => [
                    'BANQUE REGIONALE DE MARCHES(BRM)',
                    'JUBA EXPRESS',
                    'TERRAPAY'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '12' => [
                'country' => 'BURUNDI',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'BIF'
                ],
                'payoutmethod' => [
                    'MOBILE WALLET'
                ],
                'partner' => [
                    'TERRAPAY'
                ],
                'collection' => [
                    'MOBILE MONEY/PARTNER'
                ],
            ],
            '13' => [
                'country' => 'CAMEROON',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.75%',
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'XAF',
                    'XAF'
                ],
                'payoutmethod' => [
                    'CASH',
                    'MOBILE WALLET/BANK DEPOSIT'
                ],
                'partner' => [
                    'CREDIT COMMUNAUTAIRE DE AFRIQUE',
                    'JUBA EXPRESS',
                    'TERRA PAY'
                ],
                'collection' => [
                    'MOBILE MONEY/PARTNER',
                    'MOBILE MONEY/PARTNER',
                    'MOBILE MONEY/PARTNER'
                ],
            ],
            '14' => [
                'country' => 'CAPE VERDE',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50%'
                ],
                'payoutcurrency' => [
                    'CVE'
                ],
                'payoutmethod' => [
                    'CASH/BANK DEPOSIT'
                ],
                'partner' => [
                    'CORREIOS DE CABO VERDE',
                    'MAXPAY'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '15' => [
                'country' => 'CENTRAL AFRICAN REPUBLIC',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'XAF'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'JUBA EXPRESS-EUROS'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '16' => [
                'country' => 'CHAD',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'XAF'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'JUBA EXPRESS'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '17' => [
                'country' => 'CHILE',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '0.75%',
                    '0.75%'
                ],
                'payoutcurrency' => [
                    'CLP',
                    'CLP'
                ],
                'payoutmethod' => [
                    'CASH',
                    'BANK DEPOSIT'
                ],
                'partner' => [
                    'AFEX CHILE',
                    'INTERCREDIT'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '18' => [
                'country' => 'COLOMBIA',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.25USD + 0.50%',
                    '1.25USD + 0.50%',
                    '0.50%'
                ],
                'payoutcurrency' => [
                    'CLP',
                    'CLP'
                ],
                'payoutmethod' => [
                    'BANK DEPOSIT',
                    'MOBILE WALLET',
                    'CASH'
                ],
                'partner' => [
                    'MORE MT',
                    'MORE MT(DAVIVIENDA)',
                    'PAGOS INTERNACIONALES',
                    'TERRAPAY'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '19' => [
                'country' => 'CONGO',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'XAF'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'JUBA EXPRESS'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '20' => [
                'country' => 'CONGO REP DEMOCRATIC',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.75%'
                ],
                'payoutcurrency' => [
                    'USD'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'FBNBANK RDC EX(B.I.C)',
                    'JUBA EXPRESS'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '21' => [
                'country' => 'COASTA RICA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '2.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'USD,CRC'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'RED CHAPINA',
                    'TELEDOLAR S.A'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '22' => [
                'country' => 'CUBA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '5.00USD'
                ],
                'payoutcurrency' => [
                    'CUP,USD'
                ],
                'payoutmethod' => [
                    'CASH/CARD'
                ],
                'partner' => [
                    'FINCIMEX'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '23' => [
                'country' => 'CYPRUS',
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
                'partner' => [
                    'INTEL EXPRESS'
                ],
                'collection' => [
                    'PARTNER'
                ],

            ],
            '24' => [
                'country' => 'CZECH REPUBLIC',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50%'
                ],
                'payoutcurrency' => [
                    'USD,EUR'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'INTEL EXPRESS DOLARES'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT'
                ],
            ],
            '25' => [
                'country' => 'DJIBOUTI',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    ' 3.00%',
                    '1.75%'
                ],
                'payoutcurrency' => [
                    'DOP',
                    'DOP'
                ],
                'payoutmethod' => [
                    'CASH',
                    'BANK DEPOSIT'
                ],
                'partner' => [
                    'DAHABCHIIL',
                    'JUBA EXPRESS'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '26' => [
                'country' => 'DOMINICAN REPUBLIC',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '0.90USD + 0.50%',
                    '0.50USD + 0.50%',
                ],
                'payoutcurrency' => [
                    'DOP',
                    'DOP'
                ],
                'payoutmethod' => [
                    'CASH',
                    'BANK DEPOSIT'
                ],
                'partner' => [
                    'CIBAO',
                    'REMESAS DOMINICANAS BDHS'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'

                ],
            ],
            '27' => [
                'country' => 'ECUADOR',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS',
                    '0 - ONWARDS',
                    '0 - 200USD',
                    '200USD - 1000USD',
                    '2000USD - ONWARDS'
                ],
                'fee' => [
                    '1.10%',
                    '1.00%',
                    '1.50USD + 0.50%',
                    '1.70USD + 0.50%',
                    '2.40USD + 0.50%',
                    '4.50USD + 0.50%',
                    '9.00USD + 0.50%',
                ],
                'payoutcurrency' => [
                    'USD',
                    'USD',
                    'USD',
                    'USD',
                    'USD',
                    'USD',
                    'USD'
                ],
                'payoutmethod' => [
                    'ARGENPER',
                    'BOLIVARIANO/BANK DEPOSIT',
                    'PICHINCHA/BANK DEPOSIT ',
                    'DELEGADO',
                    'TRAVEL',
                    'CASH',
                    'CASH'
                ],
                'partner' => [
                    'ARGENPER SRL',
                    'BANCO BOLIVARIANO ECUAGIROS',
                    'BANCO BICHINCHA',
                    'DELAGO TRAVEL ECUADOR'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '28' => [
                'country' => 'EGYPT',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50%'
                ],
                'payoutcurrency' => [
                    'EGP,USD'
                ],
                'payoutmethod' => [
                    'CASH/BANK DEPOSIT'
                ],
                'partner' => [
                    'BANQUE DU CAIRE',
                    'THE UNITED BANK'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '29' => [
                'country' => 'EL SALVADOR',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS',
                    '0 - 1000USD',
                    '1000USD - ONWARDS '
                ],
                'fee' => [
                    '1.75USD + 0.50%',
                    '2.25USD + 0.50%',
                    '2.25USD + 0.50%',
                    '1.50%'
                ],
                'payoutcurrency' => [
                    'USD',
                    'USD',
                    'USD',
                    'USD'
                ],
                'payoutmethod' => [
                    'CASH',
                    'CASH / BANK DEPOSIT',
                    'CASH / BANK DEPOSIT',
                    'TELEDOR',
                ],
                'partner' => [
                    'FEDECACES',
                    'RED CHAPINA',
                    'TELEDOLAR S.A'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '30' => [
                'country' => 'EQUATORIAL GUINEA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50%'
                ],
                'payoutcurrency' => [
                    'XOF'
                ],
                'payoutmethod' => [
                    'CASH/BANK DEPOSIT'
                ],
                'partner' => [
                    'DONN GRUPO'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '31' => [
                'country' => 'ETHIOPIA',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '2.00%',
                    '1.00%'
                ],
                'payoutcurrency' => [
                    'ETB',
                    'USD'
                ],
                'payoutmethod' => [
                    'CASH',
                    'BANK DEPOSIT'
                ],
                'partner' => [
                    'AWASH BANK',
                    'DAHABSHIIL',
                    'OROMIA INTERNATIONAL BANK',

                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '32' => [
                'country' => 'FRANCE',
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
                'partner' => [
                    'MONEYTRANS'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT'
                ],
            ],
            '33' => [
                'country' => 'GABON',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'XOF'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'JUBA EXPRESS-EUROS'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '34' => [
                'country' => 'GAMBIA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '0.50%'
                ],
                'payoutcurrency' => [
                    'GMD'
                ],
                'payoutmethod' => [
                    'CASH/BANK DEPOSIT'
                ],
                'partner' => [
                    'EASY FINANCIAL SERVICES',
                    'UNITY EXPRESS',
                    'YONNA FOREX BUREAU'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '35' => [
                'country' => 'GEORGIA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50%'
                ],
                'payoutcurrency' => [
                    'EUR,GEL'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'INTEL EXPRESS-EURO'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '36' => [
                'country' => 'GERMANY',
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
                    'CASH/BANK DEPOSIT'
                ],
                'partner' => [
                    'ITRANSFER'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT'
                ],
            ],
            '37' => [
                'country' => 'GHANA',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50%',
                    '1.25USD + 1.50%'
                ],
                'payoutcurrency' => [
                    'GHS',
                    'CSA'
                ],
                'payoutmethod' => [
                    'CASH',
                    'MOBILE WALLET/ BANK DEPOSIT'
                ],
                'partner' => [
                    'GHANA COMMERCIAL BANK LTD',
                    'TERRAPAY',
                    'TRANSFERZERO',
                    'UNIVERSAL MERCHANT BANK LTD'
                ],
                'collection' => [
                    'MOBILE MONEY/PARTNER',
                    'MOBILE MONEY/PARTNER',
                    'MOBILE MONEY/PARTNER',
                    'MOBILE MONEY/PARTNER'
                ],
            ],
            '38' => [
                'country' => 'GREECE',
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
                'partner' => [
                    'INTEL EXPRESS EURO'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT'
                ],
            ],
            '39' => [
                'country' => 'GUATEMALA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '2.00USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'GTQ'
                ],
                'payoutmethod' => [
                    'CASH/BANK DEPOSIT'
                ],
                'partner' => [
                    'MORE MT',
                    'RED CHAPINA'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '40' => [
                'country' => 'GUINEA',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '0.50%',
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'GNF',
                    'GNF'
                ],
                'payoutmethod' => [
                    'CASH',
                    'MOBILE WALLET'
                ],
                'partner' => [
                    'AFRO INTERNATIONAL LTD',
                    'GLOBAL EXPRESS CHANGE',
                    'TERRAPAY'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '41' => [
                'country' => 'GUINEA-BISSAU',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'XOF'
                ],
                'payoutmethod' => [
                    'MOBILE WALLET'
                ],
                'partner' => [
                    'BANQUE REGIONALE DU MARCHES (BRM)',
                    'TERRAPAY'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '42' => [
                'country' => 'HONDURAS',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '2.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'HNL'
                ],
                'payoutmethod' => [
                    'CASH/BANK DEPOSIT'
                ],
                'partner' => [
                    'MORE MT',
                    'RED CHAPINA',
                    'UREMIT INTERNATIONAL'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '43' => [
                'country' => 'HONG KONG',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '4.00USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'HKD'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'UREMIT INTERNATIONAL'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT'
                ],
            ],
            '44' => [
                'country' => 'INDIA',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.25USD + 0.50%',
                    '3.00USD + 0.50%',
                ],
                'payoutcurrency' => [
                    'INR',
                    'INR'
                ],
                'payoutmethod' => [
                    'BANK DEPOSIT',
                    'CASH'
                ],
                'partner' => [
                    'UREMIT INTERNATIONAL',
                    'TERRAPAY'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT',
                    'PARTNER/PAYSPRINT'
                ],
            ],
            '45' => [
                'country' => 'INDONESIA',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '5.00USD + 0.50%',
                    '3.00USD + 0.50%',
                    '1.50USD + 0.50%',
                ],
                'payoutcurrency' => [
                    'IDR',
                    'IDR',
                    'IDR'
                ],
                'payoutmethod' => [
                    'CASH',
                    'CASH',
                    'BANK DEPOSIT'

                ],
                'partner' => [
                    'INTEL EXPRESS',
                    'SURICHANGE',
                    'TERRAPAY'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '46' => [
                'country' => 'ISRAEL',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50%',
                    '1.50%',
                ],
                'payoutcurrency' => [
                    'EUR',
                    'EUR/USD'
                ],
                'payoutmethod' => [
                    'CASH',
                    'CASH'
                ],
                'partner' => [
                    'INTEL EXPRESS',
                    'UNIGIROS LTD'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT',
                    'PARTNER/PAYSPRINT'
                ],
            ],
            '47' => [
                'country' => 'ITALY',
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
                    'CASH / BANK DEPOSIT'
                ],
                'partner' => [
                    'INTEL EXPRESS EURO',
                    'ITRANSFER',
                    'MONEY EXCHANGE ITALIA'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT',
                    'PARTNER/PAYSPRINT',
                    'PARTNER/PAYSPRINT'
                ],
            ],
            '48' => [
                'country' => 'IVORY COAST',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'XOF'
                ],
                'payoutmethod' => [
                    'CASH / MOBILE WALLET'
                ],
                'partner' => [
                    'BANQUE REGIONALE DU MARCHE(BRM)',
                    'JUDA EXPRESS',
                    'TERRAPAY EUROS'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '49' => [
                'country' => 'JAPAN',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '15USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'JPY'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'PRABHU GROUP INC'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT'
                ],

            ],
            '50' => [
                'country' => 'JORDAN',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '4.00USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'JOD'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'UREMIT INTERNATIONAL'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '51' => [
                'country' => 'KENYA',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.25USD + 0.50%',
                    '3.00%',
                ],
                'payoutcurrency' => [
                    'KES',
                    'USD'
                ],
                'payoutmethod' => [
                    'MOBILE WALLET / BANK DEPOSIT',
                    'CASH'
                ],
                'partner' => [
                    'DAHABSHIIL',
                    'TERRAPAY'
                ],
                'collection' => [
                    'MOBILE MONEY/PARTNER',
                    'MOBILE MONEY/PARTNER'
                ],
            ],
            '52' => [
                'country' => 'KOSOVO',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50%(MIN 2.50USD)'
                ],
                'payoutcurrency' => [
                    'EUR'
                ],
                'payoutmethod' => [
                    'UPT ODEME'
                ],
                'partner' => [
                    'UPT ODEME'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '53' => [
                'country' => 'KUWAIT',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '3.50USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'KED'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'UREMIT INTERNATIONAL'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '54' => [
                'country' => 'MADAGASCAR',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'MGA'
                ],
                'payoutmethod' => [
                    'MOBILE WALLET'
                ],
                'partner' => [
                    'TERRAPAY'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '55' => [
                'country' => 'MALI',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.25USD + 0.50%',
                    '2.00USD + 0.50%',
                    '1.80%',
                ],
                'payoutcurrency' => [
                    'XOF',
                    'XOF',
                    'XOF'
                ],
                'payoutmethod' => [
                    'MOBILE WALLET',
                    'BANK DEPOSIT',
                    'CASH'
                ],
                'partner' => [
                    'BANQUE MALIENNE DE SOLIDARITE(B.M.S)',
                    'BANQUE DE DEVELOPMENT DU MALI(B.D.M)',
                    'CHEICK SALL SERVICES',
                    'TERRAPAY EUROS',
                    'TIMBUCTU EXCHANGE'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '56' => [
                'country' => 'MEXICO',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '3.00USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'MXN'
                ],
                'payoutmethod' => [
                    'CASH / BANK DEPOSIT'
                ],
                'partner' => [
                    'ORDER EXPRESS'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT'
                ],
            ],
            '57' => [
                'country' => 'MOLDOVA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50%(MIN 1.00USD)'
                ],
                'payoutcurrency' => [
                    'USD,MDL,EUR'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'I.S. POSTA MOLDOVEI S.A',
                    'INTEL EXPRESS',
                    'SMITH $ SMITH'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],

            ],
            '58' => [
                'country' => 'MOROCCO',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.70%'
                ],
                'payoutcurrency' => [
                    'MAD'
                ],
                'payoutmethod' => [
                    'CASH / BANK DEPOSIT'
                ],
                'partner' => [
                    'CASH PLUS',
                    'DAMANE CASH',
                    'TRANSFERT EXPRESS S.A'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '59' => [
                'country' => 'MOZAMBIQUE',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'MZN'
                ],
                'payoutmethod' => [
                    'MOBILE WALLET'
                ],
                'partner' => [
                    'TERRAPAY'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '60' => [
                'country' => 'NEPAL',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '3.50USD + 0.50%',
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'NPR',
                    'NPR'
                ],
                'payoutmethod' => [
                    'CASH',
                    'MOBILE WALLET'
                ],
                'partner' => [
                    'BANK OF KATHMANDU LTD',
                    'PRABHU GROUP INC',
                    'TERRAPAY'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '61' => [
                'country' => 'NETHERLANDS',
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
                'partner' => [
                    'SURICHANGE'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT'
                ],
            ],
            '62' => [
                'country' => 'NICARAGUA',
                'range' => [
                    '0 - 1000USD',
                    '1000USD - ONWARDS'
                ],
                'fee' => [
                    '2.25USD + 0.50%',
                    '1.50%'
                ],
                'payoutcurrency' => [
                    'USD',
                    'USD'
                ],
                'payoutmethod' => [
                    'CASH',
                    'BANK DEPOSIT'
                ],
                'partner' => [
                    'MORE MT',
                    'TELEDOLAR S.A'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '63' => [
                'country' => 'NIGER',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'XOF'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'BANQUE REGIONALE DE MARCHES(BRM)',
                    'JUDA EXPRESS-EURO'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '64' => [
                'country' => 'NIGERIA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '2.00USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'NGN / USD'
                ],
                'payoutmethod' => [
                    'CASH / BANK DEPOSIT'
                ],
                'partner' => [
                    'CASH POT LTD(USD)',
                    'NAIRAGRAM',
                    'SWISS REMIT GMBH'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT',
                    'PARTNER/PAYSPRINT',
                    'PARTNER/PAYSPRINT',
                ],
            ],
            '65' => [
                'country' => 'PAKISTAN',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50%'
                ],
                'payoutcurrency' => [
                    'PKR'
                ],
                'payoutmethod' => [
                    'CASH / BANK DEPOSIT'
                ],
                'partner' => [
                    'HABIB METRO BANK'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],

            '66' => [
                'country' => 'PANAMA',
                'range' => [
                    '0 - 300USD',
                    '300USD - ONWARDS'
                ],
                'fee' => [
                    '1.50USD + 0.50%',
                    '1.00%'
                ],
                'payoutcurrency' => [
                    'USD',
                    'USD'
                ],
                'payoutmethod' => [
                    'CASH',
                    'CASH'
                ],
                'partner' => [
                    'DOL CORPORATION INC',
                    'RED PLUS'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '67' => [
                'country' => 'PARAGUAY',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '2.75USD + 0.50%',
                    '0.50%'
                ],
                'payoutcurrency' => [
                    'USD',
                    'PYG'
                ],
                'payoutmethod' => [
                    'CASH',
                    'BANK DEPOSIT'
                ],
                'partner' => [
                    'BANCO FAMILIAR',
                    'MORE MT'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '68' => [
                'country' => 'PERU',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50%',
                    '1.70USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'USD,EUR',
                    'PEN'
                ],
                'payoutmethod' => [
                    'CASH / BANK DEPOSIT',
                    'CASH / BANK DEPOSIT'
                ],
                'partner' => [
                    'ARGENPER SRL',
                    'AREGNPER SRL EUROS',
                    'JET PERU EUROS',
                    'JET PERU S.A',
                    'MORE MT'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '69' => [
                'country' => 'PHILIPPINES',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.00%',
                    '1.25USD + 0.50%',
                    '3.50USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'PHP',
                    'PHP',
                    'PHP'
                ],
                'payoutmethod' => [
                    'CASH / BANK DEPOSIT ONLY AUB',
                    'BANK DEPOSIT - ALL BANK',
                    'MLHULLIER - CASH'
                ],
                'partner' => [
                    'ASIA UNITED BANK',
                    'LBC EXPRESS INC',
                    'MLHUILLIER',
                    'TERRAPAY'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT',
                    'PARTNER/PAYSPRINT',
                    'PARTNER/PAYSPRINT',
                    'PARTNER/PAYSPRINT'
                ],
            ],
            '70' => [
                'country' => 'PORTUGAL',
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
                    'CASH / BANK DEPOSIT'
                ],
                'partner' => [
                    'MAXPAY',
                    'REAL TRANSFER'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER/PAYSPRINT'
                ],
            ],
            '71' => [
                'country' => 'PUERTO RICO',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '2.00%'
                ],
                'payoutcurrency' => [
                    'USD'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'LA NACIONAL'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '72' => [
                'country' => 'ROMANIA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.30%'
                ],
                'payoutcurrency' => [
                    'LED,EUR'
                ],
                'payoutmethod' => [
                    'CASH / BANK DEPOSIT'
                ],
                'partner' => [
                    'MONEY TRANS',
                    'SMITH $ SMITH'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '73' => [
                'country' => 'RWANDA',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '3.00%',
                    '1.50%',
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'RWF',
                    'RWF',
                    'RWF'
                ],
                'payoutmethod' => [
                    'CASH - DAHAB',
                    'CASH / BANK DEPOSIT - MAICO',
                    'MOBILE WALLET / BANK DEPOSIT'
                ],
                'partner' => [
                    'DAHABSHIIL',
                    'MAICO MONEY TRANSFER LTD',
                    'TERRAPAY'
                ],
                'collection' => [
                    'MOBILE MONEY/PARTNER',
                    'MOBILE MONEY/PARTNER',
                    'MOBILE MONEY/PARTNER'
                ],
            ],
            '74' => [
                'country' => 'SENEGAL',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50%',
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'XOF',
                    'XOF'
                ],
                'payoutmethod' => [
                    'CASHMINUTE',
                    'MOBILE WALLET'
                ],
                'partner' => [
                    'ARICA P.WALLER/BANCO',
                    'BANQUE REGIONALE DE MARCHES(BRM)',
                    'CASH MINUTE',
                    'TERRAPAY',
                    'TRANSFERZERO'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '75' => [
                'country' => 'SIERRA LEONE',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '0.50%'
                ],
                'payoutcurrency' => [
                    'SLL'
                ],
                'payoutmethod' => [
                    'CASH / BANK DEPOSIT / WALLET'
                ],
                'partner' => [
                    'AFRICA P.CASH',
                    'AFRO INTERNATIONAL LTD',
                    'CASHMINUTE',
                    'TERRAPAY'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '76' => [
                'country' => 'SOMALIA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.75%'
                ],
                'payoutcurrency' => [
                    'USD'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'DAHABSHIIL',
                    'JUBA EXPRESS'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '77' => [
                'country' => 'SOUTH AFRICA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.25%'
                ],
                'payoutcurrency' => [
                    'ZAR'
                ],
                'payoutmethod' => [
                    'BANK DEPOSIT'
                ],
                'partner' => [
                    'JUBA EXPRESS'
                ],
                'collection' => [
                    'MOBILE MONEY/PARTNER'
                ],
            ],
            '78' => [
                'country' => 'SOUTH SUDAN',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.75%'
                ],
                'payoutcurrency' => [
                    'USD'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'JUBA EXPRESS'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '79' => [
                'country' => 'SPAIN',
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
                    'CASH / BANK DEPOSIT'
                ],
                'partner' => [
                    'MONEY EXCHANCE ESPANA'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT'
                ],
            ],
            '80' => [
                'country' => 'SRI LANKA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'LRK'
                ],
                'payoutmethod' => [
                    'CASH / BANK DEPOSIT'
                ],
                'partner' => [
                    'SAMPATH BANK',
                    'TERRAPAY'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '81' => [
                'country' => 'SUDAN',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.75%'
                ],
                'payoutcurrency' => [
                    'SDG,USD'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'DAHABSHIIL',
                    'JUBA EXPRESS'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '82' => [
                'country' => 'SURINAME',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50USD + 0.50%',
                    '1.7%(MIN 1.50USD)'
                ],
                'payoutcurrency' => [
                    'SDR',
                    'EUR'
                ],
                'payoutmethod' => [
                    'CASH ',
                    'BANK DEPOSIT'
                ],
                'partner' => [
                    'SURICHANGE'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '83' => [
                'country' => 'SWITZERLAND',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50%'
                ],
                'payoutcurrency' => [
                    'CHF'
                ],
                'payoutmethod' => [
                    'CASH / BANK DEPOSIT'
                ],
                'partner' => [
                    'ME MONEY EXCHANGE GMBH'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT'
                ],
            ],
            '84' => [
                'country' => 'TANZANIA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'TZS'
                ],
                'payoutmethod' => [
                    'MOBILE WALLET/ BANK DEPOSIT'
                ],
                'partner' => [
                    'TERRAPAY'
                ],
                'collection' => [
                    'MOBILE MONEY/PARTNER'
                ],
            ],
            '85' => [
                'country' => 'TOGO',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'XOF'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'BANQUE REGIONALE DE MARCHES(BRM)',
                    'JUBA EXPRESS-EUROS'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '86' => [
                'country' => 'TUNISIA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '0.50%'
                ],
                'payoutcurrency' => [
                    'TND'
                ],
                'payoutmethod' => [
                    'CASH / BANK DEPOSIT'
                ],
                'partner' => [
                    'BANQUE DE LE-HABITAT-TUNNEX'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '87' => [
                'country' => 'TURKEY',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.70%(MIN 2.50USD)'
                ],
                'payoutcurrency' => [
                    'TRY,EUR'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'INTEL EXPRESS',
                    'TERRAPAY',
                    'OPT ODEME'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '88' => [
                'country' => 'UGANDA',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '0.75%',
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'EUR',
                    'UGR'
                ],
                'payoutmethod' => [
                    'CASH',
                    'MOBILE WALLET'
                ],
                'partner' => [
                    'JUBA EXPRESS',
                    'TERRAPAY'
                ],
                'collection' => [
                    'MOBILE MONEY/PARTNER',
                    'MOBILE MONEY/PARTNER'

                ],
            ],
            '89' => [
                'country' => 'UKRAINE',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50%',
                    '1.50%'
                ],
                'payoutcurrency' => [
                    'USD,EUR',
                    'UAH'
                ],
                'payoutmethod' => [
                    'CASH',
                    'CARD PAYMENT'
                ],
                'partner' => [
                    'INTEL EXPRESS'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '90' => [
                'country' => 'UNITED ARAB EMIRATES',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.75%'
                ],
                'payoutcurrency' => [
                    'AED'
                ],
                'payoutmethod' => [
                    'CASH'
                ],
                'partner' => [
                    'JUBA EXPRESS',
                    'UREMIT INTERNATIONAL'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT',
                    'PARTNER/PAYSPRINT'
                ],
            ],
            '91' => [
                'country' => 'UNITED KINGDOM',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50%'
                ],
                'payoutcurrency' => [
                    'GBP'
                ],
                'payoutmethod' => [
                    'CASH / BANK DEPOSIT'
                ],
                'partner' => [
                    'INAIRA TRANSFER',
                    'INTEL EXPRESS EUROS'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT',
                    'PARTNER/PAYSPRINT'
                ],
            ],
            '92' => [
                'country' => 'UNITED STATES',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '2.00%',
                    '1.80%'
                ],
                'payoutcurrency' => [
                    'USD',
                    'USD'
                ],
                'payoutmethod' => [
                    'CASH',
                    'BANK DEPOSIT'
                ],
                'partner' => [
                    'DELGADO TRAVEL(USA)',
                    'JET PERU S.A',
                    'LA NACIONAL',
                    'MORE MT',
                    'ORDER EXPRESS'
                ],
                'collection' => [
                    'PARTNER/PAYSPRINT',
                    'PARTNER/PAYSPRINT',
                    'PARTNER/PAYSPRINT',
                    'PARTNER/PAYSPRINT',
                    'PARTNER/PAYSPRINT'
                ],
            ],
            '93' => [
                'country' => 'URUGUAY',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50%'
                ],
                'payoutcurrency' => [
                    'UYU'
                ],
                'payoutmethod' => [
                    'BANK DEPOSIT'
                ],
                'partner' => [
                    'GIROS MORE URUGUAY'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '94' => [
                'country' => 'VENEZUELA',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS',
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.00USD + 0.50%',
                    '1.50USD + 4.50%',
                    '1.50USD + 4.50%'
                ],
                'payoutcurrency' => [
                    'VES',
                    'USD',
                    'EUR'
                ],
                'payoutmethod' => [
                    'BANK DEPOSIT',
                    'CASH',
                    'CASH'

                ],
                'partner' => [
                    'CASA DE CAMBIOS INSULAR',
                    'DOL INCORPORATION INC',
                    'INTERCREDIT'
                ],
                'collection' => [
                    'PARTNER',
                    'PARTNER',
                    'PARTNER'
                ],
            ],
            '95' => [
                'country' => 'VIETNAM',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.50USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'VND'
                ],
                'payoutmethod' => [
                    'BANK DEPOSIT'
                ],
                'partner' => [
                    'TERRAPAY'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '96' => [
                'country' => 'ZAMBIA',
                'range' => [
                    '0 - ONWARDS'
                ],
                'fee' => [
                    '1.25USD + 0.50%'
                ],
                'payoutcurrency' => [
                    'ZMW'
                ],
                'payoutmethod' => [
                    'MOBILE WALLET'
                ],
                'partner' => [
                    'TERRAPAY'
                ],
                'collection' => [
                    'PARTNER'
                ],
            ],
            '97' => [
                'country' => 'CANADA',
                'range' => [
                    '0 - ONWARDS',
                    '0 - ONWARDS',
                    '0 - ONWARD'
                ],
                'fee' => [
                    '1.25USD ',
                    '1.5%',
                    '2.50USD'
                ],
                'payoutcurrency' => [
                    'CAD',
                    'CAD',
                    'CAD'
                ],
                'payoutmethod' => [
                    'E-TRANSFER',
                    'BANK DEPOSIT',
                    'PREPAID CARD'
                ],
                'partner' => [
                    'PAYSPRINT'
                ],
                'collection' => [
                    'PAYSPRINT'
                ],
            ],
        ];


        return $list;
    }


    // Confirm Transaction ID...
    public function confirmThisTransactionId(Request $req)
    {
        try {

            $data = $this->confirmMoexTransactionId($req->transactionId);

            $status = 200;

            $resData = ['data' => $data, 'message' => 'success', 'status' => $status];
        } catch (\Throwable $th) {
            $status = 400;
            $resData = ['data' => [], 'message' => $th->getMessage(), 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }

    // Cron to MOEX..
    public function sendDailyExchange()
    {

        $setupController = new CheckSetupController();

        try {
            $jsondata = $this->generateDailyExchangeRate();


            // Decode json data and convert it
            // into an associative array
            $jsonans = json_decode($jsondata, true);


            // CSV file name => date('d-m-Y') . '_report.xls';
            $csv = date('d-m-Y') . '_report.xls';

            // File pointer in writable mode
            $file_pointer = fopen('../' . $csv, 'w');

            // Traverse through the associative
            // array using for each loop
            foreach ($jsonans as $i) {

                // Write the data to the CSV file
                fputcsv($file_pointer, $i);
            }

            // Close the file pointer.
            fclose($file_pointer);


            $setupController->name = "Money Exchange";
            $setupController->email = env('APP_ENV') === 'local' ? "adenugaadebambo41@gmail.com" : "tasas@moneyexchange.es";
            $setupController->subject = "Daily Exchange Rate - " . date('d-m-Y');
            $setupController->message = "<p>Below is the daily exchange rate from PaySprint today.</p><h3>DAILY EXCHANGE RATE - TODAY " . date('d-m-Y') . "</h3><hr><p>" . $jsonans[0][0] . " - <strong>" . $jsonans[1]['Correspondent'] . "</strong></p><p>" . $jsonans[0][1] . " - <strong>" . $jsonans[1]['Country'] . "</strong></p><p>" . $jsonans[0][2] . " - <strong>" . $jsonans[1]['Currency'] . "</strong></p><p>" . $jsonans[0][3] . " - <strong>" . $jsonans[1]['usdRate'] . "</strong></p><p>" . $jsonans[0][4] . " - <strong>" . $jsonans[1]['active'] . "</strong></p><p>Also find attached</p><p>Best regards</p>";
            $setupController->file = $csv;
            $setupController->sendEmail($setupController->email, "Daily Transaction Report");
            $setupController->sendEmail('duntanadebiyi@yahoo.com', "Daily Transaction Report");
            $setupController->sendEmail('grivero@moneyexchange.es', "Daily Transaction Report");

            echo "Done";
        } catch (\Throwable $th) {
            dd($th->getMessage());
            throw $th->getMessage();
        }
    }

    // API Call
    public function callDailyExchange()
    {
        try {
            $jsondata = $this->generateDailyExchangeRate();

            $data = json_decode($jsondata, true);

            $status = 200;

            $resData = ['data' => $data, 'message' => 'success', 'status' => $status];
        } catch (\Throwable $th) {
            $status = 400;
            $resData = ['data' => [], 'message' => $th->getMessage(), 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }

    public function paymentConfirmation()
    {
        try {

            $checkSetup = new CheckSetupController();

            $getTransaction = $this->getNotProcessedMoexTransactions();

            foreach ($getTransaction as $item) {


                if ($item->status == 'initiated' || $item->status == 'pending') {
                    $transactions = json_decode($item->transaction);


                    $data = $this->checkTransactionStatus($transactions->transactionId);



                    // Update Status...
                    if ($data['transaction']->TransactionStatus === "PAG") {
                        MoexTransaction::where('id', $item->id)->update(['status' => 'processed', 'transactionMessage' => 'The transaction has already been paid.']);

                        $money = MoexTransaction::where('id', $item->id)->first();

                        $amount = $money->amount + 0.015;

                        $thisuser = User::where('id', $item->user_id)->first();

                        if(isset($thisuser)){
                            $topUpSetup = new MonthlySubController();
                            $topUpSetup->moexTopUpAccount($thisuser->country, $amount, $thisuser->name, $thisuser->accountType);
                        }


                    } elseif ($data['transaction']->TransactionStatus === "ENV" || $data['transaction']->TransactionStatus === "NEV") {
                        MoexTransaction::where('id', $item->id)->update(['status' => 'pending', 'transactionMessage' => 'Available for pay']);
                    } elseif ($data['transaction']->TransactionStatus === "ANU") {
                        // Refund back to users wallet and mail...
                        MoexTransaction::where('id', $item->id)->update(['status' => 'cancelled', 'transactionMessage' => 'Cancelled transaction']);

                        $money = MoexTransaction::where('id', $item->id)->first();

                        $amount = $money->amount + 0.015;

                        $checkSetup->reverseBackFund($item->user_id, $amount, 'Cancelled transaction');
                    } elseif ($data['transaction']->TransactionStatus === "DEV" || $data['transaction']->TransactionStatus === "DVO") {
                        // Refund back to users wallet and mail...
                        MoexTransaction::where('id', $item->id)->update(['status' => 'reversed', 'transactionMessage' => 'Transaction returned to sender']);

                        $money = MoexTransaction::where('id', $item->id)->first();

                        $amount = $money->amount + 0.015;

                        $checkSetup->reverseBackFund($item->user_id, $amount, 'Transaction returned to sender');
                    } else {
                        // Refund back to users wallet and mail...
                        MoexTransaction::where('id', $item->id)->update(['status' => 'Transaction with problem']);

                        $money = MoexTransaction::where('id', $item->id)->first();

                        $amount = $money->amount + 0.015;

                        $checkSetup->reverseBackFund($item->user_id, $amount, 'Transaction with problem');
                    }
                }
            }

            $data = [
                'success' => 'Done'
            ];
        } catch (\Throwable $th) {
            $data = [
                'error' => $th->getMessage()
            ];
        }



        return $data;
    }


    public function moexPS($body)
    {
        try {

            $data = $this->addTransactionToMoex($body);
        } catch (\Throwable $th) {
            $data = [
                'error' => $th->getMessage()
            ];
        }

        return $data;
    }


    public function getExTransactionMoexPS($body)
    {
        try {
            $data = $this->MEGetExtTransactionMoex($body);

        } catch (\Throwable $th) {
            $data = [
                'error' => $th->getMessage()
            ];
        }

        return $data;
    }


    public function getExTransactionMoexPSAllPaid($fromDate, $toDate)
    {
        try {
            $data = $this->MEGetTransactionMoExAllPaid($fromDate, $toDate);

            if(isset($data['transactions'])){
                // Save transactions to database...
                if(count($data['transactions']) > 0){
                foreach($data['transactions'] as $transaction){
                    $getTransaction = MoexToPsTransaction::where('transactionId', trim($transaction->TransactionId))->first();



                    if(empty($getTransaction)){
                        // Create New Record
                        MoexToPsTransaction::insert([
                            'transactionId' => trim($transaction->TransactionId),
                            'body' => trim(json_encode($transaction)),
                            'status' => 'paid',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

                        $this->doSlack("New PAID MOEX: ".$transaction->TransactionId.". Check it out.", $room = "moex-logs", $icon = ":longbox:", env('LOG_SLACK_MOEX_URL'));
                    }
                }
                }

            }

        } catch (\Throwable $th) {
            $data = [
                'error' => $th->getMessage()
            ];
        }

        return $data;
    }


    public function getExTransactionMoexPSAllPending()
    {
        try {
            $data = $this->MEGetTransactionMoExAllPending();


            if(isset($data['transactions'])){
                // Save transactions to database...
                if(count($data['transactions']) > 0){
                foreach($data['transactions'] as $transaction){
                    $getTransaction = MoexToPsTransaction::where('transactionId', $transaction->TransactionId)->first();

                    if(empty($getTransaction)){
                        // Create New Record
                        MoexToPsTransaction::insert([
                            'transactionId' => $transaction->TransactionId,
                            'body' => trim(json_encode($transaction)),
                            'status' => 'pending',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

                        $this->MEConfirmDownloadedTransactionMoEx(trim($transaction->TransactionId));

                        // Slack Notify
                        $this->doSlack("New PENDING MOEX: ".$transaction->TransactionId.". Check it out.", $room = "moex-logs", $icon = ":longbox:", env('LOG_SLACK_MOEX_URL'));
                    }
                }
                }

            }

        } catch (\Throwable $th) {
            $data = [
                'error' => $th->getMessage()
            ];
        }

        return $data;
    }


    public function getExTransactionMoexPSAllPayed($fromDate, $toDate)
    {
        try {
            $data = $this->MEGetTransactionMoExAllPayed($fromDate, $toDate);



            if(isset($data['transactions'])){
                // Save transactions to database...
                if(count($data['transactions']) > 0){
                foreach($data['transactions'] as $transaction){
                    $getTransaction = MoexToPsTransaction::where('transactionId', $transaction->TransactionId)->first();

                    if(empty($getTransaction)){
                        // Create New Record
                        MoexToPsTransaction::insert([
                            'transactionId' => $transaction->TransactionId,
                            'body' => trim(json_encode($transaction)),
                            'status' => 'payed',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);

                        $this->doSlack("New PAYED MOEX: ".$transaction->TransactionId.". Check it out.", $room = "moex-logs", $icon = ":longbox:", env('LOG_SLACK_MOEX_URL'));
                    }
                }
                }

            }

        } catch (\Throwable $th) {
            $data = [
                'error' => $th->getMessage()
            ];
        }

        return $data;
    }

    public function moexpsConfirmTranx($data)
    {
        try {
            $data = $this->MEConfirmPaymentTransactionMoEx($data['IdTransaction'], $data['PaymentDate'], $data['ReceiverName'], $data['ReceiverDocument']);

        }catch (\Throwable $th) {
            $data = [
                'error' => $th->getMessage()
            ];
        }

        return $data;
    }


    public function getPaymentPolicy()
    {
        try {
            $filename = 'js/paymentpolicy.json';
            $data = file_get_contents($filename);

            $status = 200;
            $resData = ['data' => json_decode($data), 'message' => 'Success', 'status' => $status];

        } catch (\Throwable $th) {
            $status = 400;
            $resData = ['data' => [], 'message' => $th->getMessage(), 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }


    public function getPaymentPolicyByCountry($country)
    {
        try {
            $filename = 'js/paymentpolicy.json';
            $data = file_get_contents($filename);

            $result = $this->searchForItem($country, json_decode($data));

            $status = 200;
            $resData = ['data' => $result, 'message' => 'Success', 'status' => $status];

        } catch (\Throwable $th) {
            $status = 400;
            $resData = ['data' => [], 'message' => $th->getMessage(), 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }



    public function getAdditionalList(Request $req)
    {
        try {

            $country = AllCountries::where('name', $req->name)->first();

            $data = $this->MEGetActiveExtBranchesMoEx($country->cca3);

            if (isset($data['Id'])) {


                $result = $this->MEGetAdditionalList($country->cca3, $data['Id']);


                if (isset($result['error'])) {
                    $status = 400;
                    $resData = ['data' => [], 'message' => $result['error']->Description, 'status' => $status];
                } else {

                    $status = 200;
                    $resData = ['data' => $result, 'message' => 'Success', 'status' => $status, 'branchCode' => $data['Id']];
                }
            } else {

                $status = 400;
                $resData = ['data' => [], 'message' => $data['error'], 'status' => $status];
            }
        } catch (\Throwable $th) {
            $status = 400;
            $resData = ['data' => [], 'message' => $th->getMessage(), 'status' => $status];
        }



        return $this->returnJSON($resData, $status);
    }


public function searchForItem($country, $array) {
   foreach ($array as $val) {
       if ($val->country === $country) {
           return $val;
       }
   }
   return null;
}


}
