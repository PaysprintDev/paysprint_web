<?php

namespace App\Traits;

use App\AllCountries;
use App\ReferralGenerate;
use App\ReferredUsers;
use Illuminate\Support\Facades\Hash;

use App\SpecialInformation as SpecialInformation;
use App\SupportActivity as SupportActivity;
use App\ClientInfo as ClientInfo;

use App\SuperAdmin as SuperAdmin;
use App\User;

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


    public function getReferrerAgent()
    {

        $data = ReferralGenerate::where('is_admin', true)->orderBy('created_at', 'DESC')->get();

        return $data;
    }


    public function getthisuserinfo($id)
    {

        $data = SuperAdmin::where('id', $id)->first();

        return $data;
    }

    public function getthisreferrerinfo($id)
    {

        $data = ReferralGenerate::where('id', $id)->first();

        return $data;
    }
    public function deletecurrentSupportAgent($id)
    {

        $data = SuperAdmin::where('id', $id)->delete();

        return $data;
    }
    public function deletecurrentReferrerAgent($id)
    {

        $data = ReferralGenerate::where('id', $id)->delete();

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



    // Create Referrer
    public function userReferrerAgent($query)
    {
        $query['name'] = $query['firstname'] . ' ' . $query['lastname'];
        $query['is_admin'] = true;
        $query['ref_link'] = route('home') . '/register?ref_code=' . $query['ref_code'];


        $data = ReferralGenerate::updateOrCreate(['ref_code' => $query['ref_code']], ['name' => $query['name'], 'email' => $query['email'], 'telephone' => $query['telephone'], 'ref_link' => $query['ref_link'], 'country' => $query['country']]);

        return $data;
    }

    public function editcurrentReferrerAgent($query)
    {

        $query['is_admin'] = true;
        $query['ref_link'] = route('home') . '/register?ref_code=' . $query['ref_code'];

        $data = ReferralGenerate::updateOrCreate(['ref_code' => $query['ref_code']], ['name' => $query['name'], 'email' => $query['email'], 'telephone' => $query['telephone'], 'ref_link' => $query['ref_link'], 'country' => $query['country']]);

        return $data;
    }


    public function getListofReferred($ref_code)
    {
        $data = ReferredUsers::where('ref_code', $ref_code)->orderBy('created_at', 'desc')->paginate(20);

        return $data;
    }

    public function getBusinessProfileData($id)
    {
        $data = User::where('ref_code', $id)->first();

        return $data;
    }

    public function getThisMerchantBusiness($id)
    {
        $data = ClientInfo::where('user_id', $id)->first();

        return $data;
    }
}