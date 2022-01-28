<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\IDVCheck;

class IdvController extends Controller
{

    use IDVCheck;

    public function checkIdvPassInfo(Request $req)
    {

        try {
            $checkInfo = $this->updateAccessInformation($req->val, $req->id, $req->checkProp);

            $data = $checkInfo;
            $status = 200;
            $message = "success";
        } catch (\Throwable $th) {

            $data = [];
            $status = 400;
            $message = $th->getMessage();
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];


        return $this->returnJSON($resData, $status);
    }
}