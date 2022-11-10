<?php

namespace App\Http\Controllers;

use App\User;
use App\Points;
use App\StoreProducts;
use App\PromoDate;
use App\ClientInfo;
use App\Walletcredit;
use App\ClaimedPoints;
use App\ReferralClaim;

use App\UnverifiedMerchant;

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




    // publicize merchant to customer mail

    public function cronToPublicizeMerchantToConsumer()
    {


        try {


            $category_images = [
                "Accounting" =>  asset('images/industry_images/accounting.jpg'),
                "Airlines/Aviation" => asset('images/industry_images/aviation.jpg'),
                "Animation" => asset('images/industry_images/animation.png'),
                "Apparel/Fashion" => asset('images/industry_images/fashion.png'),
                "Arts/Crafts" => asset('images/industry_images/art.jpg'),
                "Automotive" => asset('images/industry_images/automotive.jpg'),
                "Banking/Mortgage" => asset('images/industry_images/banking.jpg'),
                "Biotechnology/Greentech" => asset('images/industry_images/automotive.jpg'),
                "Building Materials" => asset('images/industry_images/building.jpg'),
                "Business Supplies/Equipment" => asset('images/industry_images/business.png'),
                "Investment Management/Hedge Fund/Private Equity" => asset('images/industry_images/capital-hedge.jpg'),
                "Chemicals" => asset('images/industry_images/chemicals.jpg'),
                "Civic/Social Organization" => asset('images/industry_images/civic.png'),
                "Commercial Real Estate" => asset('images/industry_images/real-estate.jpg'),
                "Computer Games" => asset('images/industry_images/games.png'),
                "Computer Hardware" => asset('images/industry_images/hardware.png'),
                "Computer Networking" => asset('images/industry_images/networking.jpg'),
                "Computer Software/Engineering" => asset('images/industry_images/software.jpg'),
                "Construction" => asset('images/industry_images/construction.jpg'),
                "Consumer Electronics" => asset('images/industry_images/electronics.png'),
                "Consumer Goods" => asset('images/industry_images/goods.jpg'),
                "Consumer Services" => asset('images/industry_images/services.png'),
                "Dairy" => asset('images/industry_images/dairy.jpg'),
                "Design" => asset('images/industry_images/design.png'),
                "E-Learning" => asset('images/industry_images/e-learning.jpg'),
                "Education Management" => asset('images/industry_images/education-management.png'),
                "Electrical/Electronic Manufacturing" => asset('images/industry_images/electronics.png'),
                "Entertainment/Movie Production" => asset('images/industry_images/movie.jpg'),
                "Environmental Services" => asset('images/industry_images/environmental.jpg'),
                "Events Services" => asset('images/industry_images/events.png'),
                "Executive Offices" => asset('images/industry_images/offices.png'),
                "Farming" => asset('images/industry_images/farming.jpg'),
                "Financial Services" => asset('images/industry_images/financial-services.png'),
                "Food Production" => asset('images/industry_images/food.jpg'),
                "Food/Beverages" => asset('images/industry_images/beverages.png'),
                "Furniture" => asset('images/industry_images/furniture.jpg'),
                "Gambling/Casinos" => asset('images/industry_images/casino.png'),
                "Graphic Design/Web Design" => asset('images/industry_images/web-design.png'),
                "Hospital/Health Care" => asset('images/industry_images/hospital.jpg'),
                "Import/Export" => asset('images/industry_images/import.jpg'),
                "Information Services" => asset('images/industry_images/information-services.jpg'),
                "Information Technology/IT" => asset('images/industry_images/information-technology.png'),
                "Insurance" => asset('images/industry_images/insurance.jpg'),
                "Leisure/Travel" => asset('images/industry_images/travel.jpg'),
                "Logistics/Procurement" => asset('images/industry_images/procurement.jpg'),
                "Management Consulting" => asset('images/industry_images/consulting.jpg'),
                "Maritime" => asset('images/industry_images/maritime.jpg'),
                "Marketing/Advertising/Sales" => asset('images/industry_images/advertising.png'),
                "Mechanical or Industrial Engineering" => asset('images/industry_images/mechanical.jpg'),
                "Media Production" => asset('images/industry_images/media.png'),
                "Medical Practice" => asset('images/industry_images/medical.png'),
                "Military Industry" => asset('images/industry_images/military.jpg'),
                "Music" => asset('images/industry_images/music.png'),
                "Other Industry" => asset('images/industry_images/other-industry.jpg'),
                "Photography" => asset('images/industry_images/photography.png'),
                "Plastics" => asset('images/industry_images/plastic.png'),
                "Public Relation/PR" => asset('images/industry_images/pr.webp'),
                "Real Estate/Mortgage" => asset('images/industry_images/mortgage.jpg'),
                "Religious Institution" => asset('images/industry_images/religious.png'),
                "Restaurants" => asset('images/industry_images/resturant.jpg'),
                "Retail Industry" => asset('images/industry_images/retail.png'),
                "Sports" => asset('images/industry_images/sport.png'),
                "Telecommunication" => asset('images/industry_images/telecom.png'),
                "Transportation" => asset('images/industry_images/transportation.jpg'),
                "Wholesale" => asset('images/industry_images/wholesale.png'),
                "Wireless" => asset('images/industry_images/wireless.png'),
                "Writing/Editing" => asset('images/industry_images/writing.jpg'),
            ];


            $user = [];
            $getClient = ClientInfo::where('description', '!=', NULL)->groupBy('country')->get();


            if (count($getClient) > 0) {
                $businesses = ['businesses' => []];
                foreach ($getClient as $merchants) {
                    // Get Users in the country...

                    $user_id = $merchants->user_id;
                    $name = $merchants->business_name;
                    $address = $merchants->address;
                    $country = $merchants->country;
                    $state = $merchants->state; {


                        // $logo = $merchants->logo;

                        if ($merchants->logo != null) {
                            $logo = $merchants->logo;
                        } else {

                            if (isset($category_images[$merchants->industry])) {
                                $logo = $category_images[$merchants->industry];
                            } else {
                                $logo = $category_images["Wireless"];
                            }
                        }

                        $description = $merchants->description;
                        $industry = $merchants->industry;

                        // $getUsers = User::where('country', $merchants->country)->first();

                        // $username = explode(" ", $getUsers->name);
                        // "username" => $username[0],

                        $data = [
                            "user_id" => $user_id,
                            "name"  => $name,
                            "address" => $address,
                            "state" => $state . ',' . $country,
                            "country" => $country,
                            "logo" => $logo,
                            "description" => str_limit($description, 150),
                            "industry" => $industry,
                            "url" =>  route('merchant business profile', $user_id),

                        ];


                        $businesses['businesses'][] = $data;
                        // dd($businesses['businesses']);

                        // $user[] = ['name' => $getUsers->name, 'email' => $getUsers->email];


                        $this->userList($businesses, $merchants->country);
                    }


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


            $thisuser = UnverifiedMerchant::inRandomOrder()->take(100)->get();

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


    //   publicize product list to consumers
    public function productList(){
       try{
        
        $products = StoreProducts::inRandomOrder()->take(3)->get();
        
       
        if (count($products) > 0) {
            $businesses = ['businesses' => []];
           
            foreach ($products as $product) {
                // Get each product...
                $images = $product->image;
                $details = strip_tags($product->description);
              
                $productName= $product->productName;
                $industry = $product->category;
                $user_id = $product->merchantId;
              

                $data = [
                        
                        "productName"  => $productName,
                        "sales" => $this->salesProduct(),
                        "images" => $images,
                        "industry" => $industry,
                        "details" => $details,
                        "url" =>  route('merchant business profile', $user_id),
                

                ];
            
                  
                
                $businesses['businesses'][] = $data;
       
                    
                }

              
                
            }
            // $businesses['sales']= $this->salesProduct();
            
                
              
          
            $this->userList($businesses);
            

        }catch(\Throwable $th) {
        throw $th;
       }
    }
    public function userList(array $businesses)
    {
        $user = User::take(1)->get();
        // dd($user);


        for ($i = 0; $i < count($user); $i++) {
        
            // $receiver = $user[$i]['email'];
           
              $receiver = 'olasunkanmimunirat@gmail.com';
            
            // $businesses['name'] = $user[$i]['name'];
            // dd($businesses);

            $template_id = config('constants.sendgrid.productlist');

             $response = $this->sendGridDynamicMail($receiver, $businesses, $template_id);
            // dd($response);

        }
    }

    public function salesProduct()
    {
        $sales = StoreProducts::whereRaw('previousAmount > amount')->get();
        // dd($sales);
        foreach ($sales as $product) {
            // Get each product...
            $images = $product->image;
            $details = strip_tags($product->description);
          
            $productName= $product->productName;
            $industry = $product->category;
            $user_id = $product->merchantId;
            $data = [
                        
                "productName"  => $productName,
                "images" => $images,
                "industry" => $industry,
                "details" => $details,
                "url" =>  route('merchant business profile', $user_id),

        ];

        return $data;
        }
    }
}
