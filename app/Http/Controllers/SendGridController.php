<?php

namespace App\Http\Controllers;

use App\User;
use App\ClientInfo;
use App\ReferralClaim;
use App\Points;
use App\PromoDate;
use App\Walletcredit;

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
                    "message" => "<p>We are glad to inform you of your PaySprint <strong>BANK ACCOUNT NUMBER!</strong>. The PaySprint Bank Account provides you with additional channel to Top-up PaySprint Wallet directly from your existing Bank Account without a debit or credit card.</p><p>Below is your PaySprint Bank Account details: </p><hr/><p><strong>ACCOUNT NUMBER: {$user->virtual_account}</strong></p><p><strong>BANK NAME: WEMA BANK</strong></p><p><strong>ACCOUNT NAME: {$user->name}</strong></p><br><p>Simply add the details above as Beneficiary to your existing bank account and start to Top up your PaySprint Wallet with ease.</p><br><p>Thanks for choosing PaySprint.</p>",
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
             $promodate=PromoDate::first();
            //  dd($promodate);
            
              $startdate = $promodate->start_date;
              $enddate = $promodate->end_date;
    
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
                    "message" => "<p><strong>Here is the Summary of Your Refer and Earn Points for the month:</strong></p><br>
                    <table>
                    <tr>
                      <td>Total Users Referred</td>
                      <td>$referreduser</td>
                    </tr>
                    <tr>
                      <td>Total Referral Points Earned-</td>
                      <td> $referralpoint</td>
                    </tr>
                    <tr>
                      <td>Total Referral Points Redeemed-</td>
                      <td>$point_acquired</td>
                    </tr>
                    <tr>
                      <td>Referral Points Balance-</td>
                      <td>$referralbalance</td>
                     </tr>
                   
                    </table><hr/><br>",
                    "promotion" => "<p><strong>PaySprint Special Promo: </strong></p><br>
                    <table>
                    <tr>
                        <td>Promo Start Date:</td>
                        <td> $startdate</td>
                        
                    </tr>
                    <tr>
                        <td>Promo End Date:</td>
                        <td> $enddate</td>
                    </tr>
                  
                    
                    </table>"
            
                ];

                $template_id = config('constants.sendgrid.refer_earn');

                $response = $this->sendGridDynamicMail($receiver, $data, $template_id);
                        dd($response);
                // echo $response;
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
            
            $setCreditClaimed = 0;
            $setPointAquired = 0;
            $setCurrentBalance=0;

            foreach ($thisuser as $user) {
                $username = explode(" ", $user->name);
                $points=Points::where('user_id', $user->id)->first();
                if(isset($points)){
                    $setPointAquired = $points->points_acquired;
                    $setCurrentBalance = $points->current_point;
                     
                }
                $aquired_point = $setPointAquired;
              
                $redeemed_point = $setCurrentBalance;
                $total_point = $aquired_point + $redeemed_point;
               
                $credit_total=Walletcredit::where('user_id', $user->id)->first();
                if(isset($credit_total)){
                    $setCreditClaimed = $credit_total->wallet_credit;
                }
                $credit_balance = $setCreditClaimed;

               
               $receiver = $user->email;
           
               
               
                $date=date('d/M/Y', strtotime($user->created_at));

                $data = [
                    "name"  => $username[0],
                    "message" => "<p><strong>Here is the Summary of Your Reward Points for the month:</strong></p><br>
                       <p>Date Joined : $date  </p><hr/><br>
                    <table>
                    <tr>
                      <td>Total Reward Points Earned - </td>
                      <td> $aquired_point</td>
                    </tr>
                    <tr>
                      <td>Total Reward Points Redeemed - </td>
                      <td>$redeemed_point</td>
                    </tr>
                    <tr>
                      <td>Total Reward Points Balance - </td>
                      <td>$total_point</td>
                    </tr>
                    <br>
                     <tr>
                       <td>Total Wallet Credit Received</td>
                       <td>$credit_balance</td>
                      </tr>
                   
                   
                  </table>",
                ];

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


    // publicize merchant to customer mail

    public function cronToPublicizeMerchantToConsumer(){

       
        try {
         
         $user = [];   
         $getClient = ClientInfo::where('description', '!=', NULL)->take(5)->get();
         
        
         if(count($getClient) > 0){
          $businesses = ['businesses'=>[]];
            foreach($getClient as $merchants){
                // Get Users in the country...
              
                $user_id=$merchants->user_id;
                $name = $merchants->business_name;
                $address = $merchants->address;
                $state=$merchants->state;{

               
                // $logo = $merchants->logo;
                $category_images = [
                 "Accounting" => env('APP_ENV') == 'production' ?  asset('images/industry_images/accounting.jpg') : 'https://paysprint.ca/images/industry_images/accounting.jpg',
                 "Airline/Aviation" => env('APP_ENV') == 'production' ? asset('images/industry_images/aviation.jpg'): 'https://paysprint.ca/images/industry_images/aviation.jpg',
                 "Animation" => env('APP_ENV') == 'production' ? asset('images/industry_images/animation.png') : 'https://paysprint.ca/images/industry_images/insurance.jpg',
                 "Apparel/Fashion" => env('APP_ENV') == 'production' ? asset('images/industry_images/fashion.png') : 'https://paysprint.ca/images/industry_images/fashion.png',
                 "Arts/Crafts" => env('APP_ENV') == 'production' ? asset('images/industry_images/art.jpg') : 'https://paysprint.ca/images/industry_images/fashion.png',
                 "Automotive" => env('APP_ENV') == 'production' ? asset('images/industry_images/automotive.jpg') : 'https://paysprint.ca/images/industry_images/automotive.jpg',
                 "Banking/Mortgage" => env('APP_ENV') == 'production' ? asset('images/industry_images/banking.jpg') : 'https://paysprint.ca/images/industry_images/banking.jpg',
                 "Biotechnology/Greentech" => env('APP_ENV') == 'production' ? asset('images/industry_images/automotive.jpg') : 'https://paysprint.ca/images/industry_images/automotive.jpg',
                 "Building Materials" => env('APP_ENV') == 'production' ? asset('images/industry_images/building.jpg') : 'https://paysprint.ca/images/industry_images/building.jpg',
                 "Business Supplies/Equipment" => env('APP_ENV') == 'production' ? asset('images/industry_images/business.png') : 'https://paysprint.ca/images/industry_images/business.png',
                 "Investment Management/Hedge Fund/Private Equity" =>env('APP_ENV') == 'production' ? asset('images/industry_images/capital-hedge.jpg') : 'https://paysprint.ca/images/industry_images/capital-hedge.jpg',
                 "Chemicals" =>env('APP_ENV') == 'production' ? asset('images/industry_images/chemicals.jpg') : 'https://paysprint.ca/images/industry_images/business.png',
                 "Civic/Social Organization" =>env('APP_ENV') == 'production' ? asset('images/industry_images/civic.png') : 'https://paysprint.ca/images/industry_images/civic.png',
                 "Commercial Real Estate" => env('APP_ENV') == 'production' ? asset('images/industry_images/real-estate.jpg') : 'https://paysprint.ca/images/industry_images/real-estate.jpg',
                 "Computer Games" => env('APP_ENV') == 'production' ? asset('images/industry_images/games.png') : 'https://paysprint.ca/images/industry_images/games.png',
                 "Computer Hardware" => env('APP_ENV') == 'production' ? asset('images/industry_images/hardware.png') : 'https://paysprint.ca/images/industry_images/hardware.png',
                 "Computer Networking" =>env('APP_ENV') == 'production' ? asset('images/industry_images/networking.jpg') : 'https://paysprint.ca/images/industry_images/networking.jpg',
                 "Computer Software/Engineering" => env('APP_ENV') == 'production' ? asset('images/industry_images/software.jpg') : 'https://paysprint.ca/images/industry_images/software.jpg',
                 "Construction" => env('APP_ENV') == 'production' ? asset('images/industry_images/construction.jpg') : 'https://paysprint.ca/images/industry_images/construction.jpg',
                 "Consumer Electronics" =>env('APP_ENV') == 'production' ? asset('images/industry_images/electronics.png') : 'https://paysprint.ca/images/industry_images/electronics.png',
                 "Consumer Goods" => env('APP_ENV') == 'production' ? asset('images/industry_images/goods.jpg') : 'https://paysprint.ca/images/industry_images/goods.jpg',
                 "Consumer Services" =>env('APP_ENV') == 'production' ? asset('images/industry_images/services.png') : 'https://paysprint.ca/images/industry_images/services.png',
                 "Dairy" => env('APP_ENV') == 'production' ? asset('images/industry_images/dairy.jpg') : 'https://paysprint.ca/images/industry_images/dairy.jpg',
                 "Design" =>env('APP_ENV') == 'production' ? asset('images/industry_images/design.png') : 'https://paysprint.ca/images/industry_images/design.png',
                 "E-Learning" => env('APP_ENV') == 'production' ? asset('images/industry_images/e-learning.jpg') : 'https://paysprint.ca/images/industry_images/e-learning.jpg',
                 "Education Management" => env('APP_ENV') == 'production' ? asset('images/industry_images/education-management.png') : 'https://paysprint.ca/images/industry_images/education-management.png',
                 "Electrical/Electronic Manufacturing" => env('APP_ENV') == 'production' ? asset('images/industry_images/electronics.png') : 'https://paysprint.ca/images/industry_images/electronics.png',
                 "Entertainment/Movie Production" =>env('APP_ENV') == 'production' ? asset('images/industry_images/movie.jpg') : 'https://paysprint.ca/images/industry_images/movie.jpg',
                 "Environmental Services" => env('APP_ENV') == 'production' ? asset('images/industry_images/environmental.jpg') : 'https://paysprint.ca/images/industry_images/environmental.jpg',
                 "Events Services" => env('APP_ENV') == 'production' ? asset('images/industry_images/events.png') : 'https://paysprint.ca/images/industry_images/events.png',
                 "Executive Offices" =>env('APP_ENV') == 'production' ? asset('images/industry_images/offices.png') : 'https://paysprint.ca/images/industry_images/offices.png',
                 "Farming" => env('APP_ENV') == 'production' ? asset('images/industry_images/farming.jpg') : 'https://paysprint.ca/images/industry_images/farming.jpg',
                 "Financial Services" => env('APP_ENV') == 'production' ? asset('images/industry_images/financial-services.png') : 'https://paysprint.ca/images/industry_images/financial-services.png',
                 "Food Production" => env('APP_ENV') == 'production' ? asset('images/industry_images/food.jpg') : 'https://paysprint.ca/images/industry_images/food.jpg',
                 "Food/Beverages" => env('APP_ENV') == 'production' ? asset('images/industry_images/beverages.png') : 'https://paysprint.ca/images/industry_images/beverages.png',
                 "Furniture" => env('APP_ENV') == 'production' ? asset('images/industry_images/furniture.jpg') : 'https://paysprint.ca/images/industry_images/furniture.jpg',
                 "Gambling/Casinos" => env('APP_ENV') == 'production' ? asset('images/industry_images/casino.png') : 'https://paysprint.ca/images/industry_images/casino.png',
                 "Graphic Design/Web Design" => env('APP_ENV') == 'production' ? asset('images/industry_images/web-design.png') : 'https://paysprint.ca/images/industry_images/web-design.png',
                 "Hospital/Health Care" => env('APP_ENV') == 'production' ? asset('images/industry_images/hospital.jpg') : 'https://paysprint.ca/images/industry_images/hospital.jpg',
                 "Import/Export" =>env('APP_ENV') == 'production' ? asset('images/industry_images/import.jpg') : 'https://paysprint.ca/images/industry_images/import.jpg',
                 "Information Services" => env('APP_ENV') == 'production' ? asset('images/industry_images/information-services.jpg') : 'https://paysprint.ca/images/industry_images/information-services.jpg',
                 "Information Technology/IT" => env('APP_ENV') == 'production' ? asset('images/industry_images/information-technology.png') : 'https://paysprint.ca/images/industry_images/information-technology.png',
                 "Insurance" => env('APP_ENV') == 'production' ? asset('images/industry_images/insurance.jpg') : 'https://paysprint.ca/images/industry_images/insurance.jpg',
                 "Leisure/Travel" => env('APP_ENV') == 'production' ? asset('images/industry_images/travel.jpg') : 'https://paysprint.ca/images/industry_images/travel.jpg',
                 "Logistics/Procurement" => env('APP_ENV') == 'production' ? asset('images/industry_images/procurement.jpg') : 'https://paysprint.ca/images/industry_images/procurement.jpg.',
                 "Management Consulting" => env('APP_ENV') == 'production' ? asset('images/industry_images/consulting.jpg') : 'https://paysprint.ca/images/industry_images/consulting.jpg',
                 "Maritime" => env('APP_ENV') == 'production' ? asset('images/industry_images/maritime.jpg') : 'https://paysprint.ca/images/industry_images/maritime.jpg',
                 "Marketing/Advertising/Sales" => env('APP_ENV') == 'production' ? asset('images/industry_images/advertising.png') : 'https://paysprint.ca/images/industry_images/advertising.png',
                 "Mechanical or Industrial Engineering" =>env('APP_ENV') == 'production' ? asset('images/industry_images/mechanical.jpg') : 'https://paysprint.ca/images/industry_images/mechanical.jpg',
                 "Media Production" => env('APP_ENV') == 'production' ? asset('images/industry_images/media.png') : 'https://paysprint.ca/images/industry_images/media.png',
                 "Medical Practice" => env('APP_ENV') == 'production' ? asset('images/industry_images/medical.png') : 'https://paysprint.ca/images/industry_images/medical.png',
                 "Military Industry" => env('APP_ENV') == 'production' ? asset('images/industry_images/military.jpg') : 'https://paysprint.ca/images/industry_images/military.jpg',
                 "Music" => env('APP_ENV') == 'production' ? asset('images/industry_images/music.png') : 'https://paysprint.ca/images/industry_images/music.png',
                 "Other Industry" => env('APP_ENV') == 'production' ? asset('images/industry_images/other-industry.jpg') : 'https://paysprint.ca/images/industry_images/other-industry.jpg',
                 "Photography" => env('APP_ENV') == 'production' ? asset('images/industry_images/photography.png') : 'https://paysprint.ca/images/industry_images/photography.png',
                 "Plastics" => env('APP_ENV') == 'production' ? asset('images/industry_images/plastic.png') : 'https://paysprint.ca/images/industry_images/plastic.png',
                 "Public Relation/PR" => env('APP_ENV') == 'production' ? asset('images/industry_images/pr.webp') : 'https://paysprint.ca/images/industry_images/pr.webp',
                 "Real Estate/Mortgage" =>env('APP_ENV') == 'production' ? asset('images/industry_images/mortgage.jpg') : 'https://paysprint.ca/images/industry_images/mortgage.jpg',
                 "Religious Institution" => env('APP_ENV') == 'production' ? asset('images/industry_images/religious.png') : 'https://paysprint.ca/images/industry_images/mortgage.jpg',
                 "Restaurants" => env('APP_ENV') == 'production' ? asset('images/industry_images/resturant.jpg') : 'https://paysprint.ca/images/industry_images/resturant.jpg',
                 "Retail Industry" => env('APP_ENV') == 'production' ? asset('images/industry_images/retail.png') : 'https://paysprint.ca/images/industry_images/retail.png',
                 "Sports" => env('APP_ENV') == 'production' ? asset('images/industry_images/sport.png') : 'https://paysprint.ca/images/industry_images/sport.png',
                 "Telecommunication" => env('APP_ENV') == 'production' ? asset('images/industry_images/telecom.png') : 'https://paysprint.ca/images/industry_images/telecom.png',
                 "Transportation" => env('APP_ENV') == 'production' ? asset('images/industry_images/transportation.jpg') : 'https://paysprint.ca/images/industry_images/transportation.jpg',
                 "Wholesale" =>env('APP_ENV') == 'production' ? asset('images/industry_images/wholesale.png') : 'https://paysprint.ca/images/industry_images/wholesale.png',
                 "Wireless" => env('APP_ENV') == 'production' ? asset('images/industry_images/wireless.png') : 'https://paysprint.ca/images/industry_images/wireless.png',
                 "Writing/Editing" =>env('APP_ENV') == 'production' ? asset('images/industry_images/writing.jpg') : 'https://paysprint.ca/images/industry_images/writing.jpg',
                ];


                if($merchants->logo != null){
                    $logo=$merchants->logo;
                }else{
                    $logo=$category_images[$merchants->industry];
                }
                
                $description = $merchants->description;
                $industry = $merchants->industry;

                $getUsers = User::where('country', $merchants->country)->first();
                
                // $username = explode(" ", $getUsers->name);
                // "username" => $username[0],
                
                $data = [
                    "user_id" => $user_id,
                    "name"  => $name,
                    "address" => $address,
                    "state" => $state,
                    "logo" =>$logo,
                    "description" => $description,
                    "industry" => $industry,
                    "url" =>  route('merchant business profile', $user_id),
                
                ];
              
                $businesses['businesses'][]=$data;
                // dd($businesses['businesses']);

                $user []= ['name' => $getUsers->name, 'email' => $getUsers->email];
               
            }

            for ($i=0; $i < count($user); $i++) { 


                // $receiver = $user[$i]['email'];
                  $receiver = "olasunkanmimunirat@gmail.com";

                $businesses['name'] = $user[$i]['name'];



                    $template_id = config('constants.sendgrid.publicize_merchant');

                    $response = $this->sendGridDynamicMail($receiver, $businesses, $template_id);
                
            }

            
                            //  dd($response);
             echo $response;
        }
            
 }
 } catch (\Throwable $th) {
            throw $th;
        }
    


  



}

}