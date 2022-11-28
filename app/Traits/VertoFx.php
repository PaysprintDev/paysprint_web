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

  public function createFxTrade($token,$amount,$side,$reference)
  {
    $this->vetobaseUrl = config("constants.vetofx.baseurl")."/orders/v2.1/fx";

    $this->vertofield=json_encode([
      'vfx_token' => $token,
      'side' => $side,
      'amount' => $amount,
      'clientReference' => $reference
     ]);

     $data=$this->vertofxLogin();

     return $data;
  }

  public function createBeneficiary($token,$entitytype,$firstname,$lastname,$companyname,$currency,$countrycode,$accountno,$nationalid,$country,$reference)
  { 
    $this->vetobaseUrl = config("constants.vetofx.baseurl")."/profile/v2.1/beneficiaries";

    $this->vertofield=json_encode([
      'beneficiaryEntityType' => $entitytype,
      'beneficiaryFirstName' => $firstname,
      'beneficiaryLastName' => $lastname,
      'beneficiaryCompanyName' => $companyname,
      'currency' => $currency,
      'beneficiaryCountryCode' => $countrycode,
      'accountNumber' => $accountno,
      'nationalId' => $nationalid,
      'country' => $country,
      'clientReference' => $reference
     ]);

      $data=$this->beneficiaryCurl($token);

     return $data;
  }

  public function getBeneficiaryList()
  {
     $this->vetobaseUrl = config("constants.vetofx.baseurl")."/profile/v2.1/beneficiaries?customPageSize=10&page=1";
     $result = $this->listBeneficiaryCurl();
        return $result;
  }


    // CURL Option...
    public function getFxRateCurl()
    {
      
      $token = $this->FxLogin(
        config("constants.vetofx.clientid"),
        config("constants.vetofx.apikey"),
        "apiKey");
       
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
        'Authorization: Bearer ' . $token->token
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
  CURLOPT_URL => $this->vetobaseUrl,
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
  ),
));

$response = curl_exec($curl);

curl_close($curl);
  return json_decode($response);
  }


  public function beneficiaryCurl($token)
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
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$this->vertofield,
  CURLOPT_HTTPHEADER => array(
	'Content-Type: application/json',
    'Authorization: Bearer ' . $token
  ),
));

$response = curl_exec($curl);

curl_close($curl);
  return json_decode($response);
  }



  public function listBeneficiaryCurl()
  {
        $id=config("constants.vetofx.clientid");
        $apikey= config("constants.vetofx.apikey");
        $mode='apiKey';
 $token = $this->FxLogin($id,$apikey,$mode);

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
    'Authorization: Bearer'.$token->token
  ),
));

$response = curl_exec($curl);

curl_close($curl);
  return json_decode($response);
  }


}