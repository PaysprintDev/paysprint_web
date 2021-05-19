<?php

use Illuminate\Http\Request;

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
    

    Route::group(['middleware' => ['appkey']], function () {

        // Registration
        Route::post('register',  ['uses' => 'api\v1\UserController@userRegistration']);

        // Login
        Route::post('login',  ['uses' => 'api\v1\UserController@userLogin']);

        // Get Service Types
        Route::get('getservicestypes',  ['uses' => 'api\v1\ServiceController@getServicetype']);

        // Get Tranasaction Structure
        Route::get('get-transaction-structure',  ['uses' => 'api\v1\MoneyTransferController@getTransactionStructure']);


        Route::post('currencyconversion',  ['uses' => 'CurrencyConverterApiController@mycurrencyConvert']);


    });


    Route::group(['middleware' => ['apitoken']], function () {

        Route::post('profile',  ['uses' => 'api\v1\UserController@updateProfile'])->name('update profile');


        Route::post('linkaccount',  ['uses' => 'api\v1\UserController@linkAccount'])->name('link account');

        Route::post('otheraccount',  ['uses' => 'api\v1\UserController@otherAccount'])->name('other account');

        Route::post('merchantprofile',  ['uses' => 'api\v1\UserController@updateMerchantProfile'])->name('merchant profile');

        Route::post('merchantbusinessprofile',  ['uses' => 'api\v1\UserController@updateMerchantBusinessProfile'])->name('merchant business profile');


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

        Route::post('addnewcard',  ['uses' => 'api\v1\CardController@addNewCard'])->name('add new card');
        
        Route::post('editcard',  ['uses' => 'api\v1\CardController@editCard'])->name('edit card');

        Route::post('editbank',  ['uses' => 'api\v1\CardController@editBank'])->name('edit bank');
        
        Route::post('deletecard',  ['uses' => 'api\v1\CardController@deleteCard'])->name('delete card');

        Route::post('deletebank',  ['uses' => 'api\v1\CardController@deleteBank'])->name('delete bank');
        
        Route::post('addmoneytowallet',  ['uses' => 'MonerisController@addMoneyToWallet'])->name('add money to wallet');
        
        Route::post('moneywithdrawal',  ['uses' => 'MonerisController@moneyWithdrawal'])->name('withdraw from wallet');
        
        Route::get('getmycarddetail',  ['uses' => 'api\v1\CardController@getMyCardDetail'])->name('get card details');
        
        Route::post('addnewbank',  ['uses' => 'api\v1\CardController@addNewBank'])->name('add new bank');


        // pay Invoice
        Route::post('payinvoice',  ['uses' => 'MonerisController@payInvoice'])->name('pay invoice from wallet');
        
        // Create Single Invoice
        Route::post('singleinvoice',  ['uses' => 'api\v1\InvoiceController@singleInvoice'])->name('create single invoice');
        Route::post('bulkinvoice',  ['uses' => 'api\v1\InvoiceController@bulkInvoice'])->name('create bulk invoice');


        // Send Money to User not on PS
        Route::post('sendmoneytoanonymous',  ['uses' => 'GooglePaymentController@sendMoneyToAnonymous'])->name('send money to user not on ps');


    });


    Route::group(['middleware' => ['merchantkey']], function () {

        // Receive Money To PaySprint
        Route::post('customers',  ['uses' => 'api\v1\MerchantApiController@receiveMoneyFromPaysprintCustomer']);
        Route::post('visitors',  ['uses' => 'api\v1\MerchantApiController@receiveMoneyFromVisitors']);


    });

});
