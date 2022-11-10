<?php

namespace App\Http\Controllers;

use App\User;

use App\StoreCart;
use App\CashbackRecords;
use App\MerchantCashback;
use App\ClientInfo;
use App\ProductTax;
use App\StoreOrders;
use App\StorePickup;
use App\AllCountries;
use App\StoreCategory;
use App\StoreDelivery;
use App\StoreDiscount;
use App\StoreMainShop;
use App\StoreProducts;
use App\StoreShipping;
use App\StoreWishList;
use App\Mail\sendEmail;
use App\Traits\MyEstore;

use App\Traits\Xwireless;
use App\StoreBillingDetail;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{

    use MyEstore, Xwireless;


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
        $homeController = new HomeController();

        $timezone = explode("/", $this->location->timezone);


        $thisuser = User::where('ref_code', $id)->first();


        $getMerchant = ClientInfo::where('user_id', $thisuser->ref_code)->first();


        if ($getMerchant->accountMode === 'live') {


            $getCurrencyCode = $this->getPaymentGateway($this->location->country);

            $data = array(
                'pages' => $shop . ' Shop',
                'currencyCode' => env('APP_ENV') === 'local' ? $this->getCountryCode('Canada') : $this->getCountryCode($thisuser->country),
                'continent' => $timezone[0],
                'name' => $thisuser->businessname,
                'refCode' => $thisuser->ref_code,
                'mycurrencyCode' => $this->getCountryCode($getCurrencyCode->name),
                'paymentgateway' => $homeController->getPaymentGateway($this->location->country),
                'paymentorg' => $homeController->getthisOrganization($thisuser->ref_code),
                'merchantApiKey' => $getMerchant->api_secrete_key,
                'merchantMainApiKey' => $thisuser->api_token,
            );

            // dd($data);
            $views = env('APP_ENV') === 'local' ? 'main.shop.index2' : 'main.shop.index2';

            return view($views)->with(['data' => $data]);
        } else {
            return view('errors.paymentunavailable')->with(['pages' => $getMerchant->business_name]);
        }
    }



    public function verifyDelivery()
    {

        return view('main.verifydelivery');
    }


    public function storeProduct(Request $req)
    {

        try {
            // Validate
            $validator = Validator::make($req->all(), [
                'productName' => 'required',
                'amount' => 'required',
                'previousAmount' => 'required',
                'stock' => 'required',
                'file' => 'required',
                'description' => 'required',
                'category' => 'required',
                'deliveryDate' => 'required',
                'deliveryTime' => 'required'

            ]);

            if ($validator->passes()) {


                $routing = Auth::user()->businessname . "/myproduct";

                $docPath = $this->uploadImageFile($req->file('file'), $routing, 300, 300);


                $category = $req->category == 'Other' ? $req->specifyCategory : $req->category;


                if ($req->category == 'Other') {
                    StoreCategory::insert(['category' => $req->specifyCategory, 'state' => false]);
                }


                $query = [
                    'merchantId' => Auth::id(),
                    'productName' => $req->productName,
                    'productCode' => $req->productCode,
                    'amount' => $req->amount,
                    'previousAmount' => $req->previousAmount,
                    'stock' => $req->stock,
                    'image' => $docPath,
                    'description' => $req->description,
                    'category' => $category,
                    'deliveryDate' => $req->deliveryDate,
                    'deliveryTime' => $req->deliveryTime
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


    public function placeOrder(Request $req)
    {

        try {



            //Get Cart Items and delete from cart...
            $getCart = StoreCart::where('userId', $req->userId)->get();



            if ($req->shipping_check == "on") {
                $shippingName = $req->name;
                $shippingAddress = $req->address . ' ' . $req->city . ' ' . $req->state . ' ' . $req->country;
                $shippingEmail = $req->email;
                $shippingPhone = $req->phone;
            } else {
                $shippingName = $req->shippingName;
                $shippingAddress = $req->shippingAddress;
                $shippingEmail = $req->shippingEmail;
                $shippingPhone = $req->shippingPhone;
            }


            // Add shipping details...
            StoreBillingDetail::updateOrCreate(['userId' => $req->userId, 'merchantId' => $req->merchantId], [
                'userId' => $req->userId, 'merchantId' => $req->merchantId, 'fulllname' => $req->name, 'company_name' => $req->company, 'country' => $req->country, 'state' => $req->state, 'address' => $req->address, 'apartment' => $req->apartment, 'city' => $req->city, 'postalcode' => $req->postalCode, 'email' => $req->email, 'phone' => $req->phone, 'shippingName' => $shippingName, 'shippingAddress' => $shippingAddress, 'shippingEmail' => $shippingEmail, 'shippingPhone' => $shippingPhone
            ]);



            if (count($getCart) > 0) {



                $address = $req->address . ' ' . $req->city . ' ' . $req->state . ' ' . $req->country;

                foreach ($getCart as $cartItem) {
                    // Put items in orders...
                    StoreOrders::updateOrCreate(['productId' => $cartItem->productId, 'userId' => $req->userId, 'merchantId' => $cartItem->merchantId], [
                        'orderId' => 'ESTORE_' . uniqid(), 'productId' => $cartItem->productId, 'userId' => $req->userId, 'merchantId' => $cartItem->merchantId, 'quantity' => $cartItem->quantity, 'paymentStatus' => 'not paid', 'additionalInfo' => $req->additionalInfo, 'address' => $address, 'postalCode' => $req->postalCode, 'deliveryDate' => $cartItem->deliveryDate
                    ]);
                }
            }





            return redirect()->route('estore payment', ['merchantId' => $cartItem->merchantId, 'userId' => $req->userId, 'country' => $req->country, 'fee' => base64_encode($req->shippingCharge)]);
        } catch (\Throwable $th) {
            $status = 'error';
            $message = $th->getMessage();

            return redirect()->back()->with($status, $message);
        }
    }


    public function storeDiscount(Request $req)
    {

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


    public function updateProduct(Request $req, $id)
    {

        try {
            // Validate
            $validator = Validator::make($req->all(), [
                'productName' => 'required',
                'amount' => 'required',
                'previousAmount' => 'required',
                'stock' => 'required',
                'description' => 'required',
                'category' => 'required'
            ]);

            if ($validator->passes()) {

                // Get Product...

                $getProduct = StoreProducts::where('id', $id)->first();


                if ($req->hasFile('file')) {

                    $routing = Auth::user()->businessname . "/myproduct";

                    $docPath = $this->uploadImageFile($req->file('file'), $routing, 300, 300);
                } else {

                    $docPath = $getProduct->image;
                }


                $category = $req->category == 'Other' ? $req->specifyCategory : $req->category;


                if ($req->category == 'Other') {
                    StoreCategory::insert(['category' => $req->specifyCategory, 'state' => false]);
                }


                $query = [
                    'merchantId' => Auth::id(),
                    'productName' => $req->productName,
                    'productCode' => $req->productCode,
                    'amount' => $req->amount,
                    'previousAmount' => $req->previousAmount,
                    'stock' => $req->stock,
                    'image' => $docPath,
                    'description' => $req->description,
                    'category' => $category,
                    'deliveryDate' => $req->deliveryDate,
                    'deliveryTime' => $req->deliveryTime
                ];



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



    public function updateDiscount(Request $req, $id)
    {

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


    public function deleteProduct($id)
    {
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


    public function deleteDiscount($id)
    {
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


    public function storePickupAddress(Request $req)
    {
        try {

            // Validate
            $validator = Validator::make($req->all(), [
                'address' => 'required',
                'state' => 'required',
                'city' => 'required',
                'deliveryRate' => 'required'
            ]);


            if ($validator->passes()) {

                // Store the address...
                $query =  [
                    'merchantId' => Auth::id(),
                    'address' => $req->address,
                    'state' => $req->state,
                    'city' => $req->city,
                    'deliveryRate' => $req->deliveryRate
                ];

                StorePickup::insert($query);

                $status = 'success';
                $message = 'Pickup address successfully setup for ' . $req->state;
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

    public function editStorePickupAddress(Request $req, $id)
    {
        try {

            // Validate
            $validator = Validator::make($req->all(), [
                'address' => 'required',
                'state' => 'required',
                'city' => 'required',
                'deliveryRate' => 'required'
            ]);


            if ($validator->passes()) {

                // Store the address...
                $query =  [
                    'merchantId' => Auth::id(),
                    'address' => $req->address,
                    'state' => $req->state,
                    'city' => $req->city,
                    'deliveryRate' => $req->deliveryRate
                ];

                StorePickup::where('id', $id)->update($query);

                $status = 'success';
                $message = 'Pickup address successfully updated for ' . $req->state;
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


    public function storeShippingAddress(Request $req)
    {
        try {

            // Validate
            $validator = Validator::make($req->all(), [
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'currencyCode' => 'required',
                'deliveryRate' => 'required'
            ]);


            if ($validator->passes()) {

                // Store the address...
                $query =  [
                    'merchantId' => Auth::id(),
                    'country' => $req->country,
                    'state' => $req->state,
                    'city' => $req->city,
                    'currencyCode' => $req->currencyCode,
                    'deliveryRate' => $req->deliveryRate,
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                StoreShipping::insert($query);

                $status = 'success';
                $message = 'Shipping address successfully setup for ' . $req->city . ', ' . $req->state;
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


    public function editStoreShippingAddress(Request $req, $id)
    {
        try {

            // Validate
            $validator = Validator::make($req->all(), [
                'country' => 'required',
                'state' => 'required',
                'city' => 'required',
                'currencyCode' => 'required',
                'deliveryRate' => 'required'
            ]);


            if ($validator->passes()) {

                // Store the address...
                $query =  [
                    'merchantId' => Auth::id(),
                    'country' => $req->country,
                    'state' => $req->state,
                    'city' => $req->city,
                    'currencyCode' => $req->currencyCode,
                    'deliveryRate' => $req->deliveryRate,
                    'updated_at' => now()
                ];

                StoreShipping::where('id', $id)->update($query);

                $status = 'success';
                $message = 'Shipping address successfully updated for ' . $req->city . ', ' . $req->state;
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


    public function storeProductTax(Request $req)
    {
        try {

            ProductTax::updateOrCreate(['merchantId' => Auth::id(), 'taxName' => $req->taxName], ['merchantId' => Auth::id(), 'taxName' => $req->taxName, 'taxValue' => $req->taxValue, 'created_at' => now(), 'updated_at' => now()]);

            $status = 'success';
            $message = 'Product tax successfully created';
        } catch (\Throwable $th) {
            $status = 'error';
            $message = $th->getMessage();
        }

        return redirect()->back()->with($status, $message);
    }

    public function editProductTax(Request $req, $id)
    {
        try {

            ProductTax::where('id', $id)->update(['merchantId' => Auth::id(), 'taxName' => $req->taxName, 'taxValue' => $req->taxValue, 'updated_at' => now()]);

            $status = 'success';
            $message = 'Product tax successfully updated';
        } catch (\Throwable $th) {
            $status = 'error';
            $message = $th->getMessage();
        }

        return redirect()->back()->with($status, $message);
    }

    public function setupEstore(Request $req)
    {




        try {

            // Validate
            $validator = Validator::make($req->all(), [
                'headerTitle' => 'required',
                'headerSubtitle' => 'required',
                'headerContent' => 'required',
                'businessLogo' => 'required',
                'refundPolicy' => 'required',
            ]);




            if ($validator->passes()) {

                $routing = Auth::user()->businessname . "/estore";

                $headContentImage = "";
                $advertSectionImage = "";

                $businessLogo = $this->uploadImageFile($req->file('businessLogo'), $routing . "/logo", 100, 100);


                if (count($req->file('headerContent')) > 3) {

                    $status = 'error';
                    $message = "Your header content file is more than 3";

                    return redirect()->back()->with($status, $message);
                } else {


                    if ($req->hasFile('headerContent') && count($req->file('headerContent')) > 1) {

                        foreach ($req->file('headerContent') as $headerContentFile) {

                            $headContentImage .= $this->uploadImageFile($headerContentFile, $routing . "/headsection", 1900, 800) . ", ";
                        }
                    } else {
                        $headContentImage = $this->uploadImageFile($req->file('headerContent')[0], $routing . "/headsection", 1900, 800);
                    }
                }






                if ($req->hasFile('advertSectionImage') && count($req->file('advertSectionImage')) > 0) {

                    if (count($req->file('advertSectionImage')) > 3) {
                        $status = 'error';
                        $message = "Your advert section image is more than 3";

                        return redirect()->back()->with($status, $message);
                    } else {
                        if (count($req->file('advertSectionImage')) > 1) {

                            foreach ($req->file('advertSectionImage') as $advertSectionFile) {

                                $advertSectionImage .= $this->uploadImageFile($advertSectionFile, $routing . "/advertsection", 400, 400) . ", ";
                            }
                        } else {
                            $advertSectionImage = $this->uploadImageFile($req->file('advertSectionImage')[0], $routing . "/advertsection", 400, 400);
                        }
                    }
                }


                if (isset($req->publishStore)) {
                    $publish = true;
                } else {
                    $publish = false;
                }



                $query = [
                    'merchantId' => Auth::id(),
                    'businessLogo' => $businessLogo,
                    'headerContent' => $headContentImage,
                    'headerTitle' => $req->headerTitle,
                    'headerSubtitle' => $req->headerSubtitle,
                    'advertSectionImage' => $advertSectionImage,
                    'advertTitle' => $req->advertTitle,
                    'advertSubtitle' => $req->advertSubtitle,
                    'refundPolicy' => $req->refundPolicy,
                    'publish' => $publish,
                    'whatsapp' => $req->whatsapp,
                    'facebook' => $req->facebook,
                    'twitter' => $req->twitter,
                    'instagram' => $req->instagram
                ];



                StoreMainShop::updateOrInsert(['merchantId' => Auth::id()], $query);


                if (isset($req->savePreview)) {

                    return redirect()->route('merchant shop now', Auth::user()->businessname);
                }


                $status = 'success';
                $message = "Store created successfully";
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


    public function addToWishList(Request $req)
    {

        try {

            // Check if user already has the item in wishlist...
            $checkWishlist = StoreWishList::where('productId', $req->productId)->where('userId', $req->userId)->first();


            $getProduct = StoreProducts::where('id', $req->productId)->first();

            if (isset($checkWishlist)) {
                $status = 200;
                $resData = ['data' => [], 'message' => 'Already added to wishlist'];
            } else {
                $data = StoreWishList::create([
                    'userId' => $req->userId,
                    'productId' => $req->productId,
                    'merchantId' => $getProduct->merchantId,
                ]);



                $status = 200;
                $resData = ['data' => $data, 'message' => 'Added ' . $getProduct->productName . ' to wishlist'];
            }
        } catch (\Throwable $th) {
            $status = 400;
            $resData = ['data' => [], 'message' => $th->getMessage()];
        }


        return $this->returnJSON($resData, $status);
    }


    public function addToCart(Request $req)
    {

        try {

            // Check if user already has the item in wishlist...
            $checkCart = StoreCart::where('productId', $req->productId)->where('userId', $req->userId)->first();

            if (isset($req->quantity)) {
                $quantity = $req->quantity;
            } else {
                $quantity = "1";
            }


            $getProduct = StoreProducts::where('id', $req->productId)->first();

            $data = StoreCart::updateOrCreate([
                'userId' => $req->userId,
                'productId' => $req->productId
            ], [
                'userId' => $req->userId,
                'productId' => $req->productId,
                'merchantId' => $getProduct->merchantId,
                'quantity' => $quantity,
                'productName' => $getProduct->productName,
                'productImage' => $getProduct->image,
                'price' => $getProduct->amount,
                'deliveryDate' => $getProduct->deliveryDate,
                'shippingFee' => $getProduct->shippingFee,
                'taxFee' => $getProduct->taxFee
            ]);



            $status = 200;
            $resData = ['data' => $data, 'message' => 'Added ' . $quantity . ' ' . $getProduct->productName . ' to cart'];
        } catch (\Throwable $th) {
            $status = 400;
            $resData = ['data' => [], 'message' => $th->getMessage()];
        }


        return $this->returnJSON($resData, $status);
    }


    public function loadMyCart(Request $req)
    {

        try {

            $data = StoreCart::where('userId', $req->userId)->orderBy('created_at', 'DESC')->get();

            if (count($data) > 0) {
                $merchant = User::where('id', $data[0]->merchantId)->first();
            } else {
                $merchant = [];
            }


            $status = 200;
            $resData = ['data' => $data, 'message' => 'Success', 'merchant' => $merchant];
        } catch (\Throwable $th) {
            $status = 400;
            $resData = ['data' => [], 'message' => $th->getMessage()];
        }


        return $this->returnJSON($resData, $status);
    }



    public function outForDelivery(Request $req)
    {

        try {

            $getOrder = StoreOrders::where('orderId', $req->orderId)->first();

            if (isset($getOrder)) {

                // Generate OTP...

                $code = mt_rand(1111, 9999);

                $link = route('verify delivery', 'otp=' . $code . '&orderId=' . $req->orderId);

                // Insert Record ...
                StoreDelivery::insert([
                    'merchantId' => $getOrder->merchantId, 'userId' => $getOrder->userId, 'orderId' => $req->orderId, 'productId' => $getOrder->productId, 'deliveryCode' => $code, 'expiry' => date('d/m/Y')
                ]);


                StoreOrders::where('orderId', $req->orderId)->update(['deliveryStatus' => 'in-progress']);

                // Get product
                $getProduct = StoreProducts::where('id', $getOrder->productId)->first();


                // Get billing details
                $getBilling = StoreBillingDetail::where('userId', $getOrder->userId)->where('merchantId', $getOrder->merchantId)->first();



                // SEND MAIL......
                $getUser = User::where('id', $getOrder->userId)->first();


                $getMerchant = User::where('id', $getOrder->merchantId)->first();


                $stop_date = date('Y-m-d');
                $expDate = date('Y-m-d', strtotime($stop_date . ' +' . $getProduct->deliveryDate));


                $this->subject = 'Your item ' . $getProduct->productName . ' is out for delivery';
                $this->message = '<p>We have just dispatched your items from your order ' . $req->orderId . '.</p><p>The package will be delivered by our delivery agent once it gets to the delivery hub at the following address: ' . $getBilling->shippingAddress . ' </p><p>Kindly click on the link: ' . $link . ' and enter the code: <b>' . $code . '</b> to confirm your package as soon as our delivery associate get them to you. This code expires on ' . date('d/m/Y', strtotime($expDate)) . ' (' . $getProduct->deliveryDate . ') if order is not verified.</p>';




                $sendMsg = "Hi " . $getUser->name . ", We have just dispatched your items from your order " . $req->orderId . ". Kindly click on the link: " . $link . " and enter the code: " . $code . " to confirm your package as soon as our delivery associate get them to you. This code expires in " . date('d/m/Y', strtotime($expDate)) . " (" . $getProduct->deliveryDate . ")  if order is not verified." . $getMerchant->businessname;

                $getPhone = User::where('email', $getUser->email)->where('telephone', 'LIKE', '%+%')->first();

                if (isset($getPhone)) {

                    $sendPhone = $getUser->telephone;
                } else {
                    $sendPhone = "+" . $getUser->code . $getUser->telephone;
                }

                if ($getUser->country == "Nigeria") {

                    $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                    $this->sendSms($sendMsg, $correctPhone);
                } else {
                    $this->sendMessage($sendMsg, $sendPhone);
                }


                // Send Mail to Buyer...
                $this->estoreMail($getUser->email, $getUser->name, $this->subject, $this->message);


                $status = 200;
                $resData = ['data' => true, 'message' => 'Order successfully processed!'];
            } else {
                $status = 404;
                $resData = ['data' => [], 'message' => 'Order not found'];
            }
        } catch (\Throwable $th) {

            $status = 400;
            $resData = ['data' => [], 'message' => $th->getMessage()];
        }


        return $this->returnJSON($resData, $status);
    }


    public function deliveryOptionDetails(Request $req)
    {
        try {
            if ($req->userSelection == "Home Delivery") {
                $data = StoreShipping::where('merchantId', $req->merchantId)->where('city', $req->city)->orWhere('state', $req->state)->first();
                $message = 'Success';
            } elseif ($req->userSelection == "In Store Pick Up") {
                $data = StorePickup::where('merchantId', $req->merchantId)->first();
                $message = 'Success';
            } else {
                $data = [];
                $message = 'No delivery options available';
            }


            // Fetch data information...

            $status = 200;
            $resData = ['data' => $data, 'message' => $message];
        } catch (\Throwable $th) {
            $status = 400;
            $resData = ['data' => [], 'message' => $th->getMessage()];
        }

        return $this->returnJSON($resData, $status);
    }


    public function verifyProductCode(Request $req)
    {




        try {

            // Get Order with order id and
            $getOrder = StoreOrders::where('orderId', $req->orderId)->first();

            if (isset($getOrder)) {

                $code = $req->pin0 . $req->pin1 . $req->pin2 . $req->pin3;


                if ((int)$code != (int)$req->otp) {
                    $data = [];
                    $message = 'Invalid OTP provided';
                    $status = 400;
                    $action = 'error';
                } else {

                    //  Check for code...
                    $codeCheck = StoreDelivery::where('deliveryCode', $req->otp)->where('orderId', $req->orderId)->where('status', 'not claimed')->first();

                    if (isset($codeCheck)) {

                        $getUser = User::where('id', $getOrder->userId)->first();
                        $getMerchant = User::where('id', $getOrder->merchantId)->first();

                        $getProduct = StoreProducts::where('id', $getOrder->productId)->first();

                        StoreDelivery::where('deliveryCode', $req->otp)->where('orderId', $req->orderId)->update(['status' => 'claimed']);

                        StoreOrders::where('orderId', $req->orderId)->update(['deliveryStatus' => 'delivered']);


                        $productPrice = $getProduct->amount * $getOrder->quantity;
                        $cashbackvalue = 0.02 * $productPrice;
                        $newprice = $productPrice - $cashbackvalue;
                        $escrowBalance = $getMerchant->escrow_balance - $productPrice;
                        $walletBalance = $getMerchant->wallet_balance + $productPrice;
                        $cashbackmerchant = $getMerchant->wallet_balance + $newprice;

                        //cashback checks and deductions
                        $merchantcheck = MerchantCashback::where('merchant_id', $getOrder->merchantId)->first();

                        if (isset($merchantcheck)) {
                            User::where('id', $getOrder->merchantId)->update(['wallet_balance' => $cashbackmerchant, 'escrow_balance' => $escrowBalance]);

                            $customerwallet = $getUser->wallet_balance;
                            $cashtouser = $cashbackvalue / 2;
                            $newcustomerbalance = $customerwallet + $cashtouser;

                            User::where('id', $getOrder->userId)->update([
                                'wallet_balance' => $newcustomerbalance,
                            ]);

                            CashbackRecords::create([
                                'merchant_id' => $getOrder->merchantId,
                                'product_id' =>  $getOrder->productId,
                                'user_id' => $getOrder->userId,
                                'user_cashback_amount' => $cashtouser,
                                'merchant_cashback_amount' => $newprice,
                                'paysprint_cashback' => $cashtouser
                            ]);

                            // Mail Merchant ...
                            $this->name = $getMerchant->name;
                            $this->email = $getMerchant->email;
                            $this->subject = $getMerchant->currencyCode . ' ' . number_format($newprice, 2) . " now added to your wallet with PaySprint";

                            $this->message = '<p>Item with order ' . $req->orderId . ' has successfully been confirmed and delivered to customer: ' . $getUser->name . '. <strong>' . $getMerchant->currencyCode . ' ' . number_format($newprice, 2) . '</strong> has been added to your wallet with PaySprint. You have <strong>' . $getMerchant->currencyCode . ' ' . number_format($cashbackmerchant, 2) . '</strong> balance in your account</p>';

                            $sendMsg = 'Item with order ' . $req->orderId . ' has successfully been confirmed and delivered to customer: ' . $getUser->name . '. ' . $getMerchant->currencyCode . ' ' . number_format($newprice, 2) . ' has been added to your wallet with PaySprint. You have ' . $getMerchant->currencyCode . ' ' . number_format($cashbackmerchant, 2) . ' balance in your account';


                            $userPhone = User::where('email', $getMerchant->email)->where('telephone', 'LIKE', '%+%')->first();

                            if (isset($userPhone)) {

                                $sendPhone = $getMerchant->telephone;
                            } else {
                                $sendPhone = "+" . $getMerchant->code . $getMerchant->telephone;
                            }

                            if ($getMerchant->country == "Nigeria") {

                                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                $this->sendSms($sendMsg, $correctPhone);
                            } else {
                                $this->sendMessage($sendMsg, $sendPhone);
                            }


                            // Send Mail to Merchant...
                            $this->estoreMail($getMerchant->email, $getMerchant->name, $this->subject, $this->message);


                            // Mail Consumer...

                            $subject = 'Item with order ' . $req->orderId . ' delivered!';

                            $message = '<p>Item with order ' . $req->orderId . ' has successfully been confirmed and delivered. Thank you for your patronage!</p>';


                            $sendMsg2 = 'Item with order ' . $req->orderId . ' has successfully been confirmed and delivered. Thank you for your patronage!';


                            $userPhone2 = User::where('email', $getUser->email)->where('telephone', 'LIKE', '%+%')->first();

                            if (isset($userPhone2)) {

                                $sendPhone2 = $getUser->telephone;
                            } else {
                                $sendPhone2 = "+" . $getUser->code . $getUser->telephone;
                            }

                            if ($getUser->country == "Nigeria") {

                                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone2);
                                $this->sendSms($sendMsg2, $correctPhone);
                            } else {
                                $this->sendMessage($sendMsg2, $sendPhone2);
                            }



                            // Send Mail to Merchant...
                            $this->estoreMail($getUser->email, $getUser->name, $subject, $message);


                            $data = true;
                            $message = 'Delivery confirmed!';
                            $status = 200;
                            $action = 'success';
                        } else {
                            User::where('id', $getOrder->merchantId)->update(['wallet_balance' => $walletBalance, 'escrow_balance' => $escrowBalance]);



                            // Mail Merchant ...
                            $this->name = $getMerchant->name;
                            $this->email = $getMerchant->email;
                            $this->subject = $getMerchant->currencyCode . ' ' . number_format($productPrice, 2) . " now added to your wallet with PaySprint";

                            $this->message = '<p>Item with order ' . $req->orderId . ' has successfully been confirmed and delivered to customer: ' . $getUser->name . '. <strong>' . $getMerchant->currencyCode . ' ' . number_format($productPrice, 2) . '</strong> has been added to your wallet with PaySprint. You have <strong>' . $getMerchant->currencyCode . ' ' . number_format($walletBalance, 2) . '</strong> balance in your account</p>';

                            $sendMsg = 'Item with order ' . $req->orderId . ' has successfully been confirmed and delivered to customer: ' . $getUser->name . '. ' . $getMerchant->currencyCode . ' ' . number_format($productPrice, 2) . ' has been added to your wallet with PaySprint. You have ' . $getMerchant->currencyCode . ' ' . number_format($walletBalance, 2) . ' balance in your account';


                            $userPhone = User::where('email', $getMerchant->email)->where('telephone', 'LIKE', '%+%')->first();

                            if (isset($userPhone)) {

                                $sendPhone = $getMerchant->telephone;
                            } else {
                                $sendPhone = "+" . $getMerchant->code . $getMerchant->telephone;
                            }

                            if ($getMerchant->country == "Nigeria") {

                                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                                $this->sendSms($sendMsg, $correctPhone);
                            } else {
                                $this->sendMessage($sendMsg, $sendPhone);
                            }


                            // Send Mail to Merchant...
                            $this->estoreMail($getMerchant->email, $getMerchant->name, $this->subject, $this->message);


                            // Mail Consumer...

                            $subject = 'Item with order ' . $req->orderId . ' delivered!';

                            $message = '<p>Item with order ' . $req->orderId . ' has successfully been confirmed and delivered. Thank you for your patronage!</p>';


                            $sendMsg2 = 'Item with order ' . $req->orderId . ' has successfully been confirmed and delivered. Thank you for your patronage!';


                            $userPhone2 = User::where('email', $getUser->email)->where('telephone', 'LIKE', '%+%')->first();

                            if (isset($userPhone2)) {

                                $sendPhone2 = $getUser->telephone;
                            } else {
                                $sendPhone2 = "+" . $getUser->code . $getUser->telephone;
                            }

                            if ($getUser->country == "Nigeria") {

                                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone2);
                                $this->sendSms($sendMsg2, $correctPhone);
                            } else {
                                $this->sendMessage($sendMsg2, $sendPhone2);
                            }



                            // Send Mail to Merchant...
                            $this->estoreMail($getUser->email, $getUser->name, $subject, $message);
                        }

                        $data = true;
                        $message = 'Delivery confirmed!';
                        $status = 200;
                        $action = 'success';
                    } else {
                        $data = [];
                        $message = 'Invalid OTP provided';
                        $status = 400;
                        $action = 'error';
                    }
                }
            } else {
                $data = [];
                $message = 'Unknown order id';
                $status = 404;
                $action = 'error';
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
            $action = 'error';
        }

        return redirect()->route('epsresponseback', 'status=' . $action . '&message=' . $message)->with($action, $message);
    }


    public function removeCartItem(Request $req)
    {
        try {

            // Delete This Cart Item...

            StoreCart::where('id', $req->id)->delete();


            $resData = ['data' => true, 'message' => 'Deleted'];
            $status = 200;
        } catch (\Throwable $th) {
            $status = 400;
            $resData = ['data' => [], 'message' => $th->getMessage()];
        }

        return $this->returnJSON($resData, $status);
    }


    public function uploadImageFile($file, $fileroute, $width = null, $height = null)
    {

        try {
            //Get filename with extension
            $filenameWithExt = $file->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $file->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = rand() . '_' . time() . '.' . $extension;

            $img = Image::make($file)->fit($width, $height);

            $img->save('shopstore/' . $fileroute . '/' . $fileNameToStore);

            // $file->move(public_path('../../shopstore/' . $fileroute . '/'), $fileNameToStore);


            $docPath = route('home') . "/shopstore/" . $fileroute . "/" . $fileNameToStore;
        } catch (\Throwable $th) {
            //Get filename with extension
            $filenameWithExt = $file->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $file->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = rand() . '_' . time() . '.' . $extension;


            $path = $file->move(public_path('../../shopstore/' . $fileroute . '/'), $fileNameToStore);


            $docPath = route('home') . "/shopstore/" . $fileroute . "/" . $fileNameToStore;
        }

        return $docPath;
    }

    public function getPaymentGateway($country)
    {

        $data = AllCountries::where('name', $country)->first();

        return $data;
    }


    public function estoreMail($email, $name, $subject, $message)
    {

        $this->to = $email;
        $this->name = $name;
        $this->subject = $subject;
        $this->message = $message;

        $this->sendEmail($this->to, "Fund remittance");
    }


    public function sendEmail($objDemoa, $purpose)
    {
        $objDemo = new \stdClass();
        $objDemo->purpose = $purpose;




        if ($purpose == 'Fund remittance') {
            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->subject = $this->subject;
            $objDemo->message = $this->message;
        }

        Mail::to($objDemoa)
            ->send(new sendEmail($objDemo));
    }
}
