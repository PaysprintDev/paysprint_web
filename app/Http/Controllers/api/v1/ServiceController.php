<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
