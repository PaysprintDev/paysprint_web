<?php


namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\MonerisActivity as MonerisActivity;
use App\Statement as Statement;
use App\User as User;


trait FlagPayment{

    public function dothisflag($transaction_id){

        $data = MonerisActivity::where('transaction_id', $transaction_id)->first();

        if($data->flag_state ==  1){
            $flag = 0;
        }
        else{
            $flag = 1;
        }

        MonerisActivity::where('transaction_id', $transaction_id)->update(['flag_state' => $flag]);
        Statement::where('reference_code', $transaction_id)->update(['flag_state' => $flag]);

        $getUser = Statement::where('reference_code', $transaction_id)->first();

        User::where('email', $getUser->user_id)->update(['flagged' => 1]);

    }


    public function getAllFlaggedMoney(){

        $data = MonerisActivity::where('flag_state', 1)->orderBy('updated_at', 'DESC')->get();

        return $data;
    }

    
    

    

}