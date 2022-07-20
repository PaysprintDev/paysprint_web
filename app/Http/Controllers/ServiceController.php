<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;

use App\User;
use App\ServiceMainStore;
use App\ServiceStoreTestimony;
use App\AllCountries;
use App\Mail\sendEmail;
use App\Traits\ServiceStoreShop;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    use ServiceStoreShop;

    public $to;
    public $name;
    public $email;
    public $subject;
    public $message;

    public function __construct()
    {
        $this->location = $this->myLocation();


        return $this->location;
    }

    public function index($shop, $id)
    {

        $timezone = explode("/", $this->location->timezone);



        $thisuser = User::where('ref_code', $id)->first();

        $getCurrencyCode = $this->getPaymentGateway($this->location->country);

        $data = array(
            'pages' => $shop . ' Shop',
            'currencyCode' => $this->getCountryCode($thisuser->country),
            'continent' => $timezone[0],
            'name' => $thisuser->businessname,
            'refCode' => $thisuser->ref_code,
            'mycurrencyCode' => $this->getCountryCode($getCurrencyCode->name),
        );

        return view('main.service.index')->with(['data' => $data]);
    }


    // Show Service Page
    public function merchantPlatformService($id)
    {
        $data = [];
        return view('merchant.pages.service.index')->with(['data' => $data]);
    }


    public function merchantPlatformPricing($id)
    {
        $data = [];
        return view('merchant.pages.service.services')->with(['data' => $data]);
    }


    public function getPaymentGateway($country)
    {

        $data = AllCountries::where('name', $country)->first();

        return $data;
    }




    // API methods for Shop setup
    public function setupService(Request $req)
    {
        try {


            $query = $req->all();

            $thisuser = User::where('id', $req->merchantId)->first();


            if ($req->value == 'header') {
                // If has file...
                if ($req->hasFile('businessLogo')) {

                    $routing = $thisuser->businessname . "/myservice";

                    $businessLogo = $this->uploadItems($req->file('businessLogo'), $routing . "/logo", 50, 50);
                } else {
                    $businessLogo = 'https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_2_w4hzub_ioffkg.jpg';
                }



                if ($req->backdropImage === "pattern1") {
                    $backdropImage = asset('backdrop/blue.webp');
                }
                if ($req->backdropImage === "pattern2") {
                    $backdropImage = asset('backdrop/pattern2.jpg');
                }
                if ($req->backdropImage === "pattern3") {
                    $backdropImage = asset('backdrop/pattern3.jpg');
                }

                $query = [
                    "backdropImage" => $backdropImage,
                    "businessWelcome" => $req->businessWelcome,
                    "businessWhatWeAre" => $req->businessWhatWeAre,
                    "businessSlogan" => $req->businessSlogan,
                    "youtubeLink" => $req->youtubeLink,
                    "website" => $req->website,
                    "merchantId" => $req->merchantId,
                    "businessLogo" => $businessLogo
                ];
            }

            if ($req->value == 'about') {

                if ($req->hasFile('aboutImportantImage')) {

                    $routing = $thisuser->businessname . "/myservice";

                    $aboutImportantImage = $this->uploadItems($req->file('aboutImportantImage'), $routing . "/aboutus", 520, 319);
                } else {
                    $aboutImportantImage = 'https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_2_w4hzub_ioffkg.jpg';
                }

                $query = [
                    "aboutUs" => $req->aboutUs,
                    "value" => $req->value,
                    "aboutUsQ1" => $req->aboutUsQ1,
                    "aboutUsA1" => $req->aboutUsA1,
                    "aboutUsQ2" => $req->aboutUsQ2,
                    "aboutUsA2" => $req->aboutUsA2,
                    "aboutUsQ3" => $req->aboutUsQ3,
                    "aboutUsA3" => $req->aboutUsA3,
                    "merchantId" => $req->merchantId,
                    "aboutImportantImage" => $aboutImportantImage
                ];

            }



            if ($req->value == 'testimonial') {


                if ($req->hasFile('testimonialImage')) {

                    $routing = $thisuser->businessname . "/myservice";

                    $testimonialImage = $this->uploadItems($req->file('testimonialImage'), $routing . "/testimony", 90, 90);
                } else {
                    $testimonialImage = 'https://res.cloudinary.com/paysprint/image/upload/v1651130089/assets/paysprint_jpeg_black_bk_2_w4hzub_ioffkg.jpg';
                }


                $query = [
                    "testimonialName" => $req->testimonialName,
                    "value" => $req->value,
                    "testimonialRating" => $req->testimonialRating,
                    "testimonialDescription" => $req->testimonialDescription,
                    "merchantId" => $req->merchantId,
                    "testimonialImage" => $testimonialImage
                ];

                ServiceStoreTestimony::updateOrInsert(['testimonialName' => $req->testimonialName], $query);
                $data = true;
                $status = 200;
                $message = "Section created successfully";

                $resData = ['data' => $data, 'message' => $message, 'status' => $status];

                return $this->returnJSON($resData, $status);
            }



            ServiceMainStore::updateOrInsert(['merchantId' => $req->merchantId], $query);


            $data = true;
            $status = 200;
            $message = "Section created successfully";
        } catch (\Throwable $th) {

            $data = false;
            $status = 400;
            $message = $th->getMessage();
        }


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }
}
