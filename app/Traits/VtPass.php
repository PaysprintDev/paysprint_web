<?php

namespace App\Traits;

/**
 *
 */
trait VtPass
{

    public $vtPassUrl;
    public $vtPassPost;

    public function getBalance()
    {
        try {

            $this->vtPassUrl = config('constants.vtpass.baseurl') . '/balance';

            $data = $this->vtPassGetCurl();
        } catch (\Throwable $th) {
            $data = [
                'error' => $th->getMessage()
            ];
        }

        return $data;
    }

    public function getServiceCategories()
    {
        try {

            $this->vtPassUrl = config('constants.vtpass.baseurl') . '/service-categories';

            $data = $this->vtPassGetCurl();
        } catch (\Throwable $th) {
            $data = [
                'error' => $th->getMessage()
            ];
        }

        return $data;
    }


    public function getByServiceId(String $identifier)
    {
        try {

            $this->vtPassUrl = config('constants.vtpass.baseurl') . '/services?identifier=' . $identifier;

            $data = $this->vtPassGetCurl();
        } catch (\Throwable $th) {
            $data = [
                'error' => $th->getMessage()
            ];
        }

        return $data;
    }

    public function getVariationCodeByServiceId($serviceId)
    {
        try {

            $this->vtPassUrl = config('constants.vtpass.baseurl') . '/service-variations?serviceID=' . $serviceId;

            $data = $this->vtPassGetCurl();
        } catch (\Throwable $th) {
            $data = [
                'error' => $th->getMessage()
            ];
        }

        return $data;
    }

    public function productOption($serviceId, $name)
    {
        try {

            $this->vtPassUrl = config('constants.vtpass.baseurl') . '/options?serviceID=' . $serviceId . '&name=' . $name;

            $data = $this->vtPassGetCurl();
        } catch (\Throwable $th) {
            $data = [
                'error' => $th->getMessage()
            ];
        }

        return $data;
    }

    public function productPurcahse($body)
    {
        try {

            $this->vtPassUrl = config('constants.vtpass.baseurl') . '/pay';

            switch ($body['type']) {
                case 'airtime':
                    $requestData = [
                        'request_id' => date('YmdHis') . time(),
                        'serviceID' => $body['serviceID'],
                        'amount' => $body['amount'],
                        'phone' => $body['phone']
                    ];
                case 'data':
                    $requestData = [
                        'request_id' => date('YmdHis') . time(),
                        'serviceID' => $body['serviceID'],
                        'billersCode' => $body['billersCode'],
                        'variation_code' => $body['variation_code'],
                        'amount' => $body['amount'],
                        'phone' => $body['phone']
                    ];
                case 'tv':
                    $requestData = [
                        'request_id' => date('YmdHis') . time(),
                        'serviceID' => $body['serviceID'],
                        'billersCode' => $body['billersCode'],
                        'variation_code' => $body['variation_code'],
                        'amount' => $body['amount'],
                        'phone' => $body['phone'],
                        'subscription_type' => $body['subscription_type'],
                        'quantity' => $body['quantity']
                    ];
                    break;

                default:
                    $requestData = [];
                    break;
            }

            $this->vtPassPost = $requestData;


            $data = $this->vtPassPostCurl();
        } catch (\Throwable $th) {
            $data = [
                'error' => $th->getMessage()
            ];
        }


        return $data;
    }



    // CURL Option...

    public function vtPassPostCurl()
    {


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->vtPassUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $this->vtPassPost,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . config('constants.vtpass.basic_auth')
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }


    public function vtPassGetCurl()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->vtPassUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . config('constants.vtpass.basic_auth')
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode($response);
    }
}
