<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\AllCountries;
use App\User;
use App\StoreProducts;
use App\StoreOrders;
use App\StoreDiscount;
use App\StoreMainShop;

class ShopController extends Controller
{

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


        // dd($data);


        return view('main.shop.index')->with(['data' => $data]);
    }



    public function storeProduct(Request $req){

        try {
            // Validate
        $validator = Validator::make($req->all(), [
            'productName' => 'required',
            'amount' => 'required',
            'previousAmount' => 'required',
            'stock' => 'required',
            'file' => 'required',
            'description' => 'required'
        ]);

        if ($validator->passes()) {


            $routing = Auth::user()->businessname."/myproduct";

            $docPath = $this->uploadImageFile($req->file('file'), $routing);



            $query = [
                'merchantId' => Auth::id(),
                'productName' => $req->productName,
                'amount' => $req->amount,
                'previousAmount' => $req->previousAmount,
                'stock' => $req->stock,
                'image' => $docPath,
                'description' => $req->description,
            ];

            // Insert record
            StoreProducts::insert($query);

            $status = 'success';
            $message = "Successfully stored";


        } else {

            $status = 'error';
            $message = implode(",", $validator->messages()->all());
        }
        } catch (\Throwable $th) {
            $status = 'error';
            $message = $th->getMessage();
        }


        return redirect()->back()->with($status, $message);

    }


    public function storeDiscount(Request $req){

        try {
            // Validate
        $validator = Validator::make($req->all(), [
            'code' => 'required',
            'valueType' => 'required',
            'amount' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
        ]);

        if ($validator->passes()) {



            $query = [
                'userId' => Auth::id(),
                'code' => $req->code,
                'valueType' => $req->valueType,
                'discountAmount' => $req->amount,
                'productId' => $req->productId,
                'startDate' => $req->startDate,
                'endDate' => $req->endDate,
            ];

            // Insert record
            StoreDiscount::insert($query);

            $status = 'success';
            $message = "Discount created";


        } else {

            $status = 'error';
            $message = implode(",", $validator->messages()->all());
        }
        } catch (\Throwable $th) {
            $status = 'error';
            $message = $th->getMessage();
        }


        return redirect()->back()->with($status, $message);

    }


    public function updateProduct(Request $req, $id){

        try {
            // Validate
        $validator = Validator::make($req->all(), [
            'productName' => 'required',
            'amount' => 'required',
            'previousAmount' => 'required',
            'stock' => 'required',
            'description' => 'required'
        ]);

        if ($validator->passes()) {

            // Get Product...

            $getProduct = StoreProducts::where('id', $id)->first();


            if($req->hasFile('file')){

            $routing = Auth::user()->businessname."/myproduct";

            $docPath = $this->uploadImageFile($req->file('file'), $routing);


            }
            else{

                $docPath = $getProduct->image;
            }


                        $query = [
                'merchantId' => Auth::id(),
                'productName' => $req->productName,
                'amount' => $req->amount,
                'previousAmount' => $req->previousAmount,
                'stock' => $req->stock,
                'image' => $docPath,
                'description' => $req->description,
            ];

            // Insert record



            StoreProducts::where('id', $id)->update($query);


 

            $status = 'success';
            $message = "Successfully updated";


        } else {

            $status = 'error';
            $message = implode(",", $validator->messages()->all());
        }
        } catch (\Throwable $th) {
            $status = 'error';
            $message = $th->getMessage();
        }


        return redirect()->back()->with($status, $message);

    }



    public function updateDiscount(Request $req, $id){

        try {
            // Validate
         $validator = Validator::make($req->all(), [
            'code' => 'required',
            'valueType' => 'required',
            'amount' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
        ]);

        if ($validator->passes()) {


            $query = [
                'userId' => Auth::id(),
                'code' => $req->code,
                'valueType' => $req->valueType,
                'discountAmount' => $req->amount,
                'productId' => $req->productId,
                'startDate' => $req->startDate,
                'endDate' => $req->endDate,
            ];



            StoreDiscount::where('id', $id)->update($query);


            $status = 'success';
            $message = "Discount successfully updated";


        } else {

            $status = 'error';
            $message = implode(",", $validator->messages()->all());
        }
        } catch (\Throwable $th) {
            $status = 'error';
            $message = $th->getMessage();
        }


        return redirect()->back()->with($status, $message);

    }


    public function deleteProduct($id){
        try {

            StoreProducts::where('id', $id)->delete();

            $status = 'success';
            $message = "Successfully deleted";
            
        } catch (\Throwable $th) {
            $status = 'error';
            $message = $th->getMessage();
        }


        return redirect()->back()->with($status, $message);
    }


    public function deleteDiscount($id){
        try {

            StoreDiscount::where('id', $id)->delete();

            $status = 'success';
            $message = "Discount successfully deleted";
            
        } catch (\Throwable $th) {
            $status = 'error';
            $message = $th->getMessage();
        }


        return redirect()->back()->with($status, $message);
    }


    public function setupEstore(Request $req){

        try {

               // Validate
         $validator = Validator::make($req->all(), [
            'headerTitle' => 'required',
            'headerSubtitle' => 'required',
            'headerContent' => 'required',
            'businessLogo' => 'required',
        ]);


        if ($validator->passes()) {

            $routing = Auth::user()->businessname."/estore";

            $headContentImage = "";
            $advertSectionImage = "";

            $businessLogo = $this->uploadImageFile($req->file('businessLogo'), $routing."/logo");

            if(count($req->file('headerContent')) > 1){

                foreach ($req->file('headerContent') as $headerContentFile) {

                    $headContentImage .= $this->uploadImageFile($headerContentFile, $routing."/headsection").", ";
                }

            }
            else{
                $headContentImage = $this->uploadImageFile($req->file('headerContent'), $routing."/headsection");
            }


            if($req->hasFile('advertSectionImage') && count($req->file('advertSectionImage')) > 0){

                if(count($req->file('advertSectionImage')) > 1){

                    foreach ($req->file('advertSectionImage') as $advertSectionFile) {

                        $advertSectionImage .= $this->uploadImageFile($advertSectionFile, $routing."/advertsection").", ";
                    }

                }
                else{
                    $advertSectionImage = $this->uploadImageFile($req->file('advertSectionImage'), $routing."/advertsection");
                }

            }



            

            $query = [
                'merchantId' => Auth::id(),
                'businessLogo' => $businessLogo,
                'headerContent' => $headContentImage,
                'headerTitle' => $req->headerTitle,
                'headerSubtitle' => $req->headerSubtitle,
                'advertSectionImage' => $advertSectionImage,
                'advertTitle' => $req->advertTitle,
                'advertSubtitle' => $req->advertSubtitle
            ];



            StoreMainShop::updateOrInsert(['merchantId' => Auth::id()], $query);


            // if(isset($req->savePreview)){

            //     $status = 'success';
            //     $message = "Store created successfully";

            
            // }


            // if(isset($req->justSave)){
                // $status = 'success';
            // $message = "Store created successfully";
            // }


            $status = 'success';
            $message = "Store created successfully";

        }
        else{

            $status = 'error';
            $message = implode(",", $validator->messages()->all());
        }

        } catch (\Throwable $th) {
            $status = 'error';
            $message = $th->getMessage();
        }

        return redirect()->back()->with($status, $message);

    }


    public function uploadImageFile($file, $fileroute){
                 //Get filename with extension
            $filenameWithExt = $file->getClientOriginalName();
                // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just extension
            $extension = $file->getClientOriginalExtension();
                // Filename to store
            $fileNameToStore = rand() . '_' . time() . '.' . $extension;


            $file->move(public_path('../../shopstore/'.$fileroute.'/'), $fileNameToStore);


            $docPath = route('home'). "/shopstore/".$fileroute."/" . $fileNameToStore;

            return $docPath;
    }

    public function getPaymentGateway($country)
    {

        $data = AllCountries::where('name', $country)->first();

        return $data;
    }



}