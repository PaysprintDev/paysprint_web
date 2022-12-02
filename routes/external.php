<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoexController;
use App\Http\Controllers\MoexPSController;


Route::prefix('moex-cron')->group(function () {
	Route::get('/daily-exchange', [MoexController::class, 'sendDailyExchange'])->name('daily exchange');
});



Route::prefix('moex/api')->group(function () {
	Route::get('/daily-exchange', [MoexController::class, 'callDailyExchange'])->name('call daily exchange');
});

Route::prefix('moextops')->group(function () {
	Route::post('/verifytransaction', [MoexPSController::class, 'getExTransaction'])->name('verify moex ps transaction');
	Route::post('/confirmpayment', [MoexPSController::class, 'confirmPaymentTransaction'])->name('confirm moex ps transaction');
});

