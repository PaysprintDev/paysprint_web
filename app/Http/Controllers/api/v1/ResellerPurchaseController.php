<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\VTPassController;
use Illuminate\Http\Request;

class ResellerPurchaseController extends Controller
{
    public function resellerService()
    {
        try {
            $vtpassController = $this->controllerCall();

            $data = $vtpassController->getServices();

            $status = 200;

            $resData = ['data' => $data, 'message' => 'Success', 'status' => $status];

        } catch (\Throwable $th) {
            $status = 400;

            $resData = ['data' => [], 'message' => $th->getMessage(), 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }


    public function resellerServiceId(Request $req)
    {
        try {
            $vtpassController = $this->controllerCall();

            $data = $vtpassController->getServiceId($req->identifier);

            $status = 200;

            $resData = ['data' => $data, 'message' => 'Success', 'status' => $status];

        } catch (\Throwable $th) {
            $status = 400;

            $resData = ['data' => [], 'message' => $th->getMessage(), 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }


    public function resellerVariationCodes(Request $req)
    {
        try {
            $vtpassController = $this->controllerCall();

            $data = $vtpassController->getVariationCodes($req->serviceId);

            $status = 200;

            $resData = ['data' => $data, 'message' => 'Success', 'status' => $status];

        } catch (\Throwable $th) {
            $status = 400;

            $resData = ['data' => [], 'message' => $th->getMessage(), 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }


    public function resellerProductOption(Request $req)
    {
        try {
            $vtpassController = $this->controllerCall();

            $data = $vtpassController->getProductOption($req->serviceId, $req->name);

            $status = 200;

            $resData = ['data' => $data, 'message' => 'Success', 'status' => $status];

        } catch (\Throwable $th) {
            $status = 400;

            $resData = ['data' => [], 'message' => $th->getMessage(), 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }


    public function resellerPurchase(Request $req)
    {
        try {
            $vtpassController = $this->controllerCall();


            $data = $vtpassController->purchaseProduct($req->all());

            $status = 200;

            $resData = ['data' => $data, 'message' => 'Success', 'status' => $status];

        } catch (\Throwable $th) {
            $status = 400;

            $resData = ['data' => [], 'message' => $th->getMessage(), 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }



    private function controllerCall()
    {
        $data = new VTPassController();

        return $data;
    }
}
