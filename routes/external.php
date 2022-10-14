<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MoexController;


Route::prefix('moex-cron')->group(function () {
	Route::get('/daily-exchange', [MoexController::class, 'sendDailyExchange'])->name('daily exchange');
});


