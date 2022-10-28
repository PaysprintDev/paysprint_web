<?php

namespace App\Http\Controllers;

use App\User;
use App\ClaimedPoints;

use App\TransactionCost;
use Illuminate\Http\Request;

class CreditController extends Controller
{
     // update wallet credit
     public function updateWalletCredit(){
      
        $updateamounts = ClaimedPoints::where('amount',NULL)->where('status','completed')->get();
   

        foreach ($updateamounts as $updateamount){

            $id=$updateamount->id;
            $user= User::where('id',$id)->first();
            $usertype = $user->accountType;
            
            $consumer = TransactionCost::where('country', $user->country)->where('structure', 'Consumer Monthly Subscription')->first();
         
            $merchant = TransactionCost::where('country', $user->country)->where('structure', 'Merchant Monthly Subscription')->first(); 
            $consumerfee = $consumer->fixed;
            $country = $consumer->country;
            $merchantfee = $merchant->fixed;
            
            if ($usertype == 'Individual' && $country == $user->country) {
                $pointclaim = $consumerfee / 2;
               
                ClaimedPoints::where('id', $id)->update([
                  'amount' => $pointclaim,
                ]);
            }
            if ($usertype == 'Merchant' && $country == $user->country) {
                $merchantfee = $merchantfee / 2;
               
                ClaimedPoints::where('id', $id)->update([
                  'amount' => $merchantfee,
                ]);
            }

        }
      

    }


   
}
