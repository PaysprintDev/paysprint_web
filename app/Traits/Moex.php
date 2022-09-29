<?php

namespace App\Traits;

use App\AllCountries;

use function GuzzleHttp\json_decode;

trait Moex
{

    public $moexPost;

    public function getCountryFee(String $amount, String $payoutcurrency, String $payoutMethod)
    {
        $data = AllCountries::where('currencyCode', $payoutcurrency)->first();

        return $data;
    }


    public function confirmMoexTransactionId($transactionId)
    {
        $doc = new \DOMDocument('1.0', 'utf-8');
        $responseData = [];

        $this->moexPost = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:WSmoneyIntf-IWSmoney">
                <soapenv:Header/>
                <soapenv:Body>
                    <urn:MEGetExtTransactionMoEx soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                        <login xsi:type="urn:TWSauth" xmlns:urn="urn:WSmoneyClasses">
                            <Username xsi:type="xsd:string">' . config("constants.moex.username") . '</Username>
                            <Password xsi:type="xsd:string">' . config("constants.moex.password") . '</Password>
                            <Version xsi:type="xsd:string">' . config("constants.moex.version") . '</Version>
                        </login>
                        <Reference xsi:type="xsd:string">' . $transactionId . '</Reference>
                        <phoneConfig xsi:type="urn:TWSPhoneConfig" xmlns:urn="urn:WSmoneyClasses">
                            <IncSenderCountryCode xsi:type="xsd:boolean">true</IncSenderCountryCode>
                            <SenderExitPrefix xsi:type="xsd:string">+</SenderExitPrefix>
                            <IncSenderHyphen xsi:type="xsd:boolean">false</IncSenderHyphen>
                            <IncReceiverCountryCode xsi:type="xsd:boolean">true</IncReceiverCountryCode>
                            <ReceiverExitPrefix xsi:type="xsd:string">+</ReceiverExitPrefix>
                            <IncReceiverHyphen xsi:type="xsd:boolean">false</IncReceiverHyphen>
                        </phoneConfig>
                    </urn:MEGetExtTransactionMoEx>
                </soapenv:Body>
            </soapenv:Envelope>';


        $result = $this->moExPostCurl();

        $doc->loadXML($result);


        $TransactionId     = $doc->getElementsByTagName("TransactionId");
        $TransactionDate     = $doc->getElementsByTagName("TransactionDate");
        $SenderId     = $doc->getElementsByTagName("SenderId");
        $Sender     = $doc->getElementsByTagName("Sender");
        $SenderAddress     = $doc->getElementsByTagName("SenderAddress");
        $SenderCity     = $doc->getElementsByTagName("SenderCity");
        $SenderCountry     = $doc->getElementsByTagName("SenderCountry");
        $SenderIdDocumentNumber     = $doc->getElementsByTagName("SenderIdDocumentNumber");
        $SenderIdDocumentType     = $doc->getElementsByTagName("SenderIdDocumentType");
        $ReceiverId     = $doc->getElementsByTagName("ReceiverId");
        $Receiver     = $doc->getElementsByTagName("Receiver");
        $ReceiverAddress     = $doc->getElementsByTagName("ReceiverAddress");
        $ReceiverCity     = $doc->getElementsByTagName("ReceiverCity");
        $ReceiverCountry     = $doc->getElementsByTagName("ReceiverCountry");
        $BankDeposit     = $doc->getElementsByTagName("BankDeposit");
        $BankName     = $doc->getElementsByTagName("BankName");
        $BankAddress     = $doc->getElementsByTagName("BankAddress");
        $BankAccount     = $doc->getElementsByTagName("BankAccount");
        $AmountToPay     = $doc->getElementsByTagName("AmountToPay");
        $CurrencyToPay     = $doc->getElementsByTagName("CurrencyToPay");
        $AmountSent     = $doc->getElementsByTagName("AmountSent");
        $CurrencySent     = $doc->getElementsByTagName("CurrencySent");
        $SenderMessage     = $doc->getElementsByTagName("SenderMessage");
        $PaymentBranchId     = $doc->getElementsByTagName("PaymentBranchId");
        $PaymentBranchName     = $doc->getElementsByTagName("PaymentBranchName");
        $PaymentBranchAddress     = $doc->getElementsByTagName("PaymentBranchAddress");
        $PaymentBranchAuxId     = $doc->getElementsByTagName("PaymentBranchAuxId");
        $OriginCountry     = $doc->getElementsByTagName("OriginCountry");
        $TransactionStatus     = $doc->getElementsByTagName("TransactionStatus");


        if ($TransactionId->length > 0) {
            $transactionId = $TransactionId->item(0)->nodeValue;
            $transactionDate = $TransactionDate->item(0)->nodeValue;
            $senderId = $SenderId->item(0)->nodeValue;
            $sender = $Sender->item(0)->nodeValue;
            $senderAddress = $SenderAddress->item(0)->nodeValue;
            $senderCity = $SenderCity->item(0)->nodeValue;
            $senderCountry = $SenderCountry->item(0)->nodeValue;
            $senderIdDocumentNumber = $SenderIdDocumentNumber->item(0)->nodeValue;
            $senderIdDocumentType = $SenderIdDocumentType->item(0)->nodeValue;
            $receiverId = $ReceiverId->item(0)->nodeValue;
            $receiver = $Receiver->item(0)->nodeValue;
            $receiverAddress = $ReceiverAddress->item(0)->nodeValue;
            $receiverCity = $ReceiverCity->item(0)->nodeValue;
            $receiverCountry = $ReceiverCountry->item(0)->nodeValue;
            $bankDeposit = $BankDeposit->item(0)->nodeValue;
            $bankName = $BankName->item(0)->nodeValue;
            $bankAddress = $BankAddress->item(0)->nodeValue;
            $bankAccount = $BankAccount->item(0)->nodeValue;
            $amountToPay = $AmountToPay->item(0)->nodeValue;
            $currencyToPay = $CurrencyToPay->item(0)->nodeValue;
            $amountSent = $AmountSent->item(0)->nodeValue;
            $currencySent = $CurrencySent->item(0)->nodeValue;
            $senderMessage = $SenderMessage->item(0)->nodeValue;
            $paymentBranchId = $PaymentBranchId->item(0)->nodeValue;
            $paymentBranchName = $PaymentBranchName->item(0)->nodeValue;
            $paymentBranchAddress = $PaymentBranchAddress->item(0)->nodeValue;
            $paymentBranchAuxId = $PaymentBranchAuxId->item(0)->nodeValue;
            $originCountry = $OriginCountry->item(0)->nodeValue;
            $transactionStatus = $TransactionStatus->item(0)->nodeValue;


            $responseData = [
                'transactionId' => $transactionId,
                'transactionDate' => $transactionDate,
                'senderId' => $senderId,
                'sender' => $sender,
                'senderAddress' => $senderAddress,
                'senderCity' => $senderCity,
                'senderCountry' => $senderCountry,
                'senderIdDocumentNumber' => $senderIdDocumentNumber,
                'senderIdDocumentType' => $senderIdDocumentType,
                'receiverId' => $receiverId,
                'receiver' => $receiver,
                'receiverAddress' => $receiverAddress,
                'receiverCity' => $receiverCity,
                'receiverCountry' => $receiverCountry,
                'bankDeposit' => $bankDeposit,
                'bankName' => $bankName,
                'bankAddress' => $bankAddress,
                'bankAccount' => $bankAccount,
                'amountToPay' => $amountToPay,
                'currencyToPay' => $currencyToPay,
                'amountSent' => $amountSent,
                'currencySent' => $currencySent,
                'senderMessage' => $senderMessage,
                'paymentBranchId' => $paymentBranchId,
                'paymentBranchName' => $paymentBranchName,
                'paymentBranchAddress' => $paymentBranchAddress,
                'paymentBranchAuxId' => $paymentBranchAuxId,
                'originCountry' => $originCountry,
                'transactionStatus' => $transactionStatus
            ];
        }

        return $responseData;
    }


    public function addTransactionToMoex($data)
    {

        $data['paymentBranchId'] = env('APP_ENV') === 'local' ? '8349-0001' : '0001-0001';
        $data['receiverCountry'] = env('APP_ENV') === 'local' ? 'ESP' : $data['receiverCountry'];
        $data['senderCountry'] = env('APP_ENV') === 'local' ? 'ESP' : $data['senderCountry'];
        $data['originCountry'] = env('APP_ENV') === 'local' ? 'ESP' : $data['originCountry'];
        $data['currencyToPay'] = env('APP_ENV') === 'local' ? 'EUR' : $data['currencyToPay'];
        $data['currencySent'] = env('APP_ENV') === 'local' ? 'EUR' : $data['currencySent'];

        dd($data);



        $doc = new \DOMDocument('1.0', 'utf-8');
        $responseData = [];

        $this->moexPost = '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:WSmoneyIntf-IWSmoney">
        <soapenv:Header/>
        <soapenv:Body>
            <urn:MEAddTransaction soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                <login xsi:type="urn:TWSauth" xmlns:urn="urn:WSmoneyClasses">
                    <Username xsi:type="xsd:string">' . config("constants.moex.username") . '</Username>
                    <Password xsi:type="xsd:string">' . config("constants.moex.password") . '</Password>
                    <Version xsi:type="xsd:string">' . config("constants.moex.version") . '</Version>
                </login>
                <transaction xsi:type="urn:TWStransaction" xmlns:urn="urn:WSmoneyClasses">
                    <TransactionId xsi:type="xsd:string">?</TransactionId>
                    <TransactionDate xsi:type="xsd:dateTime">'.date('Y-m-d h:i:s').'</TransactionDate>
                    <SenderId xsi:type="xsd:string">?</SenderId>
                    <Sender xsi:type="xsd:string">' . $data['sender'] . '</Sender>
                    <SenderName xsi:type="xsd:string">' . $data['senderName'] . '</SenderName>
                    <SenderLastName xsi:type="xsd:string">' . $data['senderLastName'] . '</SenderLastName>
                    <SenderLastName2 xsi:type="xsd:string">?</SenderLastName2>
                    <SenderAddress xsi:type="xsd:string">' . $data['senderAddress'] . '</SenderAddress>
                    <SenderCity xsi:type="xsd:string">?</SenderCity>
                    <SenderCountry xsi:type="xsd:string">' . $data['senderCountry'] . '</SenderCountry>
                    <SenderIdDocumentNumber xsi:type="xsd:string">' . $data['senderIdDocumentNumber'] . '</SenderIdDocumentNumber>
                    <SenderIdDocumentType xsi:type="xsd:string">' . $data['senderIdDocumentType'] . '</SenderIdDocumentType>
                    <SenderReference xsi:type="xsd:string">?</SenderReference>
                    <ReceiverId xsi:type="xsd:string">?</ReceiverId>
                    <Receiver xsi:type="xsd:string">' . $data['receiver'] . '</Receiver>
                    <ReceiverName xsi:type="xsd:string">' . $data['receiverName'] . '</ReceiverName>
                    <ReceiverLastName xsi:type="xsd:string">' . $data['receiverLastName'] . '</ReceiverLastName>
                    <ReceiverLastName2 xsi:type="xsd:string">?</ReceiverLastName2>
                    <ReceiverAddress xsi:type="xsd:string">?</ReceiverAddress>
                    <ReceiverCity xsi:type="xsd:string">?</ReceiverCity>
                    <ReceiverCountry xsi:type="xsd:string">' . $data['receiverCountry'] . '</ReceiverCountry>
                    <ReceiverPhone xsi:type="xsd:string">?</ReceiverPhone>
                    <ReceiverPhone2 xsi:type="xsd:string">?</ReceiverPhone2>
                    <ReceiverIdDocumentNumber xsi:type="xsd:string">?</ReceiverIdDocumentNumber>
                    <ReceiverIdDocumentType xsi:type="xsd:string">?</ReceiverIdDocumentType>
                    <ReceiverReference xsi:type="xsd:string">?</ReceiverReference>
                    <BankDeposit xsi:type="xsd:boolean">' . $data['bankDeposit'] . '</BankDeposit>
                    <BankName xsi:type="xsd:string">' . $data['bankName'] . '</BankName>
                    <BankAddress xsi:type="xsd:string">' . $data['bankAddress'] . '</BankAddress>
                    <BankAccount xsi:type="xsd:string">' . $data['bankAccount'] . '</BankAccount>
                    <AmountToPay xsi:type="xsd:double">' . $data['amountToPay'] . '</AmountToPay>
                    <CurrencyToPay xsi:type="xsd:string">' . $data['currencyToPay'] . '</CurrencyToPay>
                    <AmountSent xsi:type="xsd:double">' . $data['amountSent'] . '</AmountSent>
                    <CurrencySent xsi:type="xsd:string">' . $data['currencySent'] . '</CurrencySent>
                    <SenderMessage xsi:type="xsd:string">?</SenderMessage>
                    <PaymentBranchId xsi:type="xsd:string">' . $data['paymentBranchId'] . '</PaymentBranchId>
                    <PaymentBranchName xsi:type="xsd:string">?</PaymentBranchName>
                    <PaymentBranchAddress xsi:type="xsd:string">?</PaymentBranchAddress>
                    <PaymentBranchPhone xsi:type="xsd:string">?</PaymentBranchPhone>
                    <PaymentBranchAuxId xsi:type="xsd:string">?</PaymentBranchAuxId>
                    <OriginCountry xsi:type="xsd:string">' . $data['originCountry'] . '</OriginCountry>
                    <Reference xsi:type="xsd:string">?</Reference>
                    <AuxiliaryInfo xsi:type="xsd:string">?</AuxiliaryInfo>
                        </transaction>
                    </urn:MEAddTransaction>
                </soapenv:Body>
            </soapenv:Envelope>';


        $result = $this->moExPostCurl();



        $doc->loadXML($result);

        $TransactionId = $doc->getElementsByTagName("TransactionId");
        $Description = $doc->getElementsByTagName("Description");

        if ($TransactionId->length > 0) {
            $transactionId = $TransactionId->item(0)->nodeValue;
            $description = $Description->item(0)->nodeValue;

            $responseData = [
                'transactionId' => $transactionId,
                'description' => $description
            ];
        }
        else{
            $description = $Description->item(0)->nodeValue;
            $responseData = [
                'error' => $description
            ];
        }


        return $responseData;
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
}
