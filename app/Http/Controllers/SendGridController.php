<?php

namespace App\Http\Controllers;

use App\User;
use App\ClientInfo;
use App\ReferralClaim;
use App\Points;

use App\Traits\SendgridMail;
use Illuminate\Http\Request;

class SendGridController extends Controller
{

    use SendgridMail;

    public function cronToCustomersOnVirtualAccount()
    {

        try {
            $thisuser = User::where('country', 'Nigeria')->where('virtual_account', '!=', NULL)->inRandomOrder()->take(200)->get();


        if (count($thisuser) > 0) {

            foreach ($thisuser as $user) {

                $username = explode(" ", $user->name);

                $receiver = $user->email;
                $data = [
                    "name"  => $username[0],
                    "message" => "<p>We are glad to inform you of your PaySprint <strong>VIRTUAL ACCOUNT NUMBER!</strong>. The Virtual Account provides you additional channel to Top-up PaySprint Wallet directly from your Bank Account without bank debit card.</p><p>Below is your account details: </p><hr/><p><strong>ACCOUNT NUMBER: {$user->virtual_account}</strong></p><p><strong>BANK NAME: WEMA BANK</strong></p><p><strong>ACCOUNT NAME: {$user->name}</strong></p><br><p>Simply add the details above to your bank account as Beneficiaries and you can Top up Wallet with ease.</p><br><p>Thanks for choosing PaySprint.</p>",
                ];

                $template_id = config('constants.sendgrid.virtual_account');

                $response = $this->sendGridDynamicMail($receiver, $data, $template_id);

                echo $response;
            }
        }
        } catch (\Throwable $th) {
            throw $th;
        }


     }
   
   
     //  refer and earn mail to customers
    public function cronToCustomersOnCustomerStatement()
    {
       
        try {

            $thisuser=User::take(2)->get();
    
        if (count($thisuser) > 0) {

            $setPointClaimed = 0;

            foreach ($thisuser as $user) {
                $username = explode(" ", $user->name);
                $referreduser = $user->referral_by;
                $referralpoint = $user->referral_points;

                $point= ReferralClaim::where('user_id', $user->id)->first();

                if(isset($point)){
                    $setPointClaimed = $point->points_claimed;
                }


                $point_acquired =$setPointClaimed;

                $referralbalance = $referralpoint - $point_acquired;
                // dd( $point_acquired);

                // $receiver = $user->email;
                $receiver = "olasunkanmimunirat@gmail.com";

                $data = [
                    "name"  => $username[0],
                    "message" => "<p><strong>Below is your monthly point statement:</strong></p><hr/><br>
                    <table>
                    <tr>
                      <td>Total Users Referred</td>
                      <td>$referreduser</td>
                    </tr>
                    <tr>
                      <td>Total Referral Points Earned</td>
                      <td> $referralpoint</td>
                    </tr>
                    <tr>
                      <td>Total Referral Points Redeemed</td>
                      <td>$point_acquired</td>
                    </tr>
                    <tr>
                      <td>Referral Points Balance</td>
                      <td>$referralbalance</td>
                     </tr>
                   
                  </table>",
                ];

                $template_id = config('constants.sendgrid.refer_earn');

                $response = $this->sendGridDynamicMail($receiver, $data, $template_id);
                        // dd($response);
                echo $response;
            }
        }
        } catch (\Throwable $th) {
            throw $th;
        }


    }
  
    
    // Reward points mail
    public function cronToCustomersOnRewardStatement()
    {
       
        try {

            $thisuser=User::get();
    
         if (count($thisuser) > 0) {

            foreach ($thisuser as $user) {
                $username = explode(" ", $user->name);
                $points=Points::where('user_id', $user->id)->first();
                $aquired_point = $points->points_acquired;
                $redeemed_point = $points->current_point;
                $credit_total=

                $total_point = $aquired_point + $redeemed_point;
              
              

                

                $receiver = $user->email;
               
                $date=date('d/M/Y', strtotime($user->created_at));

                $data = [
                    "name"  => $username[0],
                    "message" => "<p><strong>Here is the Summary of Your Reward Points for the month:</strong></p><br>
                       <p>Date Joined : $date  </p><hr/><br>
                    <table>
                    <tr>
                      <td>Total Points Accumulated - </td>
                      <td> $aquired_point</td>
                    </tr>
                    <tr>
                      <td>Total Points Redeemed - </td>
                      <td>$redeemed_point</td>
                    </tr>
                    <tr>
                      <td>Total Points Balance - </td>
                      <td>$total_point</td>
                    </tr>
                    <br>
                     <tr>
                       <td>Total Reward Credit</td>
                       <td>$redeemed_point</td>
                      </tr>
                   
                   
                  </table>",
                ];

                $template_id = config('constants.sendgrid.customer_statement');

                $response = $this->sendGridDynamicMail($receiver, $data, $template_id);
                        // dd($response);
                echo $response;
            }
        }
        } catch (\Throwable $th) {
            throw $th;
        }


    }


    // publicize merchant to customer mail

    public function cronToPublicizeMerchantToConsumer(){
        try {
         $getClient = ClientInfo::where('description', '!=', NULL)->get();
         $name = $getClient->business_name;
         $address = $getClient->address;
         $telephone = $getClient->telephone;
         $email = $getClient->email;
         $description = $getClient->description;
         $industry = $getClient->industry;

         if(count($getClient) > 0){

            foreach($getClient as $merchants){
                // Get Users in the country...

                $getUsers = User::where('country', $merchants->country)->get();
                
                for($i = 0; $i < count($getUsers); $i++){
                    // echo $getUsers[$i]->name.' | '.$getUsers[$i]->country.' | '.$getUsers[$i]->email."<hr>";

                            // $receiver = $user->email;
                        $receiver = "olasunkanmimunirat@gmail.com";

                        $data = [
                            "name"  => "$name",
                            "address" => "$address",
                            "telephone" => "$telephone",
                            "email" => "$email",
                            "description" => "$description",
                            "industry" => "$industry",
                        ];

                        $template_id = config('constants.sendgrid.publicize_merchant');

                        $response = $this->sendGridDynamicMail($receiver, $data, $template_id);
                                // dd($response);
                        echo $response;

                }



            }

        }
            
        } catch (\Throwable $th) {
            //throw $th;
        }
    }




}