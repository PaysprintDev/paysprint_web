<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait VertoFx
{

    public $vetobaseUrl;
    public $vetoPost;
    public $vertofield;


  public function FxLogin($id,$apikey,$mode)
  {
     $this->vetobaseUrl = config("constants.vetofx.baseurl")."/users/login";

     $this->vertofield=json_encode([
      'clientId' => $id,
      'apiKey' => $apikey,
      'mode' => $mode
     ]);

     $data=$this->vertofxLogin();

     return $data;
      
  }
   
	public function getFxRate($codea,$codeb,$token)
	{
		 $this->vetobaseUrl = config("constants.vetofx.baseurl")."/orders/v2.1/fx?currencyFrom=$codea&currencyTo=$codeb";

        $result = $this->getFxRateCurl($token);

        return $result;
	}


    // CURL Option...
    public function getFxRateCurl($token)
    {
       
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $this->vetobaseUrl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
	'Content-Type: application/json',
    'Authorization: Bearer ' . $token
  ),
));

$response = curl_exec($curl);

curl_close($curl);
 return json_decode($response);

}

  public function vertofxLogin()
  {
    $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api-v3-sandbox.vertofx.com/users/login',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$this->vertofield,
  CURLOPT_HTTPHEADER => array(
	'Content-Type: application/json',
    'Authorization: Bearer ' . config("constants.vetofx.token")
  ),
));

$response = curl_exec($curl);

curl_close($curl);
  return json_decode($response);
  }

}