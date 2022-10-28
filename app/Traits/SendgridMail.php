<?php

namespace App\Traits;

use SendGrid;
use SendGrid\Mail\Mail;



trait SendgridMail
{

    public $mailInstance;
    public $sendgridConfig;
    public $sendgridUrl;
    public $sendgridPost;

    public function __construct()
    {
        $this->mailInstance = new Mail();
        $this->sendgridConfig = new \SendGrid(config('constants.sendgrid.api_key'));
        $this->marketplaceConfig= new \SendGrid(config('constants.marketplace.api_key'));
    }


    public function sendGridSendMail($subject, $message, $receiver, $name)
    {
        try {

            $this->mailInstance->setFrom(
                config('constants.sendgrid.from'),
                config('constants.sendgrid.from_name')
            );
            $this->mailInstance->setSubject($subject);
            // Replace the email address and name with your recipient
            $this->mailInstance->addTo(
                $receiver,
                $name
            );

            $this->mailInstance->addContent(
                'text/html',
                $message
            );

            // $response = $this->sendgridConfig->send($this->mailInstance);


            // return $response;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function sendGridDynamicMail($receiver, $data, $template_id)
    {
        $this->sendgridUrl = config("constants.sendgrid.baseurl") . '/mail/send';

        $this->sendgridPost = json_encode([
            "from" => ["email" => config('constants.sendgrid.from'), "name" => config('constants.sendgrid.from_name')],
            "personalizations" => [
                [
                    "to" => [["email" => $receiver]],
                    "dynamic_template_data" => $data

                ]
            ],
            "template_id" => $template_id
        ]);




        $data = $this->sendGridPostCurl();

        return $data;
    }

     public function marketplaceDynamicMail($receiver, $data, $template_id)
    {
        $this->sendgridUrl = config("constants.marketplace.baseurl") . '/mail/send';

        $this->sendgridPosts = json_encode([
            "from" => ["email" => config('constants.marketplace.from'), "name" => config('constants.marketplace.from_name')],
            "personalizations" => [
                [
                    "to" => [["email" => $receiver]],
                    "dynamic_template_data" => $data

                ]
            ],
            "template_id" => $template_id
        ]);

        
       




        $data = $this->sendGridMarketPlace();


        

        return $data;
    }

    public function sendGridPostCurl()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->sendgridUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $this->sendgridPost,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . config('constants.sendgrid.api_key'),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }

     public function sendGridMarketPlace()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->sendgridUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $this->sendgridPosts,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . config('constants.marketplace.api_key'),
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        

        curl_close($curl);

        return json_decode($response);
    }
}