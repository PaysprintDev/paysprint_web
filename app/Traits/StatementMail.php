<?php 

namespace App\Traits;


trait StatementMail
{


  public function statement($email,$pointacquired,$name){

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.sendgrid.com/v3/mail/send",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => '{"personalizations":[{"to":[{"email":$email,"name":"Munirat"}],"subject":"Hello, World!"}],"content": [{"type": "text/plain", "value": "Hello Moto!"}],"from":{"email":"info@paysprint.ca","name":"PaySprint"}}',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer '.env('sendgrid_key')
    ),
    ));

    $response = curl_exec($curl);

    dd($response);

    curl_close($curl);
    return json_decode($response);

  }
}