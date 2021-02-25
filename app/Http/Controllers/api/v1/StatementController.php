<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

use App\User as User;

use App\Statement as Statement;

use App\ImportExcel as ImportExcel;

class StatementController extends Controller
{
    public function getAllStatement(Request $req){

        $user = User::where('api_token', $req->bearerToken())->first();

        if(isset($user)){
            // Get Statement
            try {
                $mystatement = Statement::where('user_id', $user->email)->orderBy('created_at', 'DESC')->get();

                if(count($mystatement) > 0){
                    $data = $mystatement;
                    $message = "success";
                }
                else{
                    $data = [];
                    $message = "No record";
                }

                $status = 200;

                $resData = ['data' => $data, 'message' => $message, 'status' => $status];

            } catch (\Throwable $th) {

                $status = 400;

                $resData = ['message' => 'Error: '.$th, 'status' => $status];
            }




        }
        else{
            $status = 400;

            $resData = ['message' => 'Token mismatch', 'status' => $status];
        }


        return $this->returnJSON($resData, $status);
    }


    public function getStatementByDate(Request $req){

        $user = User::where('api_token', $req->bearerToken())->first();

        if(isset($user)){

            try {

                $from = date('Y-m-d', strtotime($req->get('start')));
                $nextDay = date('Y-m-d', strtotime($req->get('end')));

                $mystatement = Statement::where('user_id', $user->email)->whereBetween('trans_date', [$from, $nextDay])->orderBy('created_at', 'DESC')->get();

                if(count($mystatement) > 0){
                    $data = $mystatement;
                    $message = "success";
                }
                else{
                    $data = [];
                    $message = "No record";
                }

                $status = 200;

                $resData = ['data' => $data, 'message' => $message, 'status' => $status];


                
            } catch (\Throwable $th) {
                $status = 400;

                $resData = ['message' => 'Error: '.$th, 'status' => $status];
            }

        }
        else{
            $status = 400;

            $resData = ['message' => 'Token mismatch', 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }



    
}
