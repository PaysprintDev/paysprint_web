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


    });

});
