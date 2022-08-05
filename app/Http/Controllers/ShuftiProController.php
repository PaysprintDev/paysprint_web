<?php

namespace App\Http\Controllers;

use App\Traits\ShuftiPro;
use App\ShuftiProRecord;
use App\User;

class ShuftiProController extends Controller
{
    use ShuftiPro;

    public function callAmlCheck(String $userId, String $dob, Array $name, String $email, String $country)
    {
        try {

            $reference = uniqid();

            $data = $this->amlBackgroundCheck($dob, $name, $reference, $email, $country);

            ShuftiProRecord::create([
                'userId' => $userId,
                'reference' => $data->reference,
                'event' => $data->event,
                'email' => $data->email,
                'country' => $data->country,
                'verification_data' => json_encode($data->verification_data),
                'verification_result' => json_encode($data->verification_result),
                'info' => json_encode($data->info),
            ]);

            return $data;

        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function callKycCheck(String $userId, String $dob, Array $name, String $email, String $country)
    {
        try {

            $reference = uniqid();
            $data = $this->kycCheck($dob, $name, $reference, $email, $country);


            ShuftiProRecord::create([
                'userId' => $userId,
                'reference' => $data->reference,
                'email' => $data->email,
                'country' => $data->country,
                'verification_data' => json_encode($data->verification_data),
                'verification_result' => json_encode($data->verification_result),
                'info' => json_encode($data->info),
            ]);

            return $data;

        } catch (\Throwable $th) {
            throw $th;
        }
    }


    // Check for Verification Payment..
    public function shuftiProPaymentVerification(String $userId)
    {
        try {

            $thisuser = User::where('ref_code', $userId)->first();

            if($thisuser->shuftiproservice == 1){
                return true;
            }
            return false;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
