<?php

namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

trait Trulioo{



    public function identificationAPI($url, $firstname, $lastname, $dayofbirth, $monthofbirth, $yearofbirth, $minimuAge, $streetname, $city, $country, $zipcode, $telephone, $email, $countryCode){


        $name = $firstname.' '.$lastname;

        $gender = null;


        $streetNo = explode(" ", $streetname);

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "DataFields": {
                "PersonInfo": {
                    "AdditionalFields": {
                        "FullName": "'.$name.'"
                    },
                    "FirstGivenName": "'.$firstname.'",
                    "SecondSurname": "'.$lastname.'",
                    "FirstSurName": "'.$lastname.'",
                    "DayOfBirth": "'.$dayofbirth.'",
                    "MonthOfBirth": "'.$monthofbirth.'",
                    "YearOfBirth": "'.$yearofbirth.'",
                    "MinimumAge": "'.$minimuAge.'"
                },
                "Location": {
                    "BuildingNumber": "'.$streetNo[0].'",
                    "StreetName": "'.$streetname.'",
                    "City": "'.$city.'",
                    "Country": "'.$country.'",
                    "StateProvinceCode": "ON",
                    "PostalCode": "'.$zipcode.'",
                },
                "Communication":{
                    "MobileNumber":"'.$telephone.'",
                    "EmailAddress":"'.$email.'"
                },

            },
            "AcceptTruliooTermsAndConditions": true,
            "CallBackUrl": "https://api.globaldatacompany.com/connection/v1/async-callback",
            "CleansedAddress": true,
            "ConfigurationName": "Identity Verification",
            "CountryCode": "'.$countryCode.'",
            "VerboseMode": true
        }',

        
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic RVhCQ19JRFZfQVBJOlBheXNwcmludGFwaTIwMjEh',
            'Content-Type: application/json',
            'Cookie: secure; incap_ses_1043_2454110=1ymffNN0lAblUYeASHt5DnSbjGAAAAAA1OvOPjB/O9ngfion/4/o4g==; visid_incap_2454110=Hr+h4VOQRvyVmLwrlcpvTZvRimAAAAAAQUIPAAAAAAC2sDXypQFS5aEhZuG2ZRte'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);


        return json_decode($response);
    }



    public function transStatus($transId){

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.globaldatacompany.com/verifications/v1/transaction/'.$transId.'/status',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic RVhCQ19EZW1vX0lEVl9BUEk6UGF5c3ByaW50YXBpMjAyMSE=',
            'Cookie: secure; secure; incap_ses_1043_2454110=8C7aEUgfLgwzt4iASHt5DkqwjGAAAAAAxg0MovwEfBmOwOQ0rUWiBw==; visid_incap_2454110=Hr+h4VOQRvyVmLwrlcpvTZvRimAAAAAAQUIPAAAAAAC2sDXypQFS5aEhZuG2ZRte'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }


    public function getTransRec($transRecordId){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.globaldatacompany.com/verifications/v1/transactionrecord/'.$transRecordId,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic RVhCQ19EZW1vX0lEVl9BUEk6UGF5c3ByaW50YXBpMjAyMSE=',
            'Cookie: secure; secure; incap_ses_1043_2454110=8C7aEUgfLgwzt4iASHt5DkqwjGAAAAAAxg0MovwEfBmOwOQ0rUWiBw==; visid_incap_2454110=Hr+h4VOQRvyVmLwrlcpvTZvRimAAAAAAQUIPAAAAAAC2sDXypQFS5aEhZuG2ZRte'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        // Send Response back to User
        


        return json_decode($response);

    }


}