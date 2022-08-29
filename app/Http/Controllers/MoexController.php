<?php

namespace App\Http\Controllers;
use App\AllCountries;
use Illuminate\Http\Request;

class MoexController extends Controller
{


    public function importData(){

        $data=$this->importPartnerFee();
    


        for ($i=0; $i < count($data) ; $i++) { 
            Allcountries::where('name', $data[$i]['country'])->update([
                'range' => implode(',' ,$data[$i]['range']),
                'fee' => implode(',',$data[$i]['fee']),
                'payoutmethod' => implode(',',$data[$i]['payoutmethod']),
                'payoutcurrency' => implode(',',$data[$i]['payoutcurrency'])
                
            ]);
        }

        

      
    }




    public function importPartnerFee()
    {
        $list= [
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
            ],
            '7' =>[
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
                ]
            ],
            '8' =>[
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
                ]
            ],
            '9' =>[
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
                ]
            ],
            '10' =>[
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
                ]
            ],
            '11' =>[
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
                ]
            ],
            '12' =>[
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
            ],
            '13' =>[
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
            ],
            '14' =>[
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
                ]
            ],
            '15' =>[
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
                ]
            ],
            '16' =>[
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
                ]
            ],
            '17' =>[
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
                ]
            ],
            '18' =>[
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
                ]
            ],
            '19' =>[
                'country' => 'CONGO BRAZZAVILLE',
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
                ]
            ],
            '20' =>[
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
                ]
            ],
            '21' =>[
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
                ]
            ],
            '22' =>[
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
                ]
            ],
            '23' =>[
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
                ]
            ],
            '24' =>[
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
                ]
            ],
            '25' =>[
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
                ]
            ],
            '26' =>[
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
                ]
            ],
            '27' =>[
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
                ]
            ],
            '28' =>[
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
                ]
            ],
            '29' =>[
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
                ]
            ],
            '30' =>[
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
                ]
            ],
            '31' =>[
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
                ]
            ],
            '32' =>[
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
                ]
            ],
            '33' =>[
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
                ]
            ],
            '34' =>[
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
                ]
            ],
            '35' =>[
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
                ]
            ],
            '36' =>[
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
                ]
            ],
            '37' =>[
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
                ]
            ],
            '38' =>[
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
                    'CASH/'
                ]
            ],
            '39' =>[
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
                ]
            ],
            '40' =>[
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
                ]
            ],
            '41' =>[
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
                ]
            ],
            '42' =>[
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
                ]
            ],
            '43' =>[
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
                ]
            ],
            '44' =>[
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
                ]
            ],
            '45' =>[
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
                    
                ]
            ],
            '46' =>[
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
                ]
            ],
            '47' =>[
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
                ]
            ],
            '48' =>[
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
                ]
            ],
            '49' =>[
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
                ]
            ],
            '50' =>[
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
                ]
            ],
            '51' =>[
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
                ]
            ],
            '52' =>[
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
                ]
            ],
            '53' =>[
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
                ]
            ],
            '54' =>[
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
                ]
            ],
            '55' =>[
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
                    
                ]
            ],
            '56' =>[
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
                ]
            ],
            '57' =>[
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
                ]
            ],
            '58' =>[
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
                ]
            ],
            '59' =>[
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
                ]
            ],
            '60' =>[
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
                ]
            ],
            '61' =>[
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
                ]
            ],
            '62' =>[
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
                ]
            ],
            '63' =>[
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
                ]
            ],
            '64' =>[
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
                ]
            ],
            '65' =>[
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
                ]
            ],
            '66' =>[
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
                ]
            ],
            '67' =>[
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
                ]
            ],
            '68' =>[
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
                ]
            ],
            '69' =>[
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
                ]
            ],
            '70' =>[
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
                ]
            ],
            '71' =>[
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
                ]
            ],
            '72' =>[
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
                ]
            ],
            '73' =>[
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
                ]
            ],
            '74' =>[
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
                ]
            ],
            '75' =>[
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
                ]
            ],
            '76' =>[
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
                ]
            ],
            '77' =>[
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
                ]
            ],
            '78' =>[
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
                ]
            ],
            '79' =>[
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
                ]
            ],
            '80' =>[
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
                ]
            ],
            '81' =>[
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
                ]
            ],
            '82' =>[
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
                ]
            ],
            '83' =>[
                'country' => 'SURINAM',
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
                ]
            ],
            '84' =>[
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
                ]
            ],
            '85' =>[
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
                ]
            ],
            '86' =>[
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
                ]
            ],
            '87' =>[
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
                ]
            ],
            '88' =>[
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
                ]
            ],
            '89' =>[
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
                ]
            ],
            '90' =>[
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
                ]
            ],
            '91' =>[
                'country' => 'UNITED ARAB EMIRATE',
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
                ]
            ],
            '92' =>[
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
                ]
            ],
            '93' =>[
                'country' => 'UNITED STATE',
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
                ]
            ],
            '94' =>[
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
                ]
            ],
            '95' =>[
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

                ]
            ],
            '96' =>[
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
                ]
            ],
            '97' =>[
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
                ]
            ],
        ];
       

     return $list;
 
    }
    
}
