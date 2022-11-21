<?php

namespace App\Http\Controllers;

use App\User;
use App\Points;
use App\StoreProducts;
use App\PromoDate;
use App\ClientInfo;
use App\Walletcredit;
use App\ClaimedPoints;
use App\StoreMainShop;
use App\ReferralClaim;

use App\UnverifiedMerchant;

use App\VerifiedMerchant;

use App\TransactionCost;
use App\FlutterwaveModel;
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


                    // Get Bank Name...
                    $bankaccount = FlutterwaveModel::where('userId', $user->ref_code)->first();

                    $data = [
                        "name"  => $username[0],
                        "message" => "<p>We are glad to inform you of your PaySprint <strong>BANK ACCOUNT NUMBER!</strong>. The PaySprint Bank Account provides you with additional channel to Top-up PaySprint Wallet directly from your existing Bank Account without a debit or credit card.</p><p>Below is your PaySprint Bank Account details: </p><hr/><p><strong>ACCOUNT NUMBER: {$user->virtual_account}</strong></p><p><strong>BANK NAME: {$bankaccount->bank_name}</strong></p><p><strong>ACCOUNT NAME: {$user->name}</strong></p><br><p>Simply add the details above as Beneficiary to your existing bank account and start to Top up your PaySprint Wallet with ease.</p><br><p>Thanks for choosing PaySprint.</p>",
                    ];

                    $template_id = config('constants.sendgrid.virtual_account');

                    $response = $this->sendGridDynamicMail($receiver, $data, $template_id);

                    // echo $response;
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }




    //  refer and earn mail to customers
    public function cromerStatementonToCustomersOnCust()
    {

        try {

            $thisuser = User::take(50)->get();
            $promodate = PromoDate::first();

            if (count($thisuser) > 0) {

                $setPointClaimed = 0;


                foreach ($thisuser as $user) {

                    $totalreferred  = User::where('referred_by', $user->ref_code)->count('referred_by');

                    $username = explode(" ", $user->name);
                    $referreduser = $totalreferred;
                    $referralpoint = $user->referral_points;
                    $currency = $user->currencyCode;
                    $usertype = $user->accountType;
                    $usercountry = $user->country;
                    $consumer = TransactionCost::where('country', $usercountry)->where('structure', 'Consumer Monthly Subscription')->first();
                    $merchant = TransactionCost::where('country', $usercountry)->where('structure', 'Merchant Monthly Subscription')->first();
                    $country = $consumer->country;
                    $merchantcountry = $merchant->country;
                    $consumerfee = $consumer->fixed;
                    $merchantfee = $merchant->fixed;

                    $point = ReferralClaim::where('user_id', $user->id)->first();

                    if (isset($point)) {
                        $setPointClaimed = $point->points_claimed;
                        $credit = $point->amount;
                    }
                    $promopoint = $promodate->amount;



                    $referralbalance = $referralpoint -  $setPointClaimed;
                    // dd( $point_acquired);

                    // $receiver = $user->email;
                    $receiver = "olasunkanmimunirat@gmail.com";

                    if ($usertype == 'Individual' && $country == $usercountry) {
                        $pointsclaim = $consumerfee / 2;
                        $data = [
                            "name"  => $username[0],
                            "message" => "<p><strong>Here is the Summary of Your Refer and Earn Points:</strong></p><br>
                    <table>
                    <tr style:'text-align:left'>
                      <td>Total Users Referred-</td>
                      <td>$referreduser</td>
                    </tr>
                    <tr style:'text-align:left'>
                    <td>Total Referral Points Earned-</td>
                      <td>$referralpoint</td>
                    </tr>
                    <tr style:'text-align:left'>
                      <td>Total Referral Points Redeemed-</td>
                      <td>$setPointClaimed</td>
                    </tr>
                    <tr style:'text-align:left'>
                      <td>Referral Points Balance-</td>
                      <td>$referralbalance</td>
                     </tr>
                     <tr style:'text-align:left'>
                     <td>Referral Credit-</td>
                     <td>$credit$currency</td>
                    </tr>
                     <tr style:'text-align:left'>
                     <td>Promo Point-</td>
                     <td>$promopoint</td>
                    </tr>
                     <br>

                     <p>Redeem Your Referral Points when you have 500 points and above for a wallet of $pointsclaim$currency.</p>
                    </table><hr/>",

                        ];

                        if ($promodate) {

                            $startdate = $promodate->start_date;
                            $enddate = $promodate->end_date;
                            $promodetails = $promodate->promo_details;


                            $data["promotion"] = "
                    <img style='text-align:center;' src='https://paysprint.ca/images/paysprint_logo/specialpromologo.png' alt='promo' width='150' height='100'>
                    <p><strong>PaySprint Refer+Earn Special Promo: </strong></p>
                    <p>$promodetails</p>
                    <table>
                    <tr style:'text-align:left'>
                        <td>Start Date:</td>
                        <td> $startdate</td>

                    </tr>
                    <tr style:'text-align:left'>
                        <td>End Date:</td>
                        <td> $enddate</td>
                    </tr>


                    </table>
                  ";
                        }
                    }

                    if ($usertype == 'Merchant' && $merchantcountry == $usercountry) {
                        $referralclaim = $merchantfee / 2;
                        $data = [
                            "name"  => $username[0],
                            "message" => "<p><strong>Here is the Summary of Your Refer and Earn Points:</strong></p><br>
                    <table>
                    <tr style:'text-align:left'>
                      <td>Total Users Referred-</td>
                      <td>$referreduser</td>
                    </tr>
                    <tr style:'text-align:left'>
                    <td>Total Referral Points Earned-</td>
                      <td> $referralpoint</td>
                    </tr>
                    <tr style:'text-align:left'>
                      <td>Total Referral Points Redeemed-</td>
                      <td>$setPointClaimed</td>
                    </tr>
                    <tr style:'text-align:left'>
                      <td>Referral Points Balance-</td>
                      <td>$referralbalance</td>
                     </tr>
                     <tr style:'text-align:left'>
                     <td>Promo Credit-</td>
                     <td>$credit$currency</td>
                    </tr>
                     <tr style:'text-align:left'>
                     <td>Promo Credit-</td>
                     <td>$promopoint</td>
                    </tr>
                     <br>

                     <p>Redeem Your Referral Points when you have  500 points and above for a wallet of $referralclaim$currency.</p>
                    </table><hr/>",

                        ];

                        if ($promodate) {

                            $startdate = $promodate->start_date;
                            $enddate = $promodate->end_date;
                            $promodetails = $promodate->promo_details;


                            $data["promotion"] = "
                    <img style='text-align:center;' src='https://paysprint.ca/images/paysprint_logo/specialpromologo.png' alt='promo' width='150' height='100' text-align ='center'>
                    <p><strong>PaySprint Refer+Earn Special Promo: </strong></p>
                    <p>$promodetails</p>
                    <table>
                    <tr style:'text-align:left'>
                        <td>Start Date:</td>
                        <td> $startdate</td>

                    </tr>
                    <tr style:'text-align:left'>
                        <td>End Date:</td>
                        <td> $enddate</td>
                    </tr>


                    </table>
                  ";
                        }
                    }


                    $template_id = config('constants.sendgrid.refer_earn');

                    $response = $this->sendGridDynamicMail($receiver, $data, $template_id);
                    // dd($response);
                    // echo $response;
                    echo 'done';
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


            $thisuser = User::inRandomOrder()->take(200)->get();


            if (count($thisuser) > 0) {
                $setPointAquired = 0;
                $setCurrentBalance = 0;

                foreach ($thisuser as $user) {

                    $username = explode(" ", $user->name);
                    $currency = $user->currencyCode;
                    $usertype = $user->accountType;
                    $usercountry = $user->country;
                    $consumer = TransactionCost::where('country', $usercountry)->where('structure', 'Consumer Monthly Subscription')->first();
                    $merchant = TransactionCost::where('country', $usercountry)->where('structure', 'Merchant Monthly Subscription')->first();
                    $country = $user->country;
                  
                    $merchantcountry = $user->country;
                    $consumerfee = isset($consumer->fixed) ? $consumer->fixed : 0.00;
                    $merchantfee = isset($merchant->fixed) ? $merchant->fixed : 0.00;
                    $rewardpoint = ClaimedPoints::where('user_id', $user->id)->where('status', 'completed')->sum('amount');


                    $points = Points::where('user_id', $user->id)->first();
                    if (isset($points)) {
                        $setPointAquired = $points->points_acquired;
                        $setCurrentBalance = $points->current_point;
                    }
                    $aquired_point = $setPointAquired;
                    $redeemed_point = $setCurrentBalance;
                    $total_point = $aquired_point + $redeemed_point;



                    $receiver = $user->email;
                  



                    $date = date('d/M/Y', strtotime($user->created_at));

                    if ($usertype == 'Individual' && $country == $usercountry) {
                        $pointsclaim = $consumerfee / 2;
                        $data = [
                            "name"  => $username[0],
                            "message" => "<p><strong>Here is the Summary of Your Reward Points for the month:</strong></p><br>
                           <p>Date Joined : $date  </p><hr/><br>
                        <table>
                        <tr style='text-align:left'>
                          <td>Total Reward Points Earned - </td>
                          <td> $total_point</td>
                        </tr>
                        <tr style='text-align:left'>
                          <td>Total Reward Points Redeemed - </td>
                          <td>$redeemed_point</td>
                        </tr>
                        <tr style='text-align:left'>
                          <td>Total Reward Points Balance - </td>
                          <td>$aquired_point</td>
                        </tr>
                        <tr style='text-align:left'>
                        <td>Reward Credit - </td>
                        <td>$currency$rewardpoint</td>
                      </tr>
                        <br>
                        <br>
                         <p><strong>Redeem Your Reward Points for $pointsclaim$currency Wallet Credit when you accumulate 5000.</strong></p>
                       </table>",
                        ];
                    }

                    if ($usertype == 'Merchant' && $merchantcountry == $usercountry) {
                        $referralclaim = $merchantfee / 2;
                        $data = [
                            "name"  => $username[0],
                            "message" => "<p><strong>Here is the Summary of Your Reward Points for the month:</strong></p><br>
                           <p>Date Joined : $date  </p><hr/><br>
                        <table>
                        <tr style='text-align:left'>
                          <td>Total Reward Points Earned - </td>
                          <td> $total_point</td>
                        </tr>
                        <tr style='text-align:left'>
                          <td>Total Reward Points Redeemed - </td>
                          <td>$redeemed_point</td>
                        </tr>
                        <tr style='text-align:left'>
                          <td>Total Reward Points Balance - </td>
                          <td>$aquired_point</td>
                        </tr>
                        <tr style='text-align:left'>
                        <td>Reward Credit - </td>
                        <td>$rewardpoint</td>
                      </tr>
                        <br>
                        <br>
                         <p><strong>Redeem Your Reward Points for $referralclaim$currency Wallet Credit when you accumulate 7000.</strong></p>
                        </table>",
                        ];
                    }



                    $template_id = config('constants.sendgrid.customer_statement');

                    $response = $this->sendGridDynamicMail($receiver, $data, $template_id);
                    // dd($response);
                    echo 'done';
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }




  

    

    //marketplace claim your business with cron
    public function claimBusiness()
    {
        try {


            $thisuser = VerifiedMerchant::get();

            // dd($thisuser);


            if (count($thisuser) > 0) {


                foreach ($thisuser as $user) {
                    $name = $user->name;
                    $receiver = $user->email;
                    $data = [
                        "name"  => $name,
                        "message" => "<p>PaySprint Market Place is one of the fastest growing global marketplaces. <br> At PaySprint Market Place, we connect merchant with customers and drive more traffic to their business at no extra costs. <br> To make sure your business is eligible to show up on PaySprint Marketplace,  </p>",
                        "url" => route('home') . '/claimmerchantbusiness?id=' . $user->id,
                    ];

                    $template_id = config('constants.marketplace.claimsbusiness');

                    $response = $this->marketplaceDynamicMail($receiver, $data, $template_id);

                  
                    echo 'done';
                }
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    //marketplace claim your business from marketplace website
    public function marketplaceClaim($email)
    {
        try {
            $user = UnverifiedMerchant::where('email', $email)->first();

            $name = $user->name;
            $receiver = $user->email;
            $data = [
                "name"  => $name,
                "message" => "<p>PaySprint Market Place is one of the fastest growing global marketplaces. <br> At PaySprint Market Place, we connect merchant with customers and drive more traffic to their business at no extra costs. <br> To make sure your business is eligible to show up on PaySprint Marketplace,  </p>",
                "url" => route('home') . '/claimmerchantbusiness?id=' . $user->id,
                "decline" => 'https://paysprintmarketplace.com',
                "remove" => route('home') . '/declineclaimbusiness?id=' . $user->id,
            ];

            $template_id = config('constants.sendgrid.claimbusiness');



            $response = $this->sendGridDynamicMail($receiver, $data, $template_id);
            // dd($response);
            // echo 'done';
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    //send username and password
    public function sendUsername($legalname, $email, $username, $password)
    {
        try {

            $name = $legalname;
            $receiver = $email;
            $data = [
                "name"  => $name,
                "message" => "<p>Congratulations!!! Welcome to  PaySprint Marketplace. <br><br> <span><strong>Here are your login details </strong><span><br><br><br> <span><strong>Username:<strong></span><span>$username</span> <br> <span><strong>Temporary Password:</strong></span> <span>$password</span>  </p>",
                "url" => route('home') . '/AdminLogin',
            ];

            $template_id = config('constants.sendgrid.merchantusername');

            $response = $this->sendGridDynamicMail($receiver, $data, $template_id);
            // dd($response);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    //request review
    public function requestReview($email, $id,$name)
    {
        try {
            $receiver = $email;
            $data = [
                "name" => "Hi there,",
                "message" => "<p>As a valued customer, we at $name,would appreciate your sincere opinion on our products/services so we can serve you better.</p>",
                "url" => route('home') . '/makereview?id=' . $id,
            ];

            $template_id = config('constants.sendgrid.requestreview');

            $response = $this->sendGridDynamicMail($receiver, $data, $template_id);

        } catch (\Throwable $th) {
            throw $th;
        }
    }


    // mail to  publicize product list to consumers
    public function productList(){
       try{
        
        $products = StoreProducts::inRandomOrder()->take(5)->get();
        
        // $merchant=User ::where('id',$products->merchantId)->first();
        // dd($merchant);
        if (count($products) > 0) {
            $businesses = ['businesses' => []];
           
            foreach ($products as $product) {
                $merchant=User::where('id',$product->merchantId)->first();
                // Get each product...
                $images = $product->image;
                $details = strip_tags($product->description);
              
                $productName= $product->productName;
                $industry = $product->category;
                $business = $product->businessname;
                
              

                $data = [
                        
                        "productName"  => $productName,
                      
                        "images" => $images,
                        "industry" => $industry,
                        "details" => $details,
                        "url" =>  'https://paysprint.ca/shop/'.$business,
                ];
                  
                
                $businesses['businesses'][] = $data;
       
                    
                }

                $this->userList($businesses);
                
            }
            

        }catch(\Throwable $th) {
        throw $th;
       }
    }
    public function userList(array $businesses)
    {
        $user = User::inRandomOrder()->take(50)->get();
        // dd($user);


        for ($i = 0; $i < count($user); $i++) {
        
            // $receiver = $user[$i]['email'];
           
              $receiver = 'olasunkanmimunirat@gmail.com';
            
            $businesses['name'] = $user[$i]['name'];
            // dd($businesses);

            $template_id = config('constants.sendgrid.productlist');

             $response = $this->sendGridDynamicMail($receiver, $businesses, $template_id);
            // dd($response);

        }
    }


   //Mail for product on sale
    public function rebateProduct()
    {
        try{
        
            $products = StoreProducts::whereRaw('previousAmount > amount')->get();
          
           
        //   dd($id);
            if (count($products) > 0) {
                $stocks = ['stocks' => []];
               
                foreach ($products as $product) {
                     $merchant=User::where('id',$product->merchantId)->first();
                   
                   
                    // Get each product...
                    $images = $product->image;
                    $details = strip_tags($product->description);
                    $old = $product->previousAmount;
                    $new = $product->amount;
                    $productName= $product->productName;
                    $industry = $product->category;
                    $business = $merchant->businessname;
                    $currency = $merchant->currrencyCode;
                    $data = [
                            "productName"  => $productName,
                            "images" => $images,
                            "industry" => $industry,
                            "details" => $details,
                            "old"=>$old,
                            "new"=>$new,
                            "currency"=>$currency,
                            "url" =>  'https://paysprint.ca/shop/'.$business,
    
                    ];
                    //  dd($data);
                    
                    $stocks['stocks'][] = $data;
                   }
                   $this->users($stocks);
                    
                }
                
    
            }catch(\Throwable $th) {
            throw $th;
           }
    }

    public function users(array $stocks)
    {
        $user = User::inRandomOrder()->take(1)->get();
        // dd($user);


        for ($i = 0; $i < count($user); $i++) {
        
            // $receiver = $user[$i]['email'];
           
              $receiver = 'olasunkanmimunirat@gmail.com';
            
            $businesses['name'] = $user[$i]['name'];
            // dd($businesses);

            $template_id = config('constants.sendgrid.sales');

             $response = $this->sendGridDynamicMail($receiver, $stocks, $template_id);
            // dd($response);

        }
    }
}
