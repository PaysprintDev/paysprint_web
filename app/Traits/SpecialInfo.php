<?php

namespace App\Traits;

use App\AllCountries;
use Illuminate\Support\Facades\Hash;

use App\SpecialInformation as SpecialInformation;
use App\SupportActivity as SupportActivity;

use App\SuperAdmin as SuperAdmin;

trait SpecialInfo
{

    public function createInfo($query)
    {

        $data = SpecialInformation::updateOrCreate(['country' => $query['country']], $query);

        return $data;
    }

    public function deleteInfo($id)
    {

        $data = SpecialInformation::where('id', $id)->delete();

        return $data;
    }


    public function getInfo()
    {

        $data = SpecialInformation::orderBy('country', 'ASC')->get();

        return $data;
    }

    public function getthisInfo($country)
    {

        $data = SpecialInformation::where('country', $country)->first();

        return $data;
    }

    public function getselectedInfo($id)
    {

        $data = SpecialInformation::where('id', $id)->first();

        return $data;
    }


    // Create Support Agent
    public function userSupportAgent($query)
    {

        $password = Hash::make($query['firstname']);

        $query['password'] = $password;
        $query['username'] = $query['user_id'];

        $data = SuperAdmin::updateOrCreate(['email' => $query['email']], $query);

        return $data;
    }


    public function editcurrentSupportAgent($query)
    {

        $password = Hash::make($query['firstname']);

        $query['password'] = $password;
        $query['username'] = $query['user_id'];

        $data = SuperAdmin::updateOrCreate(['user_id' => $query['user_id']], $query);

        return $data;
    }

    public function getSupportAgent()
    {

        $data = SuperAdmin::where('user_id', '!=', 'PAYca_super')->orderBy('created_at', 'DESC')->get();

        return $data;
    }
    public function getthisuserinfo($id)
    {

        $data = SuperAdmin::where('id', $id)->first();

        return $data;
    }
    public function deletecurrentSupportAgent($id)
    {

        $data = SuperAdmin::where('id', $id)->delete();

        return $data;
    }

    // Insert activity
    public function createSupportActivity($query)
    {
        $data = SupportActivity::insert($query);
    }


    // Get country  currency symbol, currency code and calling code
    public function getCountryData($country)
    {
        $data = AllCountries::where('name', $country)->first();

        return $data;
    }
}
