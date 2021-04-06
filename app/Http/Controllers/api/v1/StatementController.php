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
                    $status = 200;

                }
                else{
                    $data = [];
                    $message = "No record";
                    $status = 400;

                }


                $resData = ['data' => $data, 'message' => $message, 'status' => $status];

            } catch (\Throwable $th) {

                $status = 400;

                $resData = ['data' => [], 'message' => 'Error: '.$th, 'status' => $status];
            }




        }
        else{
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
        }


        return $this->returnJSON($resData, $status);
    }


    public function getSpecificStatement(Request $req){

        $user = User::where('api_token', $req->bearerToken())->first();
        
        if (isset($user)) {
            
            $mystatement = Statement::where('user_id', $user->email)->where('activity', 'LIKE', '%'.$req->get('service').'%')->orderBy('created_at', 'DESC')->get();

            if(count($mystatement) > 0){
                $status = 200;
                $message = "success";

                $resData = ['data' => $mystatement, 'message' => $message, 'status' => $status];
            }
            else{
                $status = 400;

                $resData = ['data' => [], 'message' => 'No record', 'status' => $status];
            }
            
        }
        else{
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
        }

        return $this->returnJSON($resData, $status);

    }

    public function getSpecificStatementByDate(Request $req){

        $user = User::where('api_token', $req->bearerToken())->first();

        
        
        if (isset($user)) {

            $from = date('Y-m-d', strtotime($req->get('start')));
            $nextDay = date('Y-m-d', strtotime($req->get('end')));

            $mystatement = Statement::where('user_id', $user->email)->where('activity', 'LIKE', '%'.$req->get('service').'%')->whereBetween('trans_date', [$from, $nextDay])->orderBy('created_at', 'DESC')->get();

            if(count($mystatement) > 0){
                $status = 200;
                $message = "success";

                $resData = ['data' => $mystatement, 'message' => $message, 'status' => $status];
            }
            else{
                $status = 400;

                $resData = ['data' => [], 'message' => 'No record', 'status' => $status];
            }
            
        }
        else{
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
        }

        return $this->returnJSON($resData, $status);

    }


        public function getMyStatement(Request $req){

        $user = User::where('api_token', $req->bearerToken())->first();

        if(isset($user)){

            try {

                if($req->get('start') != null && $req->get('end') != null){

                    $from = date('Y-m-d', strtotime($req->get('start')));
                    $nextDay = date('Y-m-d', strtotime($req->get('end')));

                    $mystatement = Statement::where('user_id', $user->email)->whereBetween('trans_date', [$from, $nextDay])->orderBy('created_at', 'DESC')->get();

                }
                elseif($req->get('service')){
                    $mystatement = Statement::where('user_id', $user->email)->where('activity', 'LIKE', '%'.$req->get('service').'%')->orderBy('created_at', 'DESC')->get();
                }
                elseif($req->get('start') != null && $req->get('end') != null && $req->get('service')){

                    $from = date('Y-m-d', strtotime($req->get('start')));
                    $nextDay = date('Y-m-d', strtotime($req->get('end')));

                    $mystatement = Statement::where('user_id', $user->email)->where('activity', 'LIKE', '%'.$req->get('service').'%')->whereBetween('trans_date', [$from, $nextDay])->orderBy('created_at', 'DESC')->get();
                }

                

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

                $resData = ['data' => [], 'message' => 'Error: '.$th, 'status' => $status];
            }

        }
        else{
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
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

                $resData = ['data' => [], 'message' => 'Error: '.$th, 'status' => $status];
            }

        }
        else{
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }



    
}
