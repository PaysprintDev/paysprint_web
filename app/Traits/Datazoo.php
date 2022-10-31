<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait Datazoo
{

    public $datazoobaseUrl;
    public $datazooPost;


   
	public function verifyId($code,$service,$reference,$firstname,$middlename,$lastname,$dob,$gender,$address,$city,$state,$postalcode,$idno)
	{
		 $this->datazoobaseUrl = config("constants.datazoo.baseurl");
		 $this->datazooPost = json_encode([
            "countryCode" => $code,
   			 "service" => [
       			 $service
   				],
    		"clientReference" => $refernce,
   			 "firstName" => $firstname,
   			 "middleName" => $middlename,
   			 "lastName" => $lastname,
   			 "dateOfBirth" => $dob,
   			 "gender" => $gender,
    		"addressElement1" => $address,
   			 "addressElement3" => $city,
   			 "addressElement4" => $state,
   			 "addressElement5" => $postalcode,
   			 "identityVariables" => [
     		   "nationalIDNo" => $idno
				]

        ]);

        $result = $this->dataIdZooCurl();

        return $result;

	}

   


    // CURL Option...

    public function dataIdZooCurl()
    {
       

		$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $this->$datazoobaseUrl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$this->datazooPost,
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
	'Authorization: Bearer ' . config("constants.datazoo.token")
  ),
));

$response = curl_exec($curl);

curl_close($curl);
 return json_decode($response);

    }
}
