<?php


namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\MonerisActivity as MonerisActivity;


trait ElavonPayment{

    
    public function elavonPay(){
        // Provide Converge Credentials
        $merchantID = "2197557"; //Converge 6-Digit Account ID *Not the 10-Digit Elavon Merchant ID*
        $merchantUserID = " 8037927558api"; //Converge User ID *MUST FLAG AS HOSTED API USER IN CONVERGE UI*
        $merchantPIN = "2GQIRGHXSKJMHR99KHUUCXXIA9X9TQI51G20U9VN6SMN6D13HKPQ87GCPNSL7Z3U"; //Converge PIN (64 CHAR A/N)

        $url = "https://api.demo.convergepay.com/hosted-payments/transaction_token"; // URL to Converge demo session token server
        //$url = "https://api.convergepay.com/hosted-payments/transaction_token"; // URL to Converge production session token server

        $hppurl = "https://api.demo.convergepay.com/hosted-payments"; // URL to the demo Hosted Payments Page
        //$hppurl = "https://api.convergepay.com/hosted-payments"; // URL to the production Hosted Payments Page

        /*Payment Field Variables*/

        // In this section, we set variables to be captured by the PHP file and passed to Converge in the curl request.

        $amount= '1.00'; //Hard-coded transaction amount for testing.

        //$amount  = $_POST['ssl_amount'];   //Capture ssl_amount as POST data
        //$firstname  = $_POST['ssl_first_name'];   //Capture ssl_first_name as POST data
        //$lastname  = $_POST['ssl_last_name'];   //Capture ssl_last_name as POST data
        //$merchanttxnid = $_POST['ssl_merchant_txn_id']; //Capture ssl_merchant_txn_id as POST data
        //$invoicenumber = $_POST['ssl_invoice_number']; //Capture ssl_invoice_number as POST data

        //Follow the above pattern to add additional fields to be sent in curl request below.

        $ch = curl_init();    // initialize curl handle
        curl_setopt($ch, CURLOPT_URL,$url); // set POST target URL
        curl_setopt($ch,CURLOPT_POST, true); // set POST method
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //Build the request for the session id. Make sure all payment field variables created above get included in the CURLOPT_POSTFIELDS section below.

        curl_setopt($ch,CURLOPT_POSTFIELDS,
        "ssl_merchant_id=$merchantID".
        "&ssl_user_id=$merchantUserID".
        "&ssl_pin=$merchantPIN".
        "&ssl_transaction_type=ccsale".
        "&ssl_amount=$amount"
        );

        $result = curl_exec($ch); // run the curl to post to Converge


        if ($result === false) {
            echo 'Curl error message: '.curl_error($ch).'<br>';
            echo 'Curl error code: '.curl_errno($ch);
        } else {

            $httpstatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);


            if ($httpstatus == 200) {            
                $sessiontoken = urlencode($result);
                /* Now we redirect to the HPP */
                header("Location: https://api.demo.convergepay.com/hosted-payments?ssl_txn_auth_token=$sessiontoken");  //Demo Redirect
                //header("Location: https://api.convergepay.com/hosted-payments?ssl_txn_auth_token=$sessiontoken"); //Prod Redirect
            }
            else{
                echo 'Response: '.$result.'<br>';
                echo 'HTTP status: '.$httpstatus;
            }
        }

            dd($result);


            curl_close($ch); // Close cURL

            exit;
    }
    

}