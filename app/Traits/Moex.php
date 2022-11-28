<?php

namespace App\Traits;

use SoapClient;

use App\AllCountries;
use App\Classes\TWSauth;
use App\MoexTransaction;
use App\ConversionCountry;
use App\Traits\PaymentGateway;
use function GuzzleHttp\json_decode;

trait Moex
{
    use PaymentGateway;

    public $moexPost;

    public function getCountryFee(String $amount, String $payoutcurrency, String $payoutMethod)
    {
        $data = AllCountries::where('currencyCode', $payoutcurrency)->first();

        return $data;
    }


    public function confirmMoexTransactionId($transactionId)
    {

        $response = $this->MEGetTransactionMoEx($transactionId);


        if ($response['return'] === 0) {
            $responseData = [
                'transactionId' => $response['transaction']->TransactionId,
                'transactionDate' => $response['transaction']->TransactionDate,
                'senderId' => $response['transaction']->SenderId,
                'sender' => $response['transaction']->Sender,
                'senderName' => $response['transaction']->SenderName,
                'senderLastName' => $response['transaction']->SenderLastName,
                'senderLastName2' => $response['transaction']->SenderLastName2,
                'senderAddress' => $response['transaction']->SenderAddress,
                'senderCity' => $response['transaction']->SenderCity,
                'senderCountry' => $response['transaction']->SenderCountry,
                'senderIdDocumentNumber' => $response['transaction']->SenderIdDocumentNumber,
                'senderIdDocumentType' => $response['transaction']->SenderIdDocumentType,
                'receiverId' => $response['transaction']->ReceiverId,
                'receiver' => $response['transaction']->Receiver,
                'receiverName' => $response['transaction']->ReceiverName,
                'receiverLastName' => $response['transaction']->ReceiverLastName,
                'receiverLastName2' => $response['transaction']->ReceiverLastName2,
                'receiverAddress' => $response['transaction']->ReceiverAddress,
                'receiverCity' => $response['transaction']->ReceiverCity,
                'receiverCountry' => $response['transaction']->ReceiverCountry,
                'receiverPhone2' => $response['transaction']->ReceiverPhone2,
                'receiverIdDocumentNumber' => $response['transaction']->ReceiverIdDocumentNumber,
                'receiverIdDocumentType' => $response['transaction']->ReceiverIdDocumentType,
                'receiverReference' => $response['transaction']->ReceiverReference,
                'bankDeposit' => $response['transaction']->BankDeposit,
                'bankName' => $response['transaction']->BankName,
                'bankAddress' => $response['transaction']->BankAddress,
                'bankAccount' => $response['transaction']->BankAccount,
                'amountToPay' => $response['transaction']->AmountToPay,
                'currencyToPay' => $response['transaction']->CurrencyToPay,
                'amountSent' => $response['transaction']->AmountSent,
                'currencySent' => $response['transaction']->CurrencySent,
                'senderMessage' => $response['transaction']->SenderMessage,
                'paymentBranchId' => $response['transaction']->PaymentBranchId,
                'paymentBranchName' => $response['transaction']->PaymentBranchName,
                'paymentBranchAddress' => $response['transaction']->PaymentBranchAddress,
                'paymentBranchAuxId' => $response['transaction']->PaymentBranchAuxId,
                'originCountry' => $response['transaction']->OriginCountry,
                'reference' => $response['transaction']->Reference,
                'transactionStatus' => $response['transaction']->TransactionStatus,
                'paymentDate' => $response['transaction']->PaymentDate,
                'confirmationDate' => $response['transaction']->ConfirmationDate,
            ];
        } else {
            $responseData = [
                'error' => $response['error']->Description
            ];
        }


        return $responseData;
    }

    public function MEGetTransactionMoEx($reference)
    {
        $login = $this->twsAuthConfig();

        $clientSoap = new \SoapClient($login->url_wsdl);

        $BranchesMoex = $clientSoap->__soapCall("MEGetTransactionMoEx", [
            "Login" => $login,
            "Reference" => $reference
        ]);


        return $BranchesMoex;
    }


    public function addTransactionToMoex($data)
    {

        $response = $this->MEAddTransaction($data);


        if ($response['error']->Description !== "") {
            $responseData = [
                'error' => $response['error']->Description
            ];
        } else {
            $responseData = [
                'transactionId' => $response['output']->TransactionId,
                'transactionDate' => $response['output']->TransactionDate,
                'senderId' => $response['output']->SenderId,
                'sender' => $response['output']->Sender,
                'senderName' => $response['output']->SenderName,
                'senderLastName' => $response['output']->SenderLastName,
                'senderLastName2' => $response['output']->SenderLastName2,
                'senderAddress' => $response['output']->SenderAddress,
                'senderCity' => $response['output']->SenderCity,
                'senderCountry' => $response['output']->SenderCountry,
                'senderIdDocumentNumber' => $response['output']->SenderIdDocumentNumber,
                'senderIdDocumentType' => $response['output']->TransactionId,
                'receiverId' => $response['output']->ReceiverId,
                'receiver' => $response['output']->Receiver,
                'receiverAddress' => $response['output']->ReceiverAddress,
                'receiverCity' => $response['output']->ReceiverCity,
                'receiverCountry' => $response['output']->ReceiverCountry,
                'bankDeposit' => $response['output']->BankDeposit,
                'bankName' => $response['output']->BankName,
                'bankAddress' => $response['output']->BankAddress,
                'bankAccount' => $response['output']->BankAccount,
                'amountToPay' => $response['output']->AmountToPay,
                'currencyToPay' => $response['output']->CurrencyToPay,
                'amountSent' => $response['output']->AmountSent,
                'currencySent' => $response['output']->CurrencySent,
                'senderMessage' => $response['output']->SenderMessage,
                'paymentBranchId' => $response['output']->PaymentBranchId,
                'paymentBranchName' => $response['output']->PaymentBranchName,
                'paymentBranchAddress' => $response['output']->PaymentBranchAddress,
                'paymentBranchPhone' => $response['output']->PaymentBranchPhone,
                'paymentBranchAuxId' => $response['output']->PaymentBranchAuxId,
                'originCountry' => $response['output']->OriginCountry,
                'auxiliaryInfo' => $response['output']->AuxiliaryInfo
            ];
        }


        return $responseData;
    }


    public function availableBranchList($country)
    {

        $doc = new \DOMDocument('1.0', 'utf-8');
        $responseData = [];

        $this->moexPost = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
                xmlns:urn="urn:WSmoneyIntf-IWSmoney">
                <soapenv:Header/>
                <soapenv:Body>
                <urn:MEGetActiveExtBranchesMoEx
                soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                <login xsi:type="urn:TWSauth" xmlns:urn="urn:WSmoneyClasses">
                    <Username xsi:type="xsd:string">' . config("constants.moex.username") . '</Username>
                    <Password xsi:type="xsd:string">' . config("constants.moex.password") . '</Password>
                    <Version xsi:type="xsd:string">' . config("constants.moex.version") . '</Version>
                </login>
                <IdCountry xsi:type="xsd:string">' . $country . '</IdCountry>
                </urn:MEGetActiveExtBranchesMoEx>
                </soapenv:Body>
                </soapenv:Envelope>';

        $result = $this->moExPostCurl();



        $doc->loadXML($result);

        $Id = $doc->getElementsByTagName("Id");
        $Description = $doc->getElementsByTagName("Description");

        if ($Id->length > 0) {
            $Id = $Id->item(0)->nodeValue;
            $description = $Description->item(0)->nodeValue;

            $responseData = [
                'branchId' => $Id,
                'description' => $description
            ];
        }



        return $responseData;
    }


    public function generateDailyExchangeRate()
    {

        $dataRate = ConversionCountry::select('country as currency', 'rate', 'official')->where('country', 'Canadian Dollar')->get();

        // Get Markup Value
        $markuppercent = $this->markupPercentage();

        $markValue = (1 + ($markuppercent[0]->percentage / 100));
        $buymarkValue = (1 + ($markuppercent[1]->percentage / 100));

        $sellingRate = $dataRate[0]->official - 0.05;
        $buyingRate = $dataRate[0]->official  + 0.05;
        // $sellingRate = $dataRate[0]->official * $markValue;
        // $buyingRate = $dataRate[0]->official * $buymarkValue;


        $getRate["0"] =  [
            '0' => 'Correspondent',
            '1' => 'Country',
            '2' => 'Currency',
            '3' => 'USD Rate',
            '4' => 'Active',
        ];



        $getRate["1"] =  [
            'Correspondent' => 'PaySprint Inc.',
            'Country' => 'Canada',
            'Currency' => 'CAD',
            'usdRate' => (float)($buyingRate),
            'active' => 'Yes'
        ];



        return json_encode($getRate);
    }





    public function MEGetActiveExtBranchesMoEx($IdCountry)
    {

        $login = $this->twsAuthConfig();

        $clientSoap = new \SoapClient($login->url_wsdl);

        $BranchesMoex = $clientSoap->__soapCall("MEGetActiveExtBranchesMoEx", [
            "Login" => $login,
            "IdCountry" => $IdCountry
        ]);


        if ($BranchesMoex['return'] === 0) {
            $responseData = [
                'Id' => env('APP_ENV') === 'local' ? ($IdCountry === "NGA" ? $BranchesMoex['branches'][1]->Id : $BranchesMoex['branches'][0]->Id) : $BranchesMoex['branches'][0]->Id,
                'Address' => env('APP_ENV') === 'local' ? ($IdCountry === "NGA" ? $BranchesMoex['branches'][1]->Address : $BranchesMoex['branches'][0]->Address) : $BranchesMoex['branches'][0]->Address,
                'AllowBankDeposit' => env('APP_ENV') === 'local' ? ($IdCountry === "NGA" ? $BranchesMoex['branches'][1]->AllowBankDeposit : $BranchesMoex['branches'][0]->AllowBankDeposit) : $BranchesMoex['branches'][0]->AllowBankDeposit,
                'Phone' => env('APP_ENV') === 'local' ? ($IdCountry === "NGA" ? $BranchesMoex['branches'][1]->Phone : $BranchesMoex['branches'][0]->Phone) : $BranchesMoex['branches'][0]->Phone,
                'CityId' => env('APP_ENV') === 'local' ? ($IdCountry === "NGA" ? $BranchesMoex['branches'][1]->CityId : $BranchesMoex['branches'][0]->CityId) : $BranchesMoex['branches'][0]->CityId,
                'CityName' => env('APP_ENV') === 'local' ? ($IdCountry === "NGA" ? $BranchesMoex['branches'][1]->CityName : $BranchesMoex['branches'][0]->CityName) : $BranchesMoex['branches'][0]->CityName
            ];
        } else {
            $responseData = [
                'error' => $BranchesMoex['error']
            ];
        }


        return $responseData;
    }


    public function MEGetAdditionalList($IdCountry, $IdBranch)
    {
        $login = $this->twsAuthConfig();

        $clientSoap = new \SoapClient($login->url_wsdl);

        $BranchesMoex = $clientSoap->__soapCall("MEGetAdditionalList", [
            "Login" => $login,
            "IdCountry" => $IdCountry,
            "IdBranch" => $IdBranch
        ]);


        if ($BranchesMoex['return'] === 0) {
            $responseData = $BranchesMoex['AddList'];
        } else {
            $responseData = [
                'error' => $BranchesMoex['error']
            ];
        }

        return $responseData;
    }


    public function MEAddTransaction($data)
    {


        $login = $this->twsAuthConfig();
        $getBranchId = $this->MEGetActiveExtBranchesMoEx($data['receiverCountry']);


        if (isset($getBranchId['error'])) {
            $responseData = [
                'error' => $getBranchId['error']
            ];

            return $responseData;
        } else {
            $data['paymentBranchId'] = $getBranchId['Id'];
        }


        $clientSoap = new \SoapClient($login->url_wsdl);


        $BranchesMoex = $clientSoap->__soapCall("MEAddTransaction", [
            "Login" => $login,
            "TWStransaction" => [
                "TransactionId" => "",
                "TransactionDate" => date('Y-m-d h:i:s'),
                "SenderId" => "",
                "Sender" => $data['sender'],
                "SenderName" => $data['senderName'],
                "SenderLastName" => $data['senderLastName'],
                "SenderLastName2" => "",
                "SenderAddress" => $data['senderAddress'],
                "SenderCity" => "",
                "SenderCountry" => $data['senderCountry'],
                "SenderIdDocumentNumber" => $data['senderIdDocumentNumber'],
                "SenderIdDocumentType" => $data['senderIdDocumentType'],
                "SenderReference" => "",
                "ReceiverId" => "",
                "Receiver" => $data['receiver'],
                "ReceiverName" => $data['receiverName'],
                "ReceiverLastName" => $data['receiverLastName'],
                "ReceiverLastName2" => "",
                "ReceiverAddress" => "",
                "ReceiverCity" => "",
                "ReceiverCountry" => $data['receiverCountry'],
                "ReceiverPhone" => $data['phoneNumber'],
                "ReceiverPhone2" => "",
                "ReceiverIdDocumentNumber" => "",
                "ReceiverIdDocumentType" => "",
                "ReceiverReference" => "",
                "BankDeposit" => isset($getBranchId['AllowBankDeposit']) ? $getBranchId['AllowBankDeposit'] : $data['bankDeposit'],
                "BankName" => $data['bankName'],
                "BankAddress" => $data['bankAddress'],
                "BankAccount" => $data['bankAccount'],
                "AmountToPay" => $data['amountToPay'],
                "CurrencyToPay" => $data['currencyToPay'],
                "AmountSent" => $data['amountSent'],
                "CurrencySent" => $data['currencySent'],
                "SenderMessage" => "",
                "PaymentBranchId" => $data['paymentBranchId'],
                "PaymentBranchName" => "",
                "PaymentBranchAddress" => "",
                "PaymentBranchPhone" => "",
                "PaymentBranchAuxId" => $data['branchCode'],
                "OriginCountry" => $data['originCountry'],
                "Reference" => $data['reference'],
                "AuxiliaryInfo" => json_encode($data['auxiliaryInfo'])
            ],

        ]);





        if ($BranchesMoex['return'] === 0) {
            $responseData = $BranchesMoex;
            $this->doSlack(json_encode($BranchesMoex), $room = "moex-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
        } else {
            $responseData = [
                'error' => $BranchesMoex['error']->Description
            ];
            $this->doSlack($BranchesMoex['error']->Description, $room = "moex-logs", $icon = ":longbox:", env('LOG_SLACK_WEBHOOK_URL'));
        }




        return $responseData;
    }


    public function twsAuthConfig()
    {

        $login = new TWSauth();
        $login->Username = config("constants.moex.username");
        $login->Password = config("constants.moex.password");
        $login->Version = config("constants.moex.version");
        $login->url_wsdl = config('constants.moex.baseurl');

        return $login;
    }

    // CURL Option...

    public function moExPostCurl()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => config('constants.moex.baseurl'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $this->moexPost,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }


    public function moExGetCurl()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => config('constants.moex.baseurl'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/xml'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }


    // Get Moex Transactions...
    public function getMoexTransactions()
    {
        $data = MoexTransaction::orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function checkTransactionStatus($transactionId)
    {
        $data = $this->MEGetTransactionMoEx($transactionId);

        return $data;
    }

    public function doSlack($message, $room = "success-logs", $icon = ":longbox:", $webhook)
    {
        $room = ($room) ? $room : "success-logs";
        $data = "payload=" . json_encode(array(
            "channel"       =>  "#{$room}",
            "text"          =>  $message,
            "icon_emoji"    =>  $icon
        ));

        // You can get your webhook endpoint from your Slack settings
        $ch = curl_init($webhook);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
