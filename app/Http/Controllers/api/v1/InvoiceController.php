<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\User as User;
use App\ImportExcel as ImportExcel;

class InvoiceController extends Controller
{
    

    public function getAllInvoices(Request $req){

        $user = User::where('api_token', $req->bearerToken())->first();

        if(isset($user)){

           $data = ImportExcel::where('payee_email', $user->email)->orderBy('created_at', 'DESC')->get();

           if(count($data) > 0){
                $status = 200;
        
                $resData = ['data' => $data, 'message' => 'success', 'status' => $status];
           }
           else{
                $status = 400;
        
                $resData = ['data' => [], 'message' => 'No record found', 'status' => $status];
           }

        }
        else{
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
        }

    return $this->returnJSON($resData, $status);

    }


    public function getSpecificInvoices(Request $req){

        $user = User::where('api_token', $req->bearerToken())->first();

        if(isset($user)){

           $data = ImportExcel::where('payee_email', $user->email)->where('invoice_no', $req->get('invoice'))->where('service', 'LIKE', '%'.$req->get('service').'%')->orderBy('created_at', 'DESC')->get();

           if(count($data) > 0){
            $status = 200;
    
            $resData = ['data' => $data, 'message' => 'success', 'status' => $status];
       }
       else{

        // Check the invoice

        $data = ImportExcel::where('payee_email', $user->email)->where('invoice_no', $req->get('invoice'))->orderBy('created_at', 'DESC')->get();

        if(count($data) > 0){
            $status = 200;
    
            $resData = ['data' => $data, 'message' => 'success', 'status' => $status];
       }
       else{
        $status = 400;
    
            $resData = ['data' => [], 'message' => 'No record found', 'status' => $status];
       }

            
       }

        }
        else{
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }




    public function getInvoiceByService(Request $req){

        $user = User::where('api_token', $req->bearerToken())->first();

        if(isset($user)){

           $data = ImportExcel::where('payee_email', $user->email)->where('service', 'LIKE', '%'.$req->get('service').'%')->orderBy('created_at', 'DESC')->get();

           if(count($data) > 0){
            $status = 200;
    
            $resData = ['data' => $data, 'message' => 'success', 'status' => $status];
       }
       else{
            $status = 400;
    
            $resData = ['data' => [], 'message' => 'No record found', 'status' => $status];
       }

        }
        else{
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
        }

        return $this->returnJSON($resData, $status);

    }

}
