<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use App\User as User;

use App\Building as Building;

class BuildingController extends Controller
{
    // Facility Information

    public function createFacility(Request $req, Building $building){

        $fileToStore = "";
        if($req->file('building_image') && count($req->file('building_image')) > 0)
        {
            $i = 0;
            foreach($req->file('building_image') as $key => $value){
                //Get filename with extension
                $filenameWithExt = $value->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt , PATHINFO_FILENAME);
                // Get just extension
                $extension = $value->getClientOriginalExtension();

                // Filename to store
                $fileNameToStore = rand().'_'.time().'.'.$extension;

                $fileToStore .=  $fileNameToStore.",";
                //Upload Image
                // $path = $value->storeAs('public/facility', $fileNameToStore);

                // $path = $value->move(public_path('/facility/'), $fileNameToStore);

                $path = $value->move(public_path('../../facility/'), $fileNameToStore);
            }


        }

        $building->owner_name = $req->owner_name;
        $building->owner_phone = $req->owner_phone;
        $building->owner_street_number = $req->owner_street_number;
        $building->owner_street_name = $req->owner_street_name;
        $building->owner_city = $req->owner_city;
        $building->owner_zipcode = $req->owner_zipcode;
        $building->owner_state = $req->owner_state;
        $building->owner_country = $req->owner_country;
        $building->owner_email = $req->owner_email;
        $building->agent_name = $req->agent_name;
        $building->agent_phone = $req->agent_phone;
        $building->agent_street_number = $req->agent_street_number;
        $building->agent_street_name = $req->agent_street_name;
        $building->agent_city = $req->agent_city;
        $building->agent_zipcode = $req->agent_zipcode;
        $building->agent_state = $req->agent_state;
        $building->agent_country = $req->agent_country;
        $building->agent_email = $req->agent_email;
        $building->buildinglocation_street_number = $req->buildinglocation_street_number;
        $building->buildinglocation_street_name = $req->buildinglocation_street_name;
        $building->buildinglocation_city = $req->buildinglocation_city;
        $building->buildinglocation_zipcode = $req->buildinglocation_zipcode;
        $building->buildinglocation_state = $req->buildinglocation_state;
        $building->buildinglocation_country = $req->buildinglocation_country;
        $building->buildinginformation_name = $req->buildinginformation_name;
        $building->buildinginformation_phone = $req->buildinginformation_phone;
        $building->building_type = $req->building_type;
        $building->building_image = $fileToStore;

        $info = $building->save();

        if($info == true){
            $resData = "Created successfully";
            $resp = "success";
        }
        else{
            $resData = "Something went wrong!";
            $resp = "error";
        }



        return redirect()->back()->with($resp, $resData);
    }

}
