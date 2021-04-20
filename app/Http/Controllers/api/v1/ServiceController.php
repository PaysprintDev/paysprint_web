<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\ServiceType as ServiceType;

class ServiceController extends Controller
{
    public function getServicetype(){

        $resp = ServiceType::all();

        if(count($resp) > 0){

            $data = $resp;
            $message = "Saved";
            $status = 200;

        }
        else{

            $data = [];
            $message = "No record";
            $status = 400;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }


    public function createServiceType(Request $req){
        $validator = Validator::make($req->all(), [
                'name' => 'required|string',
        ]);

        if($validator->passes()){

            ServiceType::updateOrCreate(['name' => $req->name],['name' => $req->name]);

            $data = ServiceType::orderBy('created_at', 'DESC')->get();

            $status = 200;
            $message = "Saved";


        }
        else{

            $error = implode(",",$validator->messages()->all());

            $data = [];
            $status = 400;
            $message = $error;

        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];


        return $this->returnJSON($resData, $status);
    }
}
