<?php

namespace App\Http\Controllers;

use App\AllCountries;
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
    public function shuftiProPaymentVerification(String $userId, String $currencyCode)
    {
        try {

            $deductCurrencies = ["USD", "EUR", "GBP"];

            $thisuser = User::where('ref_code', $userId)->first();

            if($thisuser->shuftiproservice == 1){
                return true;
            }

            if(in_array($currencyCode, $deductCurrencies) && $thisuser->shuftiproservice == 0){
                return false;
            }

        } catch (\Throwable $th) {
            throw $th;
        }
    }


    // Get Available Countries

    public function shuftiAvailableCountries(String $country)
    {
        try {
            $data = AllCountries::where('name', $country)->first();

            if($data->verification_tool === 'ShuftiPro'){
                return true;
            }

            return false;

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
