<?php

namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;

use App\User as User;

use App\SaveMoney as SaveMoney;

use App\EPSVendor as EPSVendor;

use App\PSCharge as PSCharge;

use App\ListOfBanks as ListOfBanks;

use App\TransactionCost as TransactionCost;


use App\Mail\sendEmail;

use Twilio\Rest\Client;

use App\Traits\PaymentGateway;
use App\ThirdPartyIntegration;

trait ExpressPayment
{

    public $Base_Url;
    public $curlPost;
    use PaymentGateway;

    // Get Vendors
    public function getVendors()
    {
        $this->Base_Url = env('EXPRESS_PAY_ENDPOINT_URL') . '/billersandproductandfields';

        try {
            $data = $this->doGet();

            foreach ($data as $dataItem) {

                if (isset($dataItem->productfields[0]->commission)) {

                    $commission = $dataItem->productfields[0]->commission;
                } else {
                    $commission = 0;
                }

                if (isset($dataItem->productfields[0]->charge)) {

                    $charge = $dataItem->productfields[0]->charge;
                } else {
                    $charge = 0;
                }

                $query = [
                    'billerCode' => $dataItem->billerCode,
                    'billerName' => $dataItem->billerName,
                    'commission' => $commission,
                    'charge' => $charge,
                ];


                // EPSVendor::updateOrCreate(['billerCode' => $dataItem->billerCode], $query);
            }


            return $data;
        } catch (\Throwable $th) {

            return [];
        }
    }

    public function getCommissionData($amount, $billerCode, $country)
    {

        $data = EPSVendor::where('billerCode', $billerCode)->first();
        $ourcharge = PSCharge::where('country', $country)->first();


        // Get Commision and Charge
        if ($data->commission != 0) {
            $commission = $data->commission;
        } else {
            $commission = 0;
        }

        if ($data->charge != 0) {
            $charge = $data->charge;
        } else {
            $charge = 0;
        }

        $data['commission'] = $commission;
        $data['charge'] = $charge;

        if (isset($ourcharge)) {
            if ($commission != 0) {
                $newPercent = $commission * ($ourcharge->percent / 100);
                $data['discountPercent'] = $newPercent;
                $data['walletDiscount'] = $amount * $newPercent;

                $data['walletCharge'] = $amount - $data['walletDiscount'];
            } else {
                $newPercent = $charge * ($ourcharge->percent / 100);
                $data['discountPercent'] = $newPercent;
                $data['walletDiscount'] = $newPercent;
                $data['walletCharge'] = $amount + $data['walletDiscount'];
            }
        } else {

            $ourcharge = PSCharge::where('country', "Nigeria")->first();

            if ($commission != 0) {
                $newPercent = $commission * ($ourcharge->percent / 100);
                $data['discountPercent'] = $newPercent;
                $data['walletDiscount'] = $amount * $newPercent;

                $data['walletCharge'] = $amount - $data['walletDiscount'];
            } else {
                $newPercent = $charge * ($ourcharge->percent / 100);
                $data['discountPercent'] = $newPercent;
                $data['walletDiscount'] = $newPercent;
                $data['walletCharge'] = $amount + $data['walletDiscount'];
            }
        }


        // Get our charge

        return $data;
    }

    public function getLookUp($billerCode, $accountNumber)
    {
        $this->Base_Url = env('EXPRESS_PAY_ENDPOINT_URL') . '/lookup';

        $this->curlPost = json_encode([
            'billerCode' => $billerCode,
            'customerAccountNumber' => $accountNumber
        ]);



        $data = $this->doPost();


        return $data;
    }

    public function getUtilityProduct($id)
    {
        $this->Base_Url = env('EXPRESS_PAY_ENDPOINT_URL') . '/productfields/' . $id;

        try {
            $data = $this->doGet();
            return $data;
        } catch (\Throwable $th) {

            return [];
        }
    }

    public function getVerification($paymentToken)
    {

        try {

            $this->Base_Url = (env('APP_ENV') == 'local' ? env('EPXRESS_PAYMENT_URL_DEV') : env('EPXRESS_PAYMENT_URL_PROD')) . 'api/Payments/VerifyPayment';


            $this->curlPost = json_encode([
                'transactionId' => $paymentToken,
            ]);



            // TODO1:: Direct Payment to EXBC server,
            // TODO2:: Get response from EXBC server and return result to PaySprint...


            $data = $this->doPayPost();





            return $data;
        } catch (\Throwable $th) {

            $data = $this->newVerification($paymentToken);


            return $data;
        }
    }


    // New Verification query...
    public function newVerification($paymentToken){
        try {

            $this->Base_Url = (env('APP_ENV') == 'local' ? env('EPXRESS_PAYMENT_NEW_URL_DEV') : env('EPXRESS_PAYMENT_NEW_URL_PROD')) . 'v1/payments/query';


            $this->curlPost = json_encode([
                'transactionId' => $paymentToken,
            ]);


            $data = $this->doPayPost();

            return $data;
        } catch (\Throwable $th) {


            return [];
        }
    }

    // Process Transaction
    public function processTransaction($postRequest, $bearerToken)
    {

        $getActive = ThirdPartyIntegration::where('platform', 'Express Solution')->first();

        if ($getActive->status == false) {

            $responseCode = 00;
            $responseMessage = "Utility payment is currently under maintenance. Please try again later";
            $status = 400;

            $data = [
                'responseCode' => $responseCode,
                'responseMessage' => $responseMessage,
                'status' => $status
            ];

            $result = json_encode($data);

            return json_decode($result);
        } else {


            $checks = $this->checkAccount($postRequest, $bearerToken);




            if ($checks == true) {
                $this->Base_Url = env('EXPRESS_PAY_ENDPOINT_URL') . '/process-transaction';
                $transaction = [];

                for ($i = 0; $i < count($postRequest['fieldName']); $i++) {



                    if ($postRequest['fieldName'] != null) {

                        $transaction[] = [
                            'fieldName' => $postRequest['fieldName'][$i],
                            'fieldValue' => $postRequest['fieldValue'][$i],
                            'fieldControlType' => $postRequest['fieldControlType'][$i],
                        ];
                    } else {
                        $transaction[] = [
                            'fieldName' => $postRequest['fieldName'],
                            'fieldValue' => $postRequest['fieldValue'],
                            'fieldControlType' => $postRequest['fieldControlType'],
                        ];
                    }
                }


                $this->curlPost = json_encode([
                    'billerCode' => $postRequest['billerCode'],
                    'productId' => $postRequest['productId'],
                    'transDetails' => $transaction,
                ]);



                $data = $this->doPost();

                return $data;
            } else {

                $responseCode = 00;
                $responseMessage = "Your wallet balance is low for this transaction. Please add money";
                $status = 400;

                $data = [
                    'responseCode' => $responseCode,
                    'responseMessage' => $responseMessage,
                    'status' => $status
                ];

                $result = json_encode($data);

                return json_decode($result);
            }
        }
    }

    public function checkAccount($data, $bearerToken)
    {

        $thisuser = User::where('api_token', $bearerToken)->first();



        $minBal = $this->minimumWithBal($thisuser->country);

        $wallBal = $thisuser->wallet_balance - $minBal;

        $walletBalance = $wallBal;

        $transaction = [];



        if ($thisuser->country == "Nigeria") {
            $inputamount = $data['commissiondeduct'] + $data['amounttosend'];
        } else {
            $myamount = ($data['commissiondeduct'] + 0.01) + $data['amounttosend'];
            // Convert currency to Dollar
            $inputamount = $this->payBillCurrencyConvert("NGN", $thisuser->currencyCode, $myamount, 'utilitypurchase');

        }





        for ($i = 0; $i < count($data['fieldName']); $i++) {

            if ($thisuser->country == "Nigeria") {

                if ($walletBalance >= $inputamount) {

                    if ($data['fieldName'] != null) {

                        if ($data['fieldName'][$i] == "Amount" || $data['fieldName'][$i] == "amount") {

                            if ($inputamount >= $data['fieldValue'][$i]) {
                                $response = true;
                            } else {
                                $response = false;
                            }
                        }

                        // For DSTV and GOTV

                        if ($data['billerCode'] == "DSTV2" || $data['billerCode'] == "GOTV2" || $data['billerCode'] == "startimes" || $data['billerCode'] == "DSTV1" || $data['billerCode'] == "GOTV1") {

                            if ($data['fieldName'][$i] == "Select Package (Amount)" || $data['fieldName'][$i] == "Select Package" || $data['fieldName'][$i] == "Product") {

                                if ($inputamount >= $data['fieldValue'][$i]) {
                                    $response = true;
                                } else {
                                    $response = false;
                                }
                            }
                        }
                    } else {
                        $response = false;
                    }
                } else {
                    $response = false;
                }
            } else {


                if ($walletBalance >= $myamount) {



                    if ($data['fieldName'] != null) {

                        if ($data['fieldName'][$i] == "Amount" || $data['fieldName'][$i] == "amount") {


                            if (round($inputamount, 2) >= $data['fieldValue'][$i]) {
                                $response = true;
                            } else {
                                $response = false;
                            }


                        }

                        // For DSTV and GOTV

                        if ($data['billerCode'] == "DSTV2" || $data['billerCode'] == "GOTV2" || $data['billerCode'] == "startimes" || $data['billerCode'] == "DSTV1" || $data['billerCode'] == "GOTV1") {

                            if ($data['fieldName'][$i] == "Select Package (Amount)" || $data['fieldName'][$i] == "Select Package" || $data['fieldName'][$i] == "Product") {

                                if (round($inputamount, 2) >= $data['fieldValue'][$i]) {
                                    $response = true;
                                } else {
                                    $response = false;
                                }
                            }
                        }
                    } else {
                        $response = false;
                    }
                } else {
                    $response = false;
                }
            }
        }


        return $response;
    }

    // Generate Hash for Payment

    public function generateHash($amount, $email, $firstname, $lastname, $transactionId, $phone, $api_token, $commissiondeduct, $amounttosend, $currencyCode, $conversionamount, $commission)
    {


        try {
            SaveMoney::updateOrCreate(['merchantId' => $api_token], [
                'amount' => $amount,
                'amounttosend' => $amounttosend,
                'currencyCode' => $currencyCode,
                'conversionamount' => $conversionamount,
                'commissiondeduct' => $commissiondeduct,
                'merchantId' => $api_token,
                'transactionId' => $transactionId,
                'commission' => $commission
            ]);

            $pb_key = env('EXPRESS_WEB_PAY_PUBLIC_KEY');

            $seckey = env('EXPRESS_WEB_PAY_SECRET_KEY');

            $country = "NG";

            $currency = "NGN";

            $callback_url = route('express callback');

            $logo_url = "https://res.cloudinary.com/pilstech/image/upload/v1617797525/paysprint_asset/paysprint_with_name_black_and_yellow_png_do13ha.png";

            $options = array(
                "amount" => $amount,
                "email" => $email,
                "firstName" => $firstname,
                "transactionId" => $transactionId,
                "lastName" => $lastname,
                "country" => $country,
                "currency" => $currency,
                "phoneNumber" => $phone,
                "callbackUrl" => $callback_url
            );



            // The keys in step 1 above are sorted by their ASCII value

            ksort($options);


            $hashedPayload = '';

            foreach ($options as $key => $value) {

                $hashedPayload .= $value;
            }


            $completeHash = $pb_key . $hashedPayload;





            $hash = hash('sha256', $completeHash);



            return $hash;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function doGet()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->Base_Url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'webkey: ' . env('EXPRESS_PAY_WEBKEY'),
                'Authorization: Basic ' . env('EXPRESS_PAY_BASIC')
            ),
        ));

        $response = curl_exec($curl);


        curl_close($curl);

        return json_decode($response);
    }

    public function doPost()
    {


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->Base_Url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $this->curlPost,
            CURLOPT_HTTPHEADER => array(
                'webkey: ' . env('EXPRESS_PAY_WEBKEY'),
                'accountid: ' . env('EXPRESS_PAY_ACCOUNTID'),
                'Authorization: Basic ' . env('EXPRESS_PAY_BASIC'),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }

    public function doPayPost()
    {



        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->Base_Url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $this->curlPost,
            CURLOPT_HTTPHEADER => array(
                'Authorization: bearer ' . (env('APP_ENV') == "local" ? env('EPXRESS_PAYMENT_KEY_DEV') : env('EPXRESS_PAYMENT_KEY_PROD')),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }

    public function payBillCurrencyConvert($billerCurrency, $myCurrency, $amount, $route = null)
    {

        // Get Markup
        $markuppercent = $this->markupPercentage();

        $markValue = (1 + ($markuppercent[0]->percentage / 100));

        // EPS currency
        $currency = 'USD' . $billerCurrency;

        $amount = $amount;

        // Foreign currency
        $localCurrency = 'USD' . $myCurrency;

        $access_key = '6173fa628b16d8ce1e0db5cfa25092ac';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.currencylayer.com/live?access_key=' . $access_key,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Cookie: __cfduid=d430682460804be329186d07b6e90ef2f1616160177'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $result = json_decode($response);




        if ($result->success == true) {

            // Conversion Rate Local to USD currency ie Y = 4000NGN / 380NGN(1 USD to Naira)
            // $convertLocal = ($amount / $result->quotes->$localCurrency) * $markValue;

            if($localCurrency === 'USDUSD'){
                $localConv = 1;
            }
            else{
                $localConv = $result->quotes->$localCurrency * $markValue;
            }



            if($localCurrency === $currency){
                    $convertLocal = $amount / $localConv;
            }
            elseif($localCurrency !== 'USDUSD' && $currency !== 'USDUSD'){
                $convertLocal = ($amount / $localConv) * $markValue;
            }
            else{
                $convertLocal = $amount / $localConv;
            }


            // Converting your USD value to other currency ie CAD * Y
            $convRate = ($currency !== 'USDUSD' ? ($result->quotes->$currency * $markValue) : 1) * $convertLocal;


            $actualRate = ($currency !== 'USDUSD' ? ($result->quotes->$currency * $markValue) : 1) * $convertLocal;
                // $convRate = $actualRate * 95/100;


                $this->calculateBufferedTransaction($actualRate, $convRate, $route);


            $message = 'success';
        } else {
            $convRate = "Sorry we can not process your transaction this time, try again later!.";
            $message = 'failed';
        }



        $amountConvert = $convRate;

        return $amountConvert;
    }

    public function minimumWithBal($country)
    {

        try {
            // Get Minimum Wallet Balance
            $minimumBalance = TransactionCost::where('method', 'Minimum Balance')->where('country', $country)->first();


            if (isset($minimumBalance) == true) {
                $data = $minimumBalance->fixed;
            } else {
                $data = 0;
            }


            return $data;
        } catch (\Throwable $th) {
            // Log::error('Error: '.$th->getMessage());

            $this->slack('Error: ' . $th->getMessage(), $room = "error-logs", $icon = ":longbox:", env('LOG_SLACK_WEBHOOK_URL'));
        }
    }
}
