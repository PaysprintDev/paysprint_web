<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('/v1')->group(function () {


    Route::get('epspayinvoicelink',  ['uses' => 'MonerisController@epspayInvoiceLink'])->name('eps pay invoice link from gateway');

    Route::get('getmarketcategory',  ['uses' => 'MarketplaceController@getmarketCategory'])->name('get market category');
    Route::get('getallbusiness',  ['uses' => 'MarketplaceController@getallBusinesses'])->name('get businesses');

    Route::post('/becomepayoutagent', ['uses' => 'PayoutAgentController@beAnAgent', 'as' => 'be an agent on paysprint']);

    Route::get('latestmerchant',  ['uses' => 'MarketplaceController@newestMerchant'])->name('newest merchant');
    Route::get('findproduct',  ['uses' => 'MarketplaceController@findProduct'])->name('find product');
    Route::get('getallproducts',  ['uses' => 'MarketplaceController@getProducts'])->name('get products');
    Route::get('getallnews',  ['uses' => 'MarketplaceController@getNews'])->name('get news');

    Route::get('conversionrate/{local}/{foreign}',  ['uses' => 'Controller@getConversionRate']);
    Route::get('payoutmethod/{foreign}',  ['uses' => 'Controller@getPayoutMethod']);


    Route::group(['middleware' => ['appkey']], function () {

        // Registration
        Route::post('register',  ['uses' => 'api\v1\UserController@userRegistration']);

        // Login
        Route::post('login',  ['uses' => 'api\v1\UserController@userLogin']);

        // Get Service Types
        Route::get('getservicestypes',  ['uses' => 'api\v1\ServiceController@getServicetype']);

        // Get payment gateways
        Route::get('paymentgateway',  ['uses' => 'api\v1\ServiceController@paymentGateway']);

        // Get Tranasaction Structure
        Route::get('get-transaction-structure',  ['uses' => 'api\v1\MoneyTransferController@getTransactionStructure']);


        Route::post('currencyconversion',  ['uses' => 'CurrencyConverterApiController@mycurrencyConvert']);


        

        Route::get('classifiedbusinessdirectory',  ['uses' => 'api\v1\UserController@classifiedBusinessDirectory']);


        // pay Invoice
        Route::post('payinvoicelink',  ['uses' => 'MonerisController@payInvoiceLink'])->name('pay invoice link from gateway');


        Route::post('payinshop',  ['uses' => 'MonerisController@paymentInShop'])->name('pay in shop');


        // Get Investors News
        Route::get('investorsnews',  ['uses' => 'api\v1\InvestorRelationController@investorNews'])->name('Investor news');

        Route::get('specificnews/{id}',  ['uses' => 'api\v1\InvestorRelationController@investorSpecificNews'])->name('Investor specific news');

        // Do Investors data...
        Route::post('investordetails',  ['uses' => 'api\v1\InvestorRelationController@investorDetails'])->name('Investor details');

        // Investor login
        Route::post('investorlogin', ['uses' => 'api\v1\InvestorRelationController@investorLogin']);



        // Investor Password Reset
        Route::post('investor/forgot-password', ['uses' => 'api\v1\InvestorRelationController@investorForgotPassword']);
        Route::post('investor/reset-password', ['uses' => 'api\v1\InvestorRelationController@investorResetPassword']);


        // Investor Relation ....

        Route::get('investor/activatedposts', ['uses' => 'api\v1\InvestorRelationController@investorActivatedPosts']);
        Route::post('investor/interestpayload', ['uses' => 'api\v1\InvestorRelationController@investorInterestPayload']);


        Route::get('investor/get-specific', ['uses' => 'api\v1\InvestorRelationController@investorGetSpecificPost']);
        Route::get('investor/express-interest', ['uses' => 'api\v1\InvestorRelationController@investorExpressInteret']);

        Route::get('investor/logout', ['uses' => 'api\v1\InvestorRelationController@logout']);
    });


    Route::group(['middleware' => ['apitoken']], function () {

        Route::post('profile',  ['uses' => 'api\v1\UserController@updateProfile'])->name('update profile');

        // Points and Reward
        Route::get('/acquiredpoints', ['uses' => 'api\v1\UserController@acquiredPoints', 'as' => 'acquired points']);

        Route::post('/claimmypoints', ['uses' => 'api\v1\UserController@claimMyPoints', 'as' => 'claim my points']);

        Route::post('changeplan',  ['uses' => 'api\v1\UserController@changePlan'])->name('change plan');

        Route::get('getsubscriptionplan',  ['uses' => 'api\v1\UserController@getMySubscription'])->name('get my subscription');


        Route::post('linkaccount',  ['uses' => 'api\v1\UserController@linkAccount'])->name('link account');

        Route::post('vouchaccount',  ['uses' => 'api\v1\UserController@vouchAccount'])->name('vouch account');

        Route::post('otheraccount',  ['uses' => 'api\v1\UserController@otherAccount'])->name('other account');

        Route::get('getlinkedaccount',  ['uses' => 'api\v1\UserController@secondaryAccounts'])->name('secondary account');

        Route::post('merchantprofile',  ['uses' => 'api\v1\UserController@updateMerchantProfile'])->name('merchant profile');

        Route::post('merchantbusinessprofile',  ['uses' => 'api\v1\UserController@updateMerchantBusinessProfile'])->name('merchant business profile');

        Route::post('ownerandcontrollersprofile',  ['uses' => 'api\v1\UserController@updateOwnerAndControllersProfile'])->name('owner and controllers profile');


        Route::post('promotebusiness',  ['uses' => 'api\v1\UserController@promoteYourBusiness'])->name('promote business');

        Route::post('broadcastbusiness',  ['uses' => 'api\v1\UserController@broadcastYourBusiness'])->name('broadcast business');


        Route::get('merchantsbyservicetypes',  ['uses' => 'api\v1\UserController@merchantsByServiceTypes'])->name('merchants by service types');

        Route::get('listmerchantsbyservicetypes',  ['uses' => 'api\v1\UserController@listMerchantsByServiceTypes'])->name('list merchants by service types');

        Route::get('getmerchant/{id}',  ['uses' => 'api\v1\UserController@getMerchantData'])->name('get merchant full data');




        Route::post('createservicetype',  ['uses' => 'api\v1\ServiceController@createServiceType'])->name('create service type');

        Route::post('setuptax',  ['uses' => 'api\v1\TaxController@setupTax'])->name('set up taxes');

        Route::post('edittax',  ['uses' => 'api\v1\TaxController@editTax'])->name('edit taxes');

        Route::post('deletetax',  ['uses' => 'api\v1\TaxController@deleteTax'])->name('delete taxes');


        Route::get('gettaxdetail',  ['uses' => 'api\v1\TaxController@getTaxDetail'])->name('get tax detail');

        Route::post('createtransactionpin',  ['uses' => 'api\v1\UserController@createTransactionPin'])->name('create transaction pin');

        Route::post('updatetransactionpin',  ['uses' => 'api\v1\UserController@updateTransactionPin'])->name('update transaction pin');

        Route::post('updatepassword',  ['uses' => 'api\v1\UserController@updatePassword'])->name('update password');


        Route::post('security',  ['uses' => 'api\v1\UserController@updateSecurity'])->name('update security');

        Route::post('bvnverification',  ['uses' => 'api\v1\UserController@bvnVerification'])->name('verify bvn');

        Route::post('verifyaccountnumber',  ['uses' => 'api\v1\UserController@accountNumberVerification'])->name('verify account number');

        Route::post('autodeposit',  ['uses' => 'api\v1\UserController@updateAutoDeposit'])->name('update auto deposit');


        Route::post('resetpassword',  ['uses' => 'api\v1\UserController@resetPassword'])->name('reset password');

        Route::post('resettransactionpin',  ['uses' => 'api\v1\UserController@resetTransactionPin'])->name('reset transaction pin');


        Route::post('sendmoney',  ['uses' => 'api\v1\MoneyTransferController@sendMoney'])->name('send money');


        Route::post('claimmoney',  ['uses' => 'api\v1\MoneyTransferController@claimMoney'])->name('claim money');


        Route::post('receivemoney',  ['uses' => 'api\v1\MoneyTransferController@receiveMoney'])->name('receive money');


        Route::get('getreceiver',  ['uses' => 'api\v1\MoneyTransferController@getReceiver'])->name('get receiver');

        Route::get('getsender',  ['uses' => 'api\v1\MoneyTransferController@getSender'])->name('get sender');


        Route::post('commissionfee',  ['uses' => 'api\v1\MoneyTransferController@commissionFee'])->name('commission fee');



        Route::post('debitwalletforcard',  ['uses' => 'api\v1\MoneyTransferController@debitWalletForCard'])->name('debit wallet for exbc card');

        Route::post('requestcard',  ['uses' => 'api\v1\MoneyTransferController@requestPrepaidCard'])->name('request for prepaid card');

        Route::post('requestforrefund',  ['uses' => 'api\v1\MoneyTransferController@requestForRefund'])->name('request for refund');



        Route::get('getallstatement',  ['uses' => 'api\v1\StatementController@getAllStatement'])->name('get all statement');

        Route::get('getmystatement',  ['uses' => 'api\v1\StatementController@getMyStatement'])->name('get my statement');


        Route::get('getstatementbydate',  ['uses' => 'api\v1\StatementController@getStatementByDate'])->name('get statement by date');


        Route::get('getspecificstatement',  ['uses' => 'api\v1\StatementController@getSpecificStatement'])->name('get specific statetement');

        Route::get('getspecificstatementbydate',  ['uses' => 'api\v1\StatementController@getSpecificStatementByDate'])->name('get specific statetement by date');


        Route::get('getallinvoice',  ['uses' => 'api\v1\InvoiceController@getAllInvoices'])->name('get all invoices');


        Route::get('getspecificinvoice',  ['uses' => 'api\v1\InvoiceController@getSpecificInvoices'])->name('get specific invoices');

        Route::get('getmyinvoice',  ['uses' => 'api\v1\InvoiceController@getMyInvoices'])->name('get my invoices');




        Route::get('getinvoicebyservice',  ['uses' => 'api\v1\InvoiceController@getInvoiceByService'])->name('get invoice by service');


        Route::get('notification',  ['uses' => 'api\v1\NotificationController@getNotifications'])->name('get notification');


        // Add Card
        Route::get('getmycard',  ['uses' => 'api\v1\CardController@getCard'])->name('get my card');

        Route::get('getprepaidcardissuers',  ['uses' => 'api\v1\CardController@getPrepaidCardIssuers'])->name('get prepaid card issuers');

        Route::post('addbeneficiary',  ['uses' => 'api\v1\CardController@addUpBeneficiary'])->name('add beneficiary');

        Route::get('getbeneficiary',  ['uses' => 'api\v1\CardController@getBeneficiary'])->name('get beneficiary');

        Route::post('addnewcard',  ['uses' => 'api\v1\CardController@addNewCard'])->name('add new card');



        Route::post('editcard',  ['uses' => 'api\v1\CardController@editCard'])->name('edit card');

        Route::post('editbank',  ['uses' => 'api\v1\CardController@editBank'])->name('edit bank');

        Route::post('deletecard',  ['uses' => 'api\v1\CardController@deleteCard'])->name('delete card');

        Route::post('deletebank',  ['uses' => 'api\v1\CardController@deleteBank'])->name('delete bank');


        // Check users verification...
        Route::get('checkidv', ['uses' => 'MonerisController@checkMyIdv'])->name('check my identity');


        Route::post('addmoneytowallet',  ['uses' => 'MonerisController@addMoneyToWallet'])->name('add money to wallet');

        Route::post('addmoneywithtransfer',  ['uses' => 'PayoutAgentController@addMoneyWithTransfer'])->name('add money with transfer');

        Route::post('/partneraddmoneytowallet', ['uses' => 'PayoutAgentController@partnerAddMoneyToWallet', 'as' => 'partner add money to wallet']);

        Route::post('moneywithdrawal',  ['uses' => 'MonerisController@moneyWithdrawal'])->name('withdraw from wallet');

        Route::post('payutilitybills',  ['uses' => 'MonerisController@payUtilityBills'])->name('pay utility bills');

        Route::get('getproductdetails/{id}',  ['uses' => 'MonerisController@getProductDetails'])->name('get product details');

        Route::post('getutilitydiscount',  ['uses' => 'MonerisController@getCommissionConversion'])->name('utility discount');

        Route::post('getaccountinfo',  ['uses' => 'MonerisController@paymentLookUp'])->name('get account information');

        Route::get('getmycarddetail',  ['uses' => 'api\v1\CardController@getMyCardDetail'])->name('get card details');

        Route::get('getbillerslogo',  ['uses' => 'api\v1\ServiceController@getBillersLogo'])->name('get billers logo');

        Route::post('addnewbank',  ['uses' => 'api\v1\CardController@addNewBank'])->name('add new bank');


        // pay Invoice
        Route::post('payinvoice',  ['uses' => 'MonerisController@payInvoice'])->name('pay invoice from wallet');

        // Cross Border Payment
        Route::post('crossborder',  ['uses' => 'MonerisController@crossBorder'])->name('pay cross border invoice from wallet');

        // Create Single Invoice
        Route::post('singleinvoice',  ['uses' => 'api\v1\InvoiceController@singleInvoice'])->name('create single invoice');
        Route::post('singleinvoicelink',  ['uses' => 'api\v1\InvoiceController@singleInvoiceLink'])->name('create link invoice');
        Route::post('bulkinvoice',  ['uses' => 'api\v1\InvoiceController@bulkInvoice'])->name('create bulk invoice');


        // Send Money to User not on PS
        Route::post('sendmoneytoanonymous',  ['uses' => 'GooglePaymentController@sendMoneyToAnonymous'])->name('send money to user not on ps');


        // CurrencyFX Active Order
        Route::get('/activeorders', ['uses' => 'CurrencyFxController@getActiveOrders', 'as' => 'currency fx active orders']);




        // CurrencyFX Sold Orders
        Route::get('/ongoingorders', ['uses' => 'CurrencyFxController@getSoldOrders', 'as' => 'currency fx ongoing orders']);

        // CurrencyFX Pending Orders
        Route::get('/pendingorders', ['uses' => 'CurrencyFxController@getPendingOrders', 'as' => 'currency fx pending orders']);


        // CurrencyFX Pending Orders
        Route::get('/myorders', ['uses' => 'CurrencyFxController@getMyOrders', 'as' => 'currency fx my orders']);

        // CurrencyFX Recent Bids
        Route::get('/getrecentbids', ['uses' => 'CurrencyFxController@getMyRecentBids', 'as' => 'currency fx my recent bids']);

        // Get a particular bid
        Route::get('/getthisbids', ['uses' => 'CurrencyFxController@getThisParticularBids', 'as' => 'currency fx this particular bids']);


        // Create Orders
        Route::post('/createoffer', ['uses' => 'api\v1\MoneyTransferController@createNewOrder', 'as' => 'currency fx create orders']);


        // Get My Escrow account
        Route::get('/getescrow', ['uses' => 'CurrencyFxController@getEscrow', 'as' => 'get escrow account']);


        // Fund FX Wallet

        Route::post('/fundfx', ['uses' => 'CurrencyFxController@fundFXWallet', 'as' => 'fund fx wallet']);

        // Create FX Wallet

        Route::post('/createfxwallet', ['uses' => 'CurrencyFxController@createNewWallet', 'as' => 'currency fx create wallet']);

        // GEt Wallets

        Route::get('/fxwallets', ['uses' => 'CurrencyFxController@fxWallets', 'as' => 'get my wallets']);

        Route::get('/getthisfxwallets', ['uses' => 'CurrencyFxController@getThisFxWallets', 'as' => 'get this fx wallets']);




        // Make a Bid
        Route::post('/makeabid', ['uses' => 'CurrencyFxController@makeABid', 'as' => 'currency fx make a bid']);


        // Accept a bid
        Route::post('/acceptbid', ['uses' => 'CurrencyFxController@acceptABid', 'as' => 'currency fx accept a bid']);


        //Get wallets

        Route::post('/getotherwallets', ['uses' => 'CurrencyFxController@getOtherWallets', 'as' => 'currency fx get other wallets']);



        // Get all invoice to fx
        Route::get('/getallinvoicetofx', ['uses' => 'CurrencyFxController@getAllInvoiceToFx', 'as' => 'currency fx get all invoice to fx']);
        Route::get('/getpaidinvoicetofx', ['uses' => 'CurrencyFxController@getPaidInvoiceToFx', 'as' => 'currency fx get paid invoice to fx']);
        Route::get('/getpendinginvoicetofx', ['uses' => 'CurrencyFxController@getPendingInvoiceToFx', 'as' => 'currency fx get pending invoice to fx']);


        // Get all Cross Border  Information
        Route::get('/getallcrossborderpayment', ['uses' => 'CurrencyFxController@getAllCrossBorderPayment', 'as' => 'currency fx get all cross border payment']);
        Route::get('/getpendingcrossborderpayment', ['uses' => 'CurrencyFxController@getPendingCrossBorderPayment', 'as' => 'currency fx get pending cross border payment']);



        Route::get('/cross-border-beneficiary', ['uses' => 'CurrencyFxController@getCrossBorderBeneficiaries', 'as' => 'get cross border beneficiary']);


        // Convert Money to Send

        Route::post('/convertmoneytosend', ['uses' => 'CurrencyFxController@convertMoneyToTransfer', 'as' => 'currency fx convert money to transfer']);





        // Transfer money

        Route::post('/transferfxfund', ['uses' => 'CurrencyFxController@transferFXFund', 'as' => 'currency transfer fx fund']);
        // Get Transaction History

        Route::get('/fxtransactionhistory', ['uses' => 'CurrencyFxController@fxTransactionHistory', 'as' => 'get transaction history']);



        // Shop
        Route::post('/shop/product/addtowishlist', ['uses' => 'ShopController@addToWishList', 'as' => 'add to wish list']);
        Route::post('/shop/product/addtocart', ['uses' => 'ShopController@addToCart', 'as' => 'add to cart']);
        Route::get('/shop/product/loadmycart', ['uses' => 'ShopController@loadMyCart', 'as' => 'load my cart']);;

        Route::post('/shop/product/deliveryoption', ['uses' => 'ShopController@deliveryOptionDetails', 'as' => 'delivery option details']);


        Route::post('/shop/product/removecartitem', ['uses' => 'ShopController@removeCartItem', 'as' => 'remove cart item']);

        // Services.....
        Route::post('/service/setup', ['uses' => 'ServiceController@setupService', 'as' => 'setup service']);

        // Estore

        Route::post('/order/out-for-delivery', ['uses' => 'ShopController@outForDelivery', 'as' => 'out for delivery or pickup']);

        Route::post('/processpayout', ['uses' => 'PayoutAgentController@processPayOut', 'as' => 'process payout fee']);
    });


    Route::group(['middleware' => ['merchantkey']], function () {

        // Receive Money To PaySprint
        Route::post('customers',  ['uses' => 'api\v1\MerchantApiController@receiveMoneyFromPaysprintCustomer']);
        Route::post('visitors',  ['uses' => 'api\v1\MerchantApiController@receiveMoneyFromVisitors']);
        Route::post('visitors-payment',  ['uses' => 'api\v1\MerchantApiController@receiveMoneyFromEstoreVisitors']);

        // Checkout Routes

        Route::prefix('transaction')->group(function () {
            Route::post('/initialize', ['uses' => 'api\v1\CheckoutController@initialize', 'as' => 'initialize transaction']);
        });


        // Handahske...
        Route::post('sync/handshake',  ['uses' => 'ThirdPartyHandshakeController@handshakeRegistration']);
    });

    // Get Currency value
    Route::get('/fetchcurrency', ['uses' => 'CurrencyFxController@fetchCurrency', 'as' => 'currency fetcher']);

    Route::post('walletbalance',  ['uses' => 'api\v1\MerchantApiController@getMyWalletBalance', 'as' => 'check customer wallet balance']);

    Route::get('/userdata', ['uses' => 'CurrencyFxController@getUserData', 'as' => 'currency user data']);

    Route::get('/ps-account-details', ['uses' => 'CurrencyFxController@paysprintAccountDetails', 'as' => 'get paysprint account details']);

    Route::get('sync/countries',  ['uses' => 'ThirdPartyHandshakeController@
    ']);

    Route::get('/transaction-fee',  ['uses' => 'ThirdPartyHandshakeController@transactionFeeCharge']);
});
