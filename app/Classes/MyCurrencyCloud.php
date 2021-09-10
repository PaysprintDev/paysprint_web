<?php

namespace App\Classes;

use CurrencyCloud\CurrencyCloud as CurrencyCloud;
use CurrencyCloud\Session;


class MyCurrencyCloud
{

    // Authenticate Session
    public function authenticateSession()
    {
        $session = new Session(
            Session::ENVIRONMENT_DEMONSTRATION,
            env('CURRENCY_CLOUD_USER_ID'),
            env('CURRENCY_CLOUD_TEST_API_KEY')
        );


        $client = CurrencyCloud::createDefault($session);



        //Authenticate
        $client->authenticate()
            ->login();

        return $client;
    }

    // Get Currencies
    public function getCurrencies()
    {

        $authClient = $this->authenticateSession();


        $currencies =
            $authClient->reference()
            ->availableCurrencies();



        return $currencies;
    }

    // Get Balance
    public function getBalance()
    {

        $authClient = $this->authenticateSession();

        $balances =
            $authClient->balances()
            ->find();


        return $balances->getBalances();
    }
}
