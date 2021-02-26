<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use Illuminate\Support\Facades\DB;

use App\User as User;
use App\Statement as Statement;

class NotificationController extends Controller
{
    public function getNotifications(Request $req){

        $user = User::where('api_token', $req->bearerToken())->first();

        if(isset($user)){

           $data = Statement::where('user_id', $user->email)->orderBy('notify', 'ASC')->orderBy('created_at', 'DESC')->get();

           if(count($data) > 0){
               
                $status = 200;
        
                $resData = ['data' => $data, 'message' => 'success', 'status' => $status];
           }
           else{
                $status = 404;
        
                $resData = ['message' => 'No new notification', 'status' => $status];
           }

        }
        else{
            $status = 400;

            $resData = ['message' => 'Token mismatch', 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }
}
