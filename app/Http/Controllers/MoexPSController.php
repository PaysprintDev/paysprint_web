<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MoexPSController extends Controller
{


    public function getExTransaction(Request $req)
    {

        try {

            $moex = new MoexController();

            $data = $moex->getExTransactionMoexPS($req->transactionId);

            if(isset($data['transaction'])){
                $status = 200;
                $resData = ['data' => $data['transaction'], 'message' => 'Success', 'status' => $status];
            }
            else{
                $data = $moex->MEGetTransactionMoEx($req->transactionId);

                if(isset($data['transaction'])){
                    $status = 200;
                    $resData = ['data' => $data['transaction'], 'message' => 'Success', 'status' => $status];
                }
                else{
                    $status = 400;
                    $resData = ['data' => [], 'message' => $data['error']->Description, 'status' => $status];
                }
            }


        } catch (\Throwable $th) {
            $status = 400;
            $resData = ['data' => [], 'message' => $th->getMessage(), 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }
}
