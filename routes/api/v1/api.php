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


    });




    Route::group(['middleware' => ['apitoken']], function () {

    Route::post('profile',  ['uses' => 'api\v1\UserController@updateProfile'])->name('update profile');


    Route::post('sendmoney',  ['uses' => 'api\v1\MoneyTransferController@sendMoney'])->name('send money');


    Route::post('receivemoney',  ['uses' => 'api\v1\MoneyTransferController@receiveMoney'])->name('receive money');


    Route::get('getreceiver',  ['uses' => 'api\v1\MoneyTransferController@getReceiver'])->name('get receiver');

    Route::get('getsender',  ['uses' => 'api\v1\MoneyTransferController@getSender'])->name('get sender');


    Route::get('commissionfee',  ['uses' => 'api\v1\MoneyTransferController@commissionFee'])->name('commission fee');



    Route::get('getallstatement',  ['uses' => 'api\v1\StatementController@getAllStatement'])->name('get all statement');


    Route::get('getstatementbydate',  ['uses' => 'api\v1\StatementController@getStatementByDate'])->name('get statement by date');


    Route::get('getallinvoice',  ['uses' => 'api\v1\InvoiceController@getAllInvoices'])->name('get all invoices');


    Route::get('getspecificinvoice',  ['uses' => 'api\v1\InvoiceController@getSpecificInvoices'])->name('get specific invoices');


    Route::get('getinvoicebyservice',  ['uses' => 'api\v1\InvoiceController@getInvoiceByService'])->name('get invoice by service');


    Route::get('notification',  ['uses' => 'api\v1\NotificationController@getNotifications'])->name('get notification');


    // Add Card
    Route::get('getmycard',  ['uses' => 'api\v1\CardController@getCard'])->name('get my card');

    Route::post('addnewcard',  ['uses' => 'api\v1\CardController@addNewCard'])->name('add new card');

    Route::post('editcard',  ['uses' => 'api\v1\CardController@editCard'])->name('edit card');

    Route::post('deletecard',  ['uses' => 'api\v1\CardController@deleteCard'])->name('delete card');

    Route::post('addmoneytowallet',  ['uses' => 'MonerisController@addMoneyToWallet'])->name('add money to wallet');

    Route::post('moneywithdrawal',  ['uses' => 'MonerisController@moneyWithdrawal'])->name('withdraw from wallet');


    });

});
