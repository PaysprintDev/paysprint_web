<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\MoexController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DusupayController;
use App\Http\Controllers\TriggerController;
use App\Http\Controllers\FlutterwaveController;
use App\Http\Controllers\MerchantPageController;
use App\Http\Controllers\WalletCreditController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


// search country
Route::post('search', ['uses' => 'HomeController@searchCountry', 'as' => 'search']);

//import data
Route::get('importdata', ['uses' => 'MoexController@importData', 'as' => 'import data']);

//scrapping data
Route::get('scrapewebsite', ['uses' => 'ScraperController@getScraper', 'as' => 'scrape website']);

// App Logger
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


Route::get('testrazor', 'MonerisController@testRazor');

Route::post('triggerdate', ['uses' => 'TriggerController@triggerDate', 'as' => 'trigger date']);

//marketplace claimbusiness
Route::get('claimmerchantbusiness', ['uses' => 'AdminController@claimingBusiness', 'as' => 'claiming business']);


// Route::get('feecharge', 'MaintenanceFeeCharge@monthlyMaintenaceFee');
Route::get('renewsub', 'MaintenanceFeeCharge@renewSubscription');
Route::get('refreshbid', 'CurrencyFxController@refreshBids');

Route::get('testonesignal', 'CheckSetupController@testOneSignal');


Route::get('quicksetup', 'CheckSetupController@updateQuickSetup');
Route::get('autodepositoff', 'CheckSetupController@autoDepositOff');
Route::get('accountactivity', 'CheckSetupController@checkAccountAcvtivity');
Route::get('updatestatementcountry', 'CheckSetupController@statementCountry');
Route::get('chargefee', 'CheckSetupController@chargeFee');
Route::get('insertcountry', 'CheckSetupController@insertCountry');
Route::get('merchanttest', 'CheckSetupController@merchantTestMode');
Route::get('merchantlive', 'CheckSetupController@merchantLiveMode');
Route::get('reportstatus', 'CheckSetupController@reportStatus');
Route::get('updatefee', 'CheckSetupController@updateMonthlyFee');
Route::get('refundbycountryupdate', 'CheckSetupController@refundbyCountry');
Route::get('passwordreminder', 'CheckSetupController@passwordReminder');
// Route::get('epsvendorupdate', 'CheckSetupController@updateEPSVendor');
Route::get('notification-table', 'CheckSetupController@notificationTable');
Route::get('notification-period', 'CheckSetupController@notificationPeriod');
Route::get('monthlytransaction', 'CheckSetupController@monthlyTransactionHistory');
Route::get('nonmonthlytransaction', 'CheckSetupController@nonMonthlyTransactionHistory');
Route::get('exbccardrequest', 'CheckSetupController@checkExbcCardRequest');
Route::get('trullioverification', 'CheckSetupController@checkTrullioVerification');
Route::get('migratetolevelone', 'CheckSetupController@migrateUsersToLevelOne');
Route::get('insertspecialinfoactivity', 'CheckSetupController@insertspecialinfoActivity');
Route::get('autofeestructure', 'CheckSetupController@setupFeeStructure');
Route::get('checktelephone', 'CheckSetupController@checkTelephone');
Route::get('userarchive', 'CheckSetupController@userAccountArchive');
Route::get('matchedusersmove', 'CheckSetupController@matchedUsersAccount');
Route::get('approvedusersmove', 'CheckSetupController@approvedUsersAccount');
Route::get('movefailedtopass', 'CheckSetupController@moveFromFailedToPass');
Route::get('movepassedtocompletedpending', 'CheckSetupController@moveFromPassedToCompletedPending');
Route::get('crontomerchant', 'CheckSetupController@cronToMerchant');
Route::get('crontoconsumers', 'CheckSetupController@cronToConsumers');
Route::get('giveaccountcheck', 'CheckSetupController@giveAccountCheckUpgrade');
Route::get('downcheckmerchant', 'CheckSetupController@downcheckMerchants');


// In-App Notifications Controller
Route::get('idvnotificationmessage', 'CheckSetupController@idvNotifationMessage');

// Generate virtual account for users
Route::get('generate-virtual-account', 'CheckSetupController@flutterwaveVirtualAccountGenerate');


Route::get('virtual-account-top-up', 'CheckSetupController@getAllTransactionTransfers');


Route::get('mailforvirtualaccount', 'SendGridController@cronToCustomersOnVirtualAccount');


// Send Notice to Users and Merchants...
Route::get('publicizemerchant', 'CheckSetupController@publicizeMerchantToConsumer');
Route::get('notify-merchant-page', 'CheckSetupController@notifyMerchantPage');
// update walletcredit
Route::get('updatewalletcredit', 'CreditController@updateWalletCredit');

// IDV Mail Chimp
Route::get('idvcompletedlist', 'CheckSetupController@idvCompletedList');
Route::get('idvpassedlist', 'CheckSetupController@idvPassedList');
Route::get('idvfailedlist', 'CheckSetupController@idvFailedList');
Route::get('docpendinglist', 'CheckSetupController@docPendingList');
Route::get('suspendedaccountlist', 'CheckSetupController@suspendedAccountList');
Route::get('upgradedaccountlist', 'CheckSetupController@upgradedAccounts');

// Statement Mail SendMail
Route::get('mailstatement', 'SendGridController@cronToCustomersOnCustomerStatement');
Route::get('rewardpoint', 'SendGridController@cronToCustomersOnRewardStatement');
Route::get('mailtocustomer', 'SendGridController@cronToPublicizeMerchantToConsumer');
Route::get('claimbusiness', 'SendGridController@claimBusiness');

// country flag
Route::get('countryflag', 'CountryFlagController@displayCountryFlag');
Route::get('countrycca', 'CountryFlagController@getCountrycca3');


// AML Background Check
Route::get('amlcheck', 'ShuftiProController@callAmlCheck');
Route::get('kyccheck', 'ShuftiProController@callKycCheck');

Route::get('checkcharge', 'MonerisController@chargeForShuftiProVerification');


// Update BVN List
Route::get('bvnlistupdate', 'CheckSetupController@bvnListUpdate');


Route::get('updatepricinglist', 'CheckSetupController@updatePricingUnits');



// Merchant to Customer Information
Route::get('merchantshopservice', 'CheckSetupController@merchantsShopService');



// Happy New Month From PaySpirnt
Route::get('happynewmonth', 'CheckSetupController@happyNewMonth');

// KYB Completed and Industry
Route::get('movekybcompleted', 'CheckSetupController@moveKYBCompleted');
Route::get('moveindustry', 'CheckSetupController@moveIndustry');


Route::get('existingaccounts', 'CheckSetupController@existingAccounts');
Route::get('updatewallet', 'CheckSetupController@updateExbcAccount');
Route::get('returnfee', 'MaintenanceFeeCharge@returnFeeCharge');
Route::get('getinvoicecurrency', 'CheckSetupController@updateImportExcelCurrency');
Route::get('updatebankdetails', 'CheckSetupController@addedBanksCountry');
Route::get('publisharchive', 'CheckSetupController@publishArchiveUsers');
Route::get('publishexisting', 'CheckSetupController@publishExistingUsers');
Route::get('transactionlimits', 'CheckSetupController@updateTransLimit');
Route::get('numberofwithdrawals', 'CheckSetupController@updateNumberofWithdrawal');
Route::get('numberofwithdrawalsformerchant', 'CheckSetupController@updateMerchantNumberofWithdrawal');

Route::get('reversal', 'CheckSetupController@reverseFund');


Route::get('creditsubscription', 'MonthlySubController@creditSubAccount');
Route::get('correctstatement', 'MonthlySubController@correctStatementRecord');




// Test MoexController
Route::get('testmoex', [MoexController::class, 'cashpot4'])->name('testmoex');




// Generate Shop Links...


// Verify delivery

Route::get('verify-delivery', ['uses' => 'ShopController@verifyDelivery', 'as' => 'verify delivery']);
Route::post('verify-product-code', ['uses' => 'ShopController@verifyProductCode', 'as' => 'verify product code']);




// Vie List of Referred
Route::get('/myreferredlist/{ref_code}', ['uses' => 'ReferralsController@index', 'as' => 'referrals list of users']);
// Route::get('/claimedhistory/{ref_code}', ['uses' => 'ReferralsController@index', 'as' => 'show claimed history']);

// Get Path Address
Route::get('pathaddress', 'CheckSetupController@getPathAddress');

// Country Update Currency
Route::get('countryupdate', 'CheckSetupController@countryUpdate');


// Transaction Limit
Route::get('dailylimit', 'CheckSetupController@dailyLimit');
Route::get('weeklylimit', 'CheckSetupController@weeklyLimit');
Route::get('monthlylimit', 'CheckSetupController@monthlyLimit');




// SET OTP REQUEST
Route::post('otpstore', ['uses' => 'OtpController@store', 'as' => 'otp.store']);


Route::get('merchantinvoiceupdate', 'WorkorderController@controlInvoice');

Route::get('/run-queue', function () {

	Artisan::call('queue:work --tries=3 --timeout=60');
	return "Queue work done!";
});


Route::get('/clear', function () {

	Artisan::call('config:clear');
	// Artisan::call('config:cache');
	// Artisan::call('cache:clear');
	// Artisan::call('route:clear');
	// Artisan::call('view:clear');
	return "Package Cleared!";
});


// Major Routes


Route::get('/', ['uses' => 'HomeController@homePage', 'as' => 'home']);
Route::get('/userjourney', ['uses' => 'HomeController@userJourney', 'as' => 'user journey']);
Route::get('/estore', ['uses' => 'HomeController@estores', 'as' => 'paysprint estore']);

Route::get('/merchant-test', ['uses' => 'HomeController@merchantIndex', 'as' => 'merchant home']);
Route::get('/merchant-home', ['uses' => 'HomeController@merchantHome', 'as' => 'merchant test']);
Route::get('/usecase', ['uses' => 'HomeController@merchantUseCase', 'as' => 'use case']);
Route::get('/accounts', ['uses' => 'HomeController@getStartedAccounts', 'as' => 'accounts']);

Route::get('/home', ['uses' => 'HomeController@authIndex', 'as' => 'user home']);

Route::get('/referred', ['uses' => 'HomeController@referredDetails', 'as' => 'referred details']);

Route::get('/viewreviews', ['uses' => 'MerchantPageController@viewReviews', 'as' => 'view reviews']);

Route::post('/merchantreply', ['uses' => 'MerchantPageController@merchantReply', 'as' => 'merchant reply']);

Route::get('/viewreply/{id}', ['uses' => 'MerchantPageController@viewmarketReplies', 'as' => 'view replies']);

Route::get('/makereview', ['uses' => 'MerchantPageController@makeReview', 'as' => 'make review']);

Route::post('/submitreview', ['uses' => 'MerchantPageController@submitReview', 'as' => 'submit review']);




Route::get('/supporting-haiti', ['uses' => 'HomeController@haitiDonation', 'as' => 'haiti donation']);

Route::get('about', ['uses' => 'HomeController@about', 'as' => 'about']);

Route::get('Invoice', ['uses' => 'HomeController@invoice', 'as' => 'invoice']);

Route::get('Statement', ['uses' => 'HomeController@statement', 'as' => 'statement']);

Route::get('payorganization', ['uses' => 'HomeController@payOrganization', 'as' => 'payorganization']);

Route::get('bulkpayment', ['uses' => 'HomeController@bulkPayment', 'as' => 'bulk payment']);
Route::get('bulksend', ['uses' => 'HomeController@bulkSend', 'as' => 'bulk send']);
Route::get('deletebulksend', ['uses' => 'HomeController@deleteBulkSend', 'as' => 'delete bulk send']);
Route::post('bulktransfer', ['uses' => 'HomeController@createBulkTransfer', 'as' => 'create bulk transfer']);
Route::get('contact', ['uses' => 'HomeController@contact', 'as' => 'contact']);

Route::get('countrylist', ['uses' => 'HomeController@displayCountry', 'as' => 'display country']);

Route::get('countrylists', ['uses' => 'HomeController@displayCountryMerchant', 'as' => 'display country merchant']);



Route::prefix('developers')->group(function () {
	Route::get('/community', ['uses' => 'HomeController@community', 'as' => 'community']);
	Route::get('/askquestion', ['uses' => 'HomeController@askQuestion', 'as' => 'askquestion']);
	Route::post('/askquestion', ['uses' => 'HomeController@storeAskedQuestions', 'as' => 'askquestion']);
	Route::get('/submessage/{id}', ['uses' => 'HomeController@subMessage', 'as' => 'submessage']);
	Route::post('/storeanswer', ['uses' => 'HomeController@storeSubMessage', 'as' => 'storeanswer']);
});

// Route::get('/updatesubscription', ['uses' => 'AdminController@updateSubscription', 'as' => 'update subscription']);


Route::prefix('shop')->group(function () {
	Route::get('/{merchant}', ['uses' => 'MerchantPageController@merchantShop', 'as' => 'merchant shop now']);
});

Route::prefix('service')->group(function () {
	Route::get('/{merchant}', ['uses' => 'MerchantPageController@merchantService', 'as' => 'merchant service now']);
});


Route::prefix('merchant')->group(function () {
	Route::get('/services/{id}', ['uses' => 'ServiceController@merchantPlatformService', 'as' => 'merchant platform service']);
	Route::get('/pricing/{id}', ['uses' => 'ServiceController@merchantPlatformPricing', 'as' => 'merchant platform pricing']);

	Route::post('/contactus/{id}', ['uses' => 'ServiceController@contactMerchant', 'as' => 'contact merchant']);
});

// Virtual Account Flutterwave
Route::prefix('flutterwave')->group(function () {
	Route::get('create-virtual-account', [FlutterwaveController::class, 'initiateNewAccountNumber'])->name('test flutterwave virtual account');
	Route::get('get-virtual-account', [FlutterwaveController::class, 'initiategetVirtualAccountNumber'])->name('get flutterwave virtual account');
	Route::get('webhook', [FlutterwaveController::class, 'flutterwaveWebhook'])->name('flutterwave webhook');
});







Route::prefix('product')->group(function () {

	Route::get('/cart', ['uses' => 'MerchantPageController@myCart', 'as' => 'customer shoping cart']);
	Route::get('/checkout', ['uses' => 'MerchantPageController@myCheckout', 'as' => 'checkout item']);
	Route::post('/place-order', ['uses' => 'ShopController@placeOrder', 'as' => 'place order']);
	Route::get('payment', ['uses' => 'HomeController@estorePayment', 'as' => 'estore payment']);
	Route::get('/shop', ['uses' => 'MerchantPageController@merchantShopPage', 'as' => 'product shop']);
	Route::get('/orders', ['uses' => 'MerchantPageController@merchantOrders', 'as' => 'orders']);
	Route::get('/order-details', ['uses' => 'MerchantPageController@singleOrder', 'as' => 'single orders']);
	Route::get('/wishlist', ['uses' => 'MerchantPageController@wishlist', 'as' => 'wishlist']);
	Route::post('/deletelist/{id}', ['uses' => 'MerchantPageController@deleteWishlist', 'as' => 'delete wishlist']);
});





Route::get('Service', ['uses' => 'HomeController@service', 'as' => 'service']);

Route::get('vouchlist', ['uses' => 'HomeController@vouchList', 'as' => 'vouchlist']);

Route::get('Ticket', ['uses' => 'HomeController@ticket', 'as' => 'ticket']);


Route::get('profile', ['uses' => 'HomeController@profile', 'as' => 'profile']);
Route::get('referrallink', ['uses' => 'HomeController@referralLink', 'as' => 'referral link']);


Route::get('verification', ['uses' => 'HomeController@verifyAuthentication', 'as' => 'verification page']);

Route::get('verificationpage', ['uses' => 'HomeController@checkVerification', 'as' => 'check verification page']);

Route::post('verifyotp', ['uses' => 'HomeController@verifyOtp', 'as' => 'verifyotp']);
Route::get('regenerateotp', ['uses' => 'HomeController@regenerateOtp', 'as' => 'regenerate otp']);


//updating verification details
Route::post('verifyphoto', ['uses' => 'HomeController@verifyPhoto', 'as' => 'verify photo']);
Route::post('verifyidentitycard', ['uses' => 'HomeController@verifyIdentityCard', 'as' => 'verify identity card']);
Route::post('verifypassport', ['uses' => 'HomeController@verifyPassport', 'as' => 'verify passport']);
Route::post('verifybill', ['uses' => 'HomeController@verifyBill', 'as' => 'verify bill']);
Route::post('verifylicense', ['uses' => 'HomeController@verifyLicense', 'as' => 'verify license']);
Route::post('verifybvn', ['uses' => 'HomeController@verifyBvn', 'as' => 'verify bvn']);

// Terms or USE
Route::get('terms-of-service', ['uses' => 'HomeController@termsOfUse', 'as' => 'terms of use']);

// Pricing
Route::get('pricing', ['uses' => 'HomeController@feeStructure', 'as' => 'pricing structure']);

// Merchant Pricing
Route::get('merchant-pricing', ['uses' => 'HomeController@feeStructure2', 'as' => 'pricing structure merchant']);

// Privacy Policy
Route::get('privacy-policy', ['uses' => 'HomeController@privacyPolicy', 'as' => 'privacy policy']);


Route::get('payment/{invoice}', ['uses' => 'HomeController@payment', 'as' => 'payment']);

// Payment Link for Invoice
Route::get('payment/link/{invoice}/{country}', ['uses' => 'HomeController@paymentFromLink', 'as' => 'payment from link']);

Route::get('payment/sendmoney/{user_id}', ['uses' => 'HomeController@paymentOrganization', 'as' => 'sendmoney payment']);
Route::get('new/payment/createuser', ['uses' => 'HomeController@createnewPayment', 'as' => 'create new payment']);
Route::get('payment/receivemoney/{id}', ['uses' => 'HomeController@receiveMoney', 'as' => 'receivemoney payment']);






// Cash Advance Pages

Route::get('/cashadvance', ['uses' => 'HomeController@cashAdvance', 'as' => 'cash advance']);



// Stripe Route
Route::post('create-payment-intent', ['uses' => 'MonerisController@paymentIntent', 'as' => 'stripe payment intent']);

Route::post('create-payment-invoice-intent', ['uses' => 'MonerisController@invoicepaymentIntent', 'as' => 'stripe invoice payment intent']);


// Express Payment Callback
Route::prefix('expresspay')->group(function () {
	Route::get('/resp', ['uses' => 'MonerisController@expressCallback', 'as' => 'express callback']);
	Route::get('/estoreresp', ['uses' => 'MonerisController@estoreExpressCallback', 'as' => 'estore express callback']);
	Route::get('/business', ['uses' => 'MonerisController@expressBusinessCallback', 'as' => 'express business callback']);
	Route::get('/responseback', ['uses' => 'HomeController@expressResponseback', 'as' => 'epsresponseback']);
});


// Dusupay Payment
Route::prefix('dusupay')->group(function () {
	Route::get('/resp', ['uses' => 'MonerisController@dusuPayCallback', 'as' => 'dusupay callback']);
	Route::get('/bankcode/{id}', ['uses' => 'DusupayController@getDusuBankCode', 'as' => 'dusupay bankcode']);
});


// Currency FX Page
Route::prefix('currencyfx')->group(function () {
	Route::get('/start', ['uses' => 'CurrencyFxController@start', 'as' => 'paysprint currency exchange start']);
	Route::get('/', ['uses' => 'CurrencyFxController@index', 'as' => 'paysprint currency exchange']);
	Route::get('marketplace', ['uses' => 'CurrencyFxController@marketPlace', 'as' => 'paysprint currency market place']);
	Route::get('invoice', ['uses' => 'CurrencyFxController@myInvoices', 'as' => 'paysprint currency invoices']);
	Route::get('crossborderplatform', ['uses' => 'CurrencyFxController@myCrossBorderPlatform', 'as' => 'paysprint currency cross border platform']);
	Route::get('pendingcrossborderpayment', ['uses' => 'CurrencyFxController@myPendingCrossBorderPayment', 'as' => 'paysprint currency pending cross border payment']);

	Route::get('paidinvoices', ['uses' => 'CurrencyFxController@paidInvoices', 'as' => 'paysprint currency paid invoices']);
	Route::get('pendinginvoices', ['uses' => 'CurrencyFxController@pendingInvoices', 'as' => 'paysprint currency pending invoices']);

	Route::get('transactionhistory', ['uses' => 'CurrencyFxController@transactionHistory', 'as' => 'paysprint currency transaction history']);
	Route::get('wallethistory', ['uses' => 'CurrencyFxController@walletHistory', 'as' => 'paysprint currency wallet history']);
	Route::get('mywallet', ['uses' => 'CurrencyFxController@myWallet', 'as' => 'paysprint currency wallets']);
	Route::get('ongoing', ['uses' => 'CurrencyFxController@marketPlaceOngoingTransaction', 'as' => 'paysprint currency market place ongoing']);
	Route::get('pending', ['uses' => 'CurrencyFxController@marketPlacePendingTransaction', 'as' => 'paysprint currency market place pending']);
	Route::get('myorders', ['uses' => 'CurrencyFxController@marketPlaceMyOrder', 'as' => 'paysprint currency market place myorders']);
	Route::get('recentbids', ['uses' => 'CurrencyFxController@marketRecentBids', 'as' => 'paysprint currency market place recentbids']);
	Route::get('viewmybids', ['uses' => 'CurrencyFxController@marketViewMyBids', 'as' => 'paysprint currency market place viewmybids']);


	Route::get('makebid/{orderId}', ['uses' => 'CurrencyFxController@marketPlaceYourBid', 'as' => 'paysprint currency make bid']);
	Route::get('acceptbid', ['uses' => 'CurrencyFxController@marketAcceptABid', 'as' => 'paysprint currency accept bid']);


	// Cross Border Payment

	Route::get('crossborder', ['uses' => 'CurrencyFxController@crossBorder', 'as' => 'paysprint cross border payment']);



	Route::get('createwallet', ['uses' => 'CurrencyFxController@createWallet', 'as' => 'paysprint currency fx create wallet']);

	// Fund FX Account
	Route::prefix('fund')->group(function () {
		Route::get('/', ['uses' => 'CurrencyFxController@fundAccount', 'as' => 'currency exchange funding']);
		Route::get('/transfer', ['uses' => 'CurrencyFxController@transferfundAccount', 'as' => 'currency exchange transfer funding']);
		Route::get('/withdraw', ['uses' => 'CurrencyFxController@withdrawfundAccount', 'as' => 'currency exchange withdraw funding']);
	});
});

// Wallet Page

Route::prefix('mywallet')->group(function () {

	Route::get('/', ['uses' => 'HomeController@myAccount', 'as' => 'my account']);
	Route::get('card', ['uses' => 'HomeController@addCard', 'as' => 'Add card']);
	Route::get('exbccard', ['uses' => 'HomeController@requestExbcCard', 'as' => 'request exbc card']);
	Route::get('editcard/{id}', ['uses' => 'HomeController@editCard', 'as' => 'Edit card']);
	Route::get('editbank/{id}', ['uses' => 'HomeController@editBank', 'as' => 'Edit bank']);
	Route::get('addmoney', ['uses' => 'HomeController@addMoney', 'as' => 'Add Money']);
	Route::get('choosepayment', ['uses' => 'HomeController@choosePayment', 'as' => 'Choose Payment']);
	Route::get('choosewithdrawal', ['uses' => 'HomeController@chooseWithdrawal', 'as' => 'Choose Withdraw']);
	Route::get('processmoney', ['uses' => 'HomeController@processMoney', 'as' => 'Process Money']);
	Route::get('withdrawmoney', ['uses' => 'HomeController@withdrawMoney', 'as' => 'Withdraw Money']);
	Route::get('addbank', ['uses' => 'HomeController@addBankDetail', 'as' => 'Add bank detail']);
	Route::get('requestrefund', ['uses' => 'HomeController@requestForRefund', 'as' => 'request for refund']);
	Route::get('notifications', ['uses' => 'HomeController@allNotifications', 'as' => 'notifications']);
	Route::get('paymentgateway', ['uses' => 'HomeController@paymentGateway', 'as' => 'payment gateway']);
	Route::get('partnerpayment', ['uses' => 'HomeController@partnerPayment', 'as' => 'partner payment']);
	Route::get('partnerlist', ['uses' => 'HomeController@partnerList', 'as' => 'partner list']);
	Route::get('partnerwithdrawal', ['uses' => 'HomeController@partnerWithdrawal', 'as' => 'partner withdrawal']);
	Route::post('addmobilemoney', ['uses' => 'HomeController@addMobileMoney', 'as' => 'mobile money']);
	Route::post('withdrawmobilemoney', ['uses' => 'DusupayController@withdrawMobileMoney', 'as' => 'withdraw mobile']);
});

Route::get('merchantcategory', ['uses' => 'HomeController@merchantCategory', 'as' => 'merchant category']);
Route::get('allmerchantcategory', ['uses' => 'HomeController@allMerchantCategory', 'as' => 'all merchant']);

Route::get('selectcountryutilitybills', ['uses' => 'HomeController@selectCountryUtilityBills', 'as' => 'select utility bills country']);
Route::get('payutilitybills', ['uses' => 'HomeController@expressUtilities', 'as' => 'utility bills']);
Route::get('buyutilitybills/{id}', ['uses' => 'HomeController@expressBuyUtilities', 'as' => 'buy utility bills']);

Route::get('signout/{id}',  ['uses' => 'api\v1\UserController@logout'])->name('sign out');





// New Merchant Page Route
Route::prefix('merchant')->group(function () {

	Route::get('/dashboard', [MerchantPageController::class, 'index'])->name('dashboard');
	Route::get('/invoice', [MerchantPageController::class, 'invoiceSingle'])->name('invoice single');
	Route::get('/invoice/single-invoice', [MerchantPageController::class, 'invoiceForm'])->name('invoice form');
	Route::get('/createinvoicetypes', [MerchantPageController::class, 'invoiceTypes'])->name('invoice types');
	Route::get('/setuptax', [MerchantPageController::class, 'setUpTax'])->name('set up tax');
	Route::get('/invoicestatement', [MerchantPageController::class, 'invoiceStatement'])->name('invoice statement');
	Route::get('/walletstatement', [MerchantPageController::class, 'walletStatement'])->name('wallet statement');
	Route::get('/sentinvoice', [MerchantPageController::class, 'sentInvoice'])->name('sent invoice');
	Route::get('/paidinvoice', [MerchantPageController::class, 'paidInvoice'])->name('paid invoice');
	Route::get('/pendinginvoice', [MerchantPageController::class, 'pendingInvoice'])->name('pending invoice');
	Route::get('/customerbalancereport', [MerchantPageController::class, 'balanceReport'])->name('balance report');
	Route::get('/taxesreport', [MerchantPageController::class, 'taxesReport'])->name('taxes report');
	Route::get('/invoicetypereport', [MerchantPageController::class, 'invoiceTypeReport'])->name('invoice type report');
	Route::get('/reccuringreport', [MerchantPageController::class, 'recurringType'])->name('recurring type');
	Route::get('/profile', [MerchantPageController::class, 'profile'])->name('merchants profile');
	Route::get('/invoicepage', [MerchantPageController::class, 'invoicePage'])->name('invoice page');
	Route::get('/paymentgateway', [MerchantPageController::class, 'paymentGateway'])->name('new merchant payment gateway');
	Route::get('/estore', [MerchantPageController::class, 'orderingSystem'])->name('ordering system');
	Route::get('/storepickupaddress', [MerchantPageController::class, 'storepickupAddress'])->name('storepickup address');
	Route::get('/deliverypickupaddress', [MerchantPageController::class, 'deliverypickupAddress'])->name('deliverypickup address');

	Route::get('/mypayoutrecord', [MerchantPageController::class, 'payoutRecord'])->name('my payout record');

	Route::post('/requestpaymentlink', [MerchantPageController::class, 'requestPaymentLink'])->name('request payment link');



	Route::get('businessprofile/{id}', [MerchantPageController::class, 'businessProfile'])->name('merchant business profile');


	Route::get('/{shop}/{id}', [ShopController::class, 'index'])->name('my shop payment');
	Route::post('/storeproduct', [ShopController::class, 'storeProduct'])->name('store product');
	Route::post('/storediscount', [ShopController::class, 'storeDiscount'])->name('store discount');
	Route::post('/updateproduct/{id}', [ShopController::class, 'updateProduct'])->name('update product');
	Route::post('/deleteproduct/{id}', [ShopController::class, 'deleteProduct'])->name('delete product');
	Route::post('/updatediscount/{id}', [ShopController::class, 'updateDiscount'])->name('update discount');
	Route::post('/deletediscount/{id}', [ShopController::class, 'deleteDiscount'])->name('delete discount');
	Route::post('/storepickupaddress', [ShopController::class, 'storePickupAddress'])->name('store pickup address');
	Route::post('/editstorepickupaddress/{id}', [ShopController::class, 'editStorePickupAddress'])->name('edit pickup address');
	Route::post('/storeshippingaddress', [ShopController::class, 'storeShippingAddress'])->name('store shipping address');
	Route::post('/editstoreshippingaddress/{id}', [ShopController::class, 'editStoreShippingAddress'])->name('edit shipping address');
	Route::post('/storeproducttax', [ShopController::class, 'storeProductTax'])->name('store product tax');
	Route::post('/editproducttax/{id}', [ShopController::class, 'editProductTax'])->name('edit product tax');


	Route::post('/setupestore', [ShopController::class, 'setupEstore'])->name('setup estore');
	Route::post('/cashback', [MerchantPageController::class, 'cashback'])->name('cashback');
	Route::post('/requestreview', [MerchantPageController::class, 'requestReview'])->name('request review');
	Route::post('/endcashback', [MerchantPageController::class, 'endcashback'])->name('endcashback');






	// Setup Service Page...
	Route::get('servicestore', [MerchantPageController::class, 'estoreService'])->name('merchant service setup');
});




// General Rental Management PAGE
Route::get('rentalmanagement-start', ['uses' => 'HomeController@rentalManagementStart', 'as' => 'rentalmanagement start']);
Route::get('rentalmanagement-admin-start', ['uses' => 'HomeController@rentalManagementAdminStart', 'as' => 'rentalmanagement admin start']);

Route::get('rentalmanagement', ['uses' => 'HomeController@rentalManagement', 'as' => 'rentalmanagement']);

Route::get('myrentalmanagementfacility/admin/{email}', ['uses' => 'HomeController@myRentalManagementFacility', 'as' => 'myRentalManagementFacility']);

Route::post('deleteproperty',  ['uses' => 'HomeController@deleteProperty'])->name('delete property');


// Admin Rental Management Page
Route::get('rentalmanagement/admin', ['uses' => 'HomeController@rentalManagementAdmin', 'as' => 'rentalManagementAdmin']);

Route::get('rentalmanagement/admin/facility', ['uses' => 'HomeController@rentalManagementAdminfacility', 'as' => 'facility']);

Route::get('rentalmanagement/admin/consultant', ['uses' => 'HomeController@rentalManagementAdminconsultant', 'as' => 'consultant']);

Route::get('rentalmanagement/admin/consultant/edit/{id}', ['uses' => 'HomeController@rentalManagementAdmineditconsultant', 'as' => 'editconsultant']);

Route::get('rentalmanagement/admin/viewfacility', ['uses' => 'HomeController@rentalManagementAdminviewfacility', 'as' => 'viewfacility']);

Route::get('rentalmanagement/admin/viewconsultant', ['uses' => 'HomeController@rentalManagementAdminviewconsultant', 'as' => 'viewconsultant']);

Route::get('rentalmanagement/admin/viewinvoices', ['uses' => 'HomeController@rentalManagementAdminviewinvoices', 'as' => 'viewinvoices']);

Route::get('rentalmanagement/admin/viewquotes', ['uses' => 'HomeController@rentalManagementAdminviewquotes', 'as' => 'viewquotes']);

Route::get('rentalmanagement/admin/viewquotes/negotiate/{id}', ['uses' => 'HomeController@rentalManagementAdminnegotiate', 'as' => 'negotiate']);

Route::get('rentalmanagement/admin/maintenance', ['uses' => 'HomeController@rentalManagementAdminMaintenance', 'as' => 'adminmaintenance']);

Route::get('rentalmanagement/admin/workorder', ['uses' => 'HomeController@rentalManagementAdminWorkorder', 'as' => 'adminworkorder']);

Route::get('rentalmanagement/admin/maintenance/view/{id}', ['uses' => 'HomeController@rentalManagementAdminMaintenanceview', 'as' => 'adminmaintenanceview']);

Route::get('rentalmanagement/admin/maintenance/assignconsultant/{id}', ['uses' => 'HomeController@rentalManagementassignconsultant', 'as' => 'assignconsultant']);


// Consultant Rental Management PAGE
Route::get('rentalmanagement/consultant', ['uses' => 'HomeController@rentalManagementConsultant', 'as' => 'rentalManagementConsultant']);

Route::get('rentalmanagement/consultant/mymaintenance/{id}', ['uses' => 'HomeController@rentalManagementConsultantMymaintnenance', 'as' => 'consultantMymaintnenance']);
Route::get('rentalmanagement/consultant/workorder', ['uses' => 'HomeController@rentalManagementConsultantWorkorder', 'as' => 'consultantWorkorder']);
Route::get('rentalmanagement/consultant/maintenance/{id}', ['uses' => 'HomeController@rentalManagementConsultantMaintenance', 'as' => 'consultantMaintenance']);
Route::get('rentalmanagement/consultant/invoice/{id}', ['uses' => 'HomeController@rentalManagementConsultantInvoice', 'as' => 'consultantInvoice']);
Route::get('rentalmanagement/consultant/quote/{id}', ['uses' => 'HomeController@rentalManagementConsultantQuote', 'as' => 'consultantQuote']);
Route::get('rentalmanagement/consultant/negotiate/{id}', ['uses' => 'HomeController@rentalManagementConsultantNegotiate', 'as' => 'consultantNegotiate']);

// Rental Manangement System TENANT
Route::get('maintenance', ['uses' => 'HomeController@maintenance', 'as' => 'maintenance']);

Route::get('maintenance/status', ['uses' => 'HomeController@maintenanceStatus', 'as' => 'maintenancestatus']);

Route::get('maintenance/view/{id}', ['uses' => 'HomeController@maintenanceView', 'as' => 'maintenanceview']);

Route::get('maintenance/edit/{id}', ['uses' => 'HomeController@maintenanceEdit', 'as' => 'maintenanceedit']);


Route::get('amenities', ['uses' => 'HomeController@amenities', 'as' => 'amenities']);

Route::get('amenities/facilityview/{id}', ['uses' => 'HomeController@facilityview', 'as' => 'facilityview']);
Route::get('amenities/makeabooking/{id}', ['uses' => 'HomeController@makeBooking', 'as' => 'makeabooking']);



Route::get('messages', ['uses' => 'HomeController@messages', 'as' => 'messages']);
Route::get('paymenthistory', ['uses' => 'HomeController@paymenthistory', 'as' => 'paymenthistory']);
Route::get('documents', ['uses' => 'HomeController@documents', 'as' => 'documents']);
Route::get('otherservices', ['uses' => 'HomeController@otherservices', 'as' => 'otherservices']);

Route::get('Myinvoice/{key}', ['uses' => 'HomeController@myinvoice', 'as' => 'Myinvoice']);

Route::get('Myreceipt/{key}', ['uses' => 'HomeController@myreceipt', 'as' => 'Myreceipt']);


Route::get('walletstatement/{key}', ['uses' => 'HomeController@mywalletStatement', 'as' => 'My Wallet Statement']);


// Client Admin ROute
Route::get('Admin', ['uses' => 'AdminController@index', 'as' => 'Admin']);


Route::get('allusers', ['uses' => 'AdminController@allPlatformUsers', 'as' => 'allusers']);


Route::get('approvedusers', ['uses' => 'AdminController@allApprovedUsers', 'as' => 'approvedusers']);
Route::post('autocreditapproval', ['uses' => 'AdminController@autoCreditApproval', 'as' => 'auto credit activation']);


Route::get('upgradedconsumer', ['uses' => 'AdminController@allUpgradedConsumers', 'as' => 'upgradedconsumer']);
Route::get('upgradedmerchant', ['uses' => 'AdminController@allUpgradedMerchants', 'as' => 'upgradedmerchant']);
Route::get('approvedpendingusers', ['uses' => 'AdminController@allApprovedPendingUsers', 'as' => 'approvedpendingusers']);
Route::get('matchedusers', ['uses' => 'AdminController@allMatchedUsers', 'as' => 'matchedusers']);
Route::get('leveltwousers', ['uses' => 'AdminController@allLevelTwoUsers', 'as' => 'leveltwousers']);
Route::get('pendingusers', ['uses' => 'AdminController@allPendingUsers', 'as' => 'pendingusers']);
Route::get('overrideusers', ['uses' => 'AdminController@allOverrideUsers', 'as' => 'overrideusers']);
Route::get('notactivepsusers', ['uses' => 'AdminController@allNotActivePsUsers', 'as' => 'notactivepsusers']);
Route::get('closedusers', ['uses' => 'AdminController@allClosedUsers', 'as' => 'closedusers']);
Route::get('suspendedusers', ['uses' => 'AdminController@allSuspendedUsers', 'as' => 'suspendedusers']);
Route::get('newusers', ['uses' => 'AdminController@allNewusers', 'as' => 'newusers']);
Route::get('newmerchants', ['uses' => 'AdminController@allNewMerchants', 'as' => 'newmerchants']);
Route::get('archiveduserslist', ['uses' => 'AdminController@archivedUsersList', 'as' => 'archiveduserslist']);
Route::get('/addtowatchlist/{id}', ['uses' => 'AdminController@addTowatchlist', 'as' => 'addtowatchlist']);
Route::get('/removefromwatchlist/{id}', ['uses' => 'AdminController@removeFromWatchList', 'as' => 'removefromwatchlist']);
Route::post('/datazooverify', ['uses' => 'AdminController@datazooVerify', 'as' => 'datazoo verify']);


Route::get('Admin/x-wireless', ['uses' => 'AdminController@smsWirelessPlatform', 'as' => 'sms wireless platform']);

// Get currency conversion rate
Route::get('Admin/getcurrencyrate', ['uses' => 'AdminController@getCurrencyRate', 'as' => 'getcurrencyrate']);

// Promote Business
Route::get('Admin/businesspromotion', ['uses' => 'AdminController@businessPromotion', 'as' => 'business promotion']);

Route::get('Admin/emailcampaign', ['uses' => 'AdminController@runEmailCampaign', 'as' => 'run mail campaign']);

//Admin deleting documents
Route::post('delete avatar', ['uses' => 'AdminController@deleteAvatar', 'as' => 'delete avatar']);
Route::post('delete govtid', ['uses' => 'AdminController@deleteGovtid', 'as' => 'delete govt id']);
Route::post('delete license', ['uses' => 'AdminController@deleteLicense', 'as' => 'delete license']);
Route::post('delete passport', ['uses' => 'AdminController@deletePassport', 'as' => 'delete passport']);
Route::post('delete document', ['uses' => 'AdminController@deleteIncopDocument', 'as' => 'delete incop document']);



Route::get('allusersbycountry', ['uses' => 'AdminController@allPlatformUsersByCountry', 'as' => 'all users by country']);


Route::get('approvedusersbycountry', ['uses' => 'AdminController@allApprovedUsersByCountry', 'as' => 'approved users by country']);
Route::get('upgradedconsumerbycountry', ['uses' => 'AdminController@allUpgradedConsumerByCountry', 'as' => 'upgraded consumers by country']);
Route::get('upgradedmerchantbycountry', ['uses' => 'AdminController@allUpgradedMerchantByCountry', 'as' => 'upgraded merchant by country']);
Route::get('merchantaccountbycountry', ['uses' => 'AdminController@merchantAccountModeByCountry', 'as' => 'merchant account mode by country']);
Route::get('merchantdetails', ['uses' => 'AdminController@merchantDetails', 'as' => 'merchant account details']);
Route::get('approvedpendingusersbycountry', ['uses' => 'AdminController@allApprovedPendingUsersByCountry', 'as' => 'approved pending users by country']);
Route::get('leveltwousersbycountry', ['uses' => 'AdminController@levelTwoUsersByCountry', 'as' => 'level two users by country']);
Route::get('matchedusersbycountry', ['uses' => 'AdminController@allMatchedUsersByCountry', 'as' => 'matched users by country']);
Route::get('pendingusersbycountry', ['uses' => 'AdminController@allPendingUsersByCountry', 'as' => 'pending users by country']);
Route::get('overrideusersbycountry', ['uses' => 'AdminController@allOverrideUsersByCountry', 'as' => 'override users by country']);
Route::get('psusersnotactivebycountry', ['uses' => 'AdminController@allPSUsersNotActiveByCountry', 'as' => 'ps not active by country']);
Route::get('closedusersbycountry', ['uses' => 'AdminController@allClosedUsersByCountry', 'as' => 'closed users by country']);
Route::get('suspendedusersbycountry', ['uses' => 'AdminController@allSuspendedUsersByCountry', 'as' => 'suspended users by country']);
Route::post('datazooverify', ['uses' => 'AdminController@datazooVerify', 'as' => 'datazoo verify']);

Route::get('newusersbycountry', ['uses' => 'AdminController@newUsersByCountry', 'as' => 'new users by country']);
Route::get('newmerchantsbycountry', ['uses' => 'AdminController@newMerchantsByCountry', 'as' => 'new merchants by country']);

Route::get('archivedusersbycountry', ['uses' => 'AdminController@archivedUsersByCountry', 'as' => 'archived users by country']);


Route::get('usermoredetail/{id}', ['uses' => 'AdminController@userMoreDetail', 'as' => 'user more detail']);
Route::get('closedusermoredetail/{id}', ['uses' => 'AdminController@closedUserMoreDetail', 'as' => 'closed user more detail']);


Route::prefix('Admin/wallet')->group(function () {

	Route::get('/', ['uses' => 'AdminController@walletBalance', 'as' => 'wallet balance']);
	Route::get('/user-statement', ['uses' => 'AdminController@userWalletStatement', 'as' => 'users wallet statement']);
	Route::get('/user-purchase-statement', ['uses' => 'AdminController@userWalletPurchaseStatement', 'as' => 'user purchase statement']);
	Route::get('/user-wallet-purchase', ['uses' => 'AdminController@userWalletPurchase', 'as' => 'users wallet purchase']);
	Route::get('bankrequestwithdrawal', ['uses' => 'AdminController@bankRequestWithdrawal', 'as' => 'bank request withdrawal']);
	Route::get('mobilemoneyrequestwithdrawal', ['uses' => 'AdminController@mobilemoneyRequestWithdrawal', 'as' => 'mobilemoney request withdrawal']);

	Route::get('merchantbankdetails', ['uses' => 'AdminController@merchantBanksDetails', 'as' => 'merchant banking details']);

	Route::get('merchantbankdetailsbycountry', ['uses' => 'AdminController@merchantBankDetailsByCountry', 'as' => 'merchant bank details by country']);

	Route::get('purchaserequestreturn', ['uses' => 'AdminController@purchaseRefundReturn', 'as' => 'purchase refund request']);

	Route::get('bankrequestwithdrawalbycountry', ['uses' => 'AdminController@bankRequestWithdrawalByCountry', 'as' => 'bank withdrawal by country']);

	Route::get('mobilemoneyrequestwithdrawalbycountry', ['uses' => 'AdminController@mobilemoneyRequestWithdrawalByCountry', 'as' => 'mobilemoney withdrawal by country']);
	Route::get('returnwithdrawal/{id}', ['uses' => 'AdminController@returnWithdrawal', 'as' => 'return withdrawal request']);
	Route::get('returnbankwithdrawal/{id}', ['uses' => 'AdminController@returnBankWithdrawal', 'as' => 'return bank withdrawal request']);
	Route::get('cardrequestwithdrawal', ['uses' => 'AdminController@cardRequestWithdrawal', 'as' => 'card request withdrawal']);



	Route::get('cardprocessedwithdrawal', ['uses' => 'AdminController@cardProcessedWithdrawal', 'as' => 'card processed withdrawal']);
	Route::get('bankprocessedwithdrawal', ['uses' => 'AdminController@bankProcessedWithdrawal', 'as' => 'bank processed withdrawal']);



	Route::get('cardrequestwithdrawalbycountry', ['uses' => 'AdminController@cardRequestWithdrawalByCountry', 'as' => 'card withdraw by country']);
	Route::get('cardrequestprocessedbycountry', ['uses' => 'AdminController@cardRequestProcessedByCountry', 'as' => 'card processed by country']);
	Route::get('bankrequestprocessedbycountry', ['uses' => 'AdminController@bankRequestProcessedByCountry', 'as' => 'bank processed by country']);

	Route::get('mobilemoneyrequestprocessedbycountry', ['uses' => 'AdminController@mobilemoneyRequestProcessedByCountry', 'as' => 'mobilemoney processed by country']);


	// Pending Transfers

	Route::get('texttotransfer', ['uses' => 'AdminController@pendingTransfer', 'as' => 'text to transfer']);

	Route::get('pendingtransfer', ['uses' => 'AdminController@textToTransfer', 'as' => 'pending transfer']);

	Route::get('texttotransferbycountry', ['uses' => 'AdminController@pendingTransferByCountry', 'as' => 'pending transfer by country']);
	Route::get('pendingtransferbycountry', ['uses' => 'AdminController@textToTransferByCountry', 'as' => 'text to transfer by country']);

	Route::get('prepaidrequestwithdrawal', ['uses' => 'AdminController@prepaidRequestWithdrawal', 'as' => 'prepaid request withdrawal']);
	Route::get('prepaidcardrequest', ['uses' => 'AdminController@prepaidCardRequest', 'as' => 'prepaid card request']);


	Route::get('refundmoneyrequest', ['uses' => 'AdminController@refundMoneyRequest', 'as' => 'refund money request']);
	Route::get('escrowfundinglist', ['uses' => 'AdminController@escrowFundingList', 'as' => 'escrow funding list']);
	Route::get('electronictransfer', ['uses' => 'AdminController@electronicTransferList', 'as' => 'electronic transfer']);
	Route::post('deletetransaction', ['uses' => 'MonerisController@deleteTransaction', 'as' => 'delete transaction']);
	Route::get('deletedtransaction', ['uses' => 'AdminController@deletedTransactions', 'as' => 'deleted transactions']);
	Route::post('restoretransaction', ['uses' => 'MonerisController@restoreTransaction', 'as' => 'restore transaction']);

	Route::post('confirmespay', ['uses' => 'AdminController@confirmEsPay', 'as' => 'confirm es pay']);

	Route::post('deleteespay', ['uses' => 'AdminController@deleteEsPay', 'as' => 'delete es pay']);

	Route::get('refundmoneyrequestbycountry', ['uses' => 'AdminController@refundMoneyRequestByCountry', 'as' => 'refund details by country']);
	Route::get('processedrefund', ['uses' => 'AdminController@processedRefundMoneyRequest', 'as' => 'refund processed']);

	Route::get('processedmobilemoney', ['uses' => 'AdminController@processedMobileMoneyRequest', 'as' => 'mobilemoney processed']);


	Route::get('bankrequestprocessed', ['uses' => 'AdminController@bankRequestProcessed', 'as' => 'processed payment']);
	Route::get('refunddetails/{transid}', ['uses' => 'AdminController@getRefundDetails', 'as' => 'refund details']);

	Route::post('returnrefundmoney/{reference_code}', ['uses' => 'AdminController@sendStaffRefundNotification', 'as' => 'return refund money']);

	Route::post('actonreturnrefundmoney/{reference_code}', ['uses' => 'AdminController@returnRefundMoney', 'as' => 'act on return refund money']);

	Route::get('balancebycountry', ['uses' => 'AdminController@balanceByCountry', 'as' => 'balance by country']);
	Route::get('maintenancefee', ['uses' => 'AdminController@maintenancefeeDetail', 'as' => 'maintenance fee detail']);
	Route::get('maintenancefeebycountry', ['uses' => 'AdminController@maintenancefeeByCountry', 'as' => 'maintenance fee by country']);


	Route::get('withdrawal', ['uses' => 'AdminController@merchantWithdrawal', 'as' => 'merchant withdrawal']);
	Route::get('addmoney', ['uses' => 'AdminController@merchantAddMoney', 'as' => 'merchant add money']);
	Route::get('sendmoney', ['uses' => 'AdminController@merchantSendMoney', 'as' => 'merchant send money']);


	Route::get('merchantpaymentgateway', ['uses' => 'AdminController@merchantPaymentGateway', 'as' => 'merchant payment gateway']);
	Route::get('new/payment/createuser', ['uses' => 'AdminController@createnewPayment', 'as' => 'create new merchant payment']);

	Route::get('payment/sendmoney/{user_id}', ['uses' => 'AdminController@paymentOrganization', 'as' => 'merchant sendmoney payment']);
});



Route::prefix('Admin/card')->group(function () {

	Route::get('issuer', ['uses' => 'AdminController@allCardIssuer', 'as' => 'card issuer']);
	Route::get('editcardissuer/{id}', ['uses' => 'AdminController@editCardIssuer', 'as' => 'editcardissuer']);

	Route::get('addedcards', ['uses' => 'AdminController@allAddedCards', 'as' => 'all added cards']);
	Route::get('deletedcards', ['uses' => 'AdminController@allDeletedCards', 'as' => 'all deleted cards']);
	Route::get('getusercard/{user_id}', ['uses' => 'AdminController@getUsersCard', 'as' => 'get user card']);
	Route::get('getuserdeletedcard/{user_id}', ['uses' => 'AdminController@getUsersDeletedCard', 'as' => 'get user deleted card']);
	Route::get('redflagged', ['uses' => 'AdminController@redFlaggedAccount', 'as' => 'red flagged account']);
	Route::get('redflaggedmoney', ['uses' => 'AdminController@redFlaggedMoney', 'as' => 'red flagged money']);


	Route::get('merchantcreditcard/{id}', ['uses' => 'AdminController@merchantCreditCard', 'as' => 'merchant credit card']);
	Route::get('editmerchantcreditcard/{id}', ['uses' => 'AdminController@editMerchantCreditCard', 'as' => 'Edit merchant credit card']);
	Route::get('merchantdebitcard/{id}', ['uses' => 'AdminController@merchantDebitCard', 'as' => 'merchant debit card']);
	Route::get('editmerchantdebitcard/{id}', ['uses' => 'AdminController@editMerchantDebitCard', 'as' => 'Edit merchant debit card']);
	Route::get('editmerchantprepaidcard/{id}', ['uses' => 'AdminController@editMerchantPrepaidCard', 'as' => 'Edit merchant prepaid card']);
	Route::get('merchantprepaidcard/{id}', ['uses' => 'AdminController@merchantPrepaidCard', 'as' => 'merchant prepaid card']);
	Route::get('merchantbankaccount/{id}', ['uses' => 'AdminController@merchantBankAccount', 'as' => 'merchant bank account']);
	Route::get('editmerchantbankaccount/{id}', ['uses' => 'AdminController@editMerchantBankAccount', 'as' => 'Edit merchant bank account']);
});


Route::prefix('Admin/invoice')->group(function () {

	Route::get('single', ['uses' => 'AdminController@createSingleInvoice', 'as' => 'create single invoice']);
	Route::get('single/link', ['uses' => 'AdminController@createLinkInvoice', 'as' => 'create link invoice']);

	Route::get('bulk', ['uses' => 'AdminController@createBulkInvoice', 'as' => 'create bulk invoice']);
});


Route::prefix('Admin/merchant')->group(function () {

	Route::get('profile', ['uses' => 'AdminController@merchantProfile', 'as' => 'merchant profile']);
});


Route::prefix('Admin/performance/report')->group(function () {

	Route::get('sentinvoice', ['uses' => 'AdminController@sentInvoiceReport', 'as' => 'sent invoice']);
	Route::get('sentinvoicebydate', ['uses' => 'AdminController@sentInvoiceReportByDate', 'as' => 'sent invoice by date']);



	Route::get('paidinvoice', ['uses' => 'AdminController@paidInvoiceReport', 'as' => 'paid invoice']);
	Route::get('paidinvoicebydate', ['uses' => 'AdminController@paidInvoiceReportByDate', 'as' => 'paid invoice by date']);



	Route::get('unpaidinvoice', ['uses' => 'AdminController@unpaidInvoiceReport', 'as' => 'unpaid invoice']);
	Route::get('unpaidinvoicebydate', ['uses' => 'AdminController@unpaidInvoiceReportByDate', 'as' => 'unpaid invoice by date']);


	Route::get('customerbalance', ['uses' => 'AdminController@customerBalanceReport', 'as' => 'customer balance report']);
	Route::get('customerbalancebydate', ['uses' => 'AdminController@customerBalanceReportByDate', 'as' => 'customer balance report by date']);


	Route::get('tax', ['uses' => 'AdminController@taxReport', 'as' => 'tax report']);
	Route::get('invoicetype', ['uses' => 'AdminController@invoiceTypeReport', 'as' => 'invoice type']);
	Route::get('recurring', ['uses' => 'AdminController@recurringReport', 'as' => 'recurring invoice']);
});

Route::prefix('Admin/overview/report')->group(function () {

	Route::get('business', ['uses' => 'AdminController@businessReport', 'as' => 'business report']);
	Route::get('revenue', ['uses' => 'AdminController@revenueReport', 'as' => 'revenue report']);
	Route::get('psfxreport', ['uses' => 'AdminController@paysprintFxReport', 'as' => 'paysprint fx report']);
	Route::get('fxreportbycountry', ['uses' => 'AdminController@paysprintFxReportByCountry', 'as' => 'fx report by country']);
	Route::get('accountreport', ['uses' => 'AdminController@accountReport', 'as' => 'account report']);
	Route::get('invoicecommission', ['uses' => 'AdminController@invoiceCommissionReport', 'as' => 'invoice commission']);
	Route::get('businessreport', ['uses' => 'AdminController@getBusinessReport', 'as' => 'get business report']);
	Route::get('revenuereport', ['uses' => 'AdminController@getRevenueReport', 'as' => 'get revenue report']);
	Route::get('inflow', ['uses' => 'AdminController@inflowReport', 'as' => 'inflow reports']);
	Route::get('inflowbycountry', ['uses' => 'AdminController@inflowByCountryReport', 'as' => 'inflow by country']);
	Route::post('getinflowrecord', ['uses' => 'AdminController@getInflowRecord', 'as' => 'get inflow record']);



	Route::get('withdrawal', ['uses' => 'AdminController@withdrawalReport', 'as' => 'withdrawal reports']);
	Route::get('withdrawalbycountry', ['uses' => 'AdminController@withdrawalByCountryReport', 'as' => 'withdrawal by country']);
	Route::post('getwithdrawalrecord', ['uses' => 'AdminController@getWithdrawalRecord', 'as' => 'get withdrawal record']);



	Route::get('charge', ['uses' => 'AdminController@chargeReport', 'as' => 'charge reports']);
	Route::get('expectedbalance', ['uses' => 'AdminController@expectedBalanceReport', 'as' => 'expected balance reports']);
	Route::get('actualbalance', ['uses' => 'AdminController@actualBalanceReport', 'as' => 'actual balance reports']);
	Route::get('reconsilation', ['uses' => 'AdminController@reconsilationReport', 'as' => 'reconsilation reports']);


	// Report Details
	Route::get('netamounttowallet', ['uses' => 'AdminController@netAmountToWallet', 'as' => 'net amount to wallet']);
	Route::get('netfxamounttowallet', ['uses' => 'AdminController@netFxAmountToWallet', 'as' => 'net fx amount to wallet']);
	Route::get('chargeonaddmoney', ['uses' => 'AdminController@chargeOnAddMoney', 'as' => 'charge on add money']);
	Route::get('amountwithdrawnfromwallet', ['uses' => 'AdminController@amountWithdrawnFromWallet', 'as' => 'amount withdrawn from wallet']);
	Route::get('chargesonwithdrawal', ['uses' => 'AdminController@chargesOnWithdrawals', 'as' => 'charges on withdrawal']);
	Route::get('walletmaintenancefee', ['uses' => 'AdminController@walletMaintenanceFee', 'as' => 'wallet maintenance fee']);
});

// Api documentation
Route::get('api/documentation', ['uses' => 'AdminController@apiDocumentation', 'as' => 'api integration']);
Route::get('earnedpoints', ['uses' => 'AdminController@earnedPoints', 'as' => 'earned points']);


Route::get('paysprintpointspage', ['uses' => 'HomeController@consumerPoints', 'as' => 'consumer points']);

Route::get('merchantreferralpage', ['uses' => 'HomeController@merchantReferral', 'as' => 'merchant referral']);


Route::prefix('Admin/')->group(function () {

	Route::get('invoicetypes', ['uses' => 'AdminController@createServiceTypes', 'as' => 'create service types']);
	Route::get('setuptax', ['uses' => 'AdminController@setupTax', 'as' => 'setup tax']);
	Route::get('edittax/{id}', ['uses' => 'AdminController@editTax', 'as' => 'edit tax']);

	Route::get('statement', ['uses' => 'AdminController@getStatement', 'as' => 'getStatement']);
	Route::get('statementreport', ['uses' => 'AdminController@getStatementReport', 'as' => 'statement report']);

	Route::get('walletstatement', ['uses' => 'AdminController@getWalletStatement', 'as' => 'getwalletStatement']);
	Route::get('walletstatementreport', ['uses' => 'AdminController@getWalletStatementReport', 'as' => 'wallet report']);
	Route::get('user-wallet-report', ['uses' => 'AdminController@getUserWalletStatementReport', 'as' => 'user wallet report']);
	Route::get('user-wallet-purchase-report', ['uses' => 'AdminController@getUserWalletPurchaseStatementReport', 'as' => 'user wallet purchase report']);

	Route::get('payreport', ['uses' => 'AdminController@payreport', 'as' => 'payreport']);
	Route::get('epayreport', ['uses' => 'AdminController@epayreport', 'as' => 'epayreport']);
	Route::get('payremittancereport', ['uses' => 'AdminController@payremittancereport', 'as' => 'payremittancereport']);
	Route::get('epayremittancereport', ['uses' => 'AdminController@epayremittancereport', 'as' => 'epayremittancereport']);
	Route::get('remittance', ['uses' => 'AdminController@remittance', 'as' => 'remittance']);
	Route::get('paycaremittance', ['uses' => 'AdminController@paycaremittance', 'as' => 'paycaremittance']);
	Route::get('remittancepaycareport', ['uses' => 'AdminController@remittancepaycareport', 'as' => 'remittancepaycareport']);
	Route::get('remittanceepayreport', ['uses' => 'AdminController@remittanceepayreport', 'as' => 'remittanceepayreport']);
	Route::get('clientfeereport', ['uses' => 'AdminController@clientfeereport', 'as' => 'clientfeereport']);
	Route::get('collectionfee', ['uses' => 'AdminController@collectionfee', 'as' => 'collectionfee']);
	Route::get('comissionreport', ['uses' => 'AdminController@comissionreport', 'as' => 'comissionreport']);

	Route::get('customer/{id}', ['uses' => 'AdminController@customer', 'as' => 'customer']);
	Route::get('linkcustomer/{id}', ['uses' => 'AdminController@linkCustomer', 'as' => 'link customer']);

	Route::get('invoicecomment/{id}', ['uses' => 'AdminController@invoiceComment', 'as' => 'invoice comment']);
	Route::post('myinvoicecomment/{id}', ['uses' => 'MonerisController@myInvoiceComment', 'as' => 'my invoice comment']);


	Route::get('invoicelinkcomment/{id}', ['uses' => 'AdminController@invoiceLinkComment', 'as' => 'invoice link comment']);
	Route::post('myinvoicelinkcomment/{id}', ['uses' => 'MonerisController@myInvoiceLinkComment', 'as' => 'my invoice link comment']);



	// Investors Relation
	Route::prefix('investor/')->group(function () {

		Route::get('newpost', ['uses' => 'AdminController@newInvestorPost', 'as' => 'new investors post']);
		Route::get('subscribers', ['uses' => 'AdminController@investorSubscriber', 'as' => 'new investor subscriber']);
		Route::get('investorposts', ['uses' => 'AdminController@investorPosts', 'as' => 'investorposts']);
		Route::post('createnews', ['uses' => 'AdminController@createInvestorNews', 'as' => 'create investor news']);
		Route::get('createpost', ['uses' => 'AdminController@createInvestorPost', 'as' => 'create investor post']);
		Route::get('createnews', ['uses' => 'AdminController@createInvestorNews', 'as' => 'create investor news']);
		Route::post('createpost', ['uses' => 'AdminController@createInvestorPosts', 'as' => 'create investor posts']);
		Route::get('editpost/{id}', ['uses' => 'AdminController@editInvestorPost', 'as' => 'edit investor post']);
		Route::post('editpost/{id}', ['uses' => 'AdminController@editInvestorPosts', 'as' => 'edit investor posts']);
		Route::post('deletepost/{id}', ['uses' => 'AdminController@deleteInvestorPost', 'as' => 'delete investor post']);
		Route::get('/investorsnews', ['uses' => 'AdminController@FetchInvestorNews', 'as' => 'investors news']);
		Route::get('editnews/{id}', ['uses' => 'AdminController@editInvestorNews', 'as' => 'edit investor news']);
		Route::post('updatenews/{id}', ['uses' => 'AdminController@updateInvestorNews', 'as' => 'update investor news']);
		Route::post('deletenews/{id}', ['uses' => 'AdminController@deleteInvestorNews', 'as' => 'delete investor news']);
	});




	//Routes for image upload

	Route::post('uploaduserdoc', ['uses' => 'ImageController@imageUploadPost', 'as' => 'upload user doc']);

	// Routes for claiming points

	Route::post('claimpoints', ['uses' => 'HomeController@claimedPoints', 'as' => 'claim point']);
	Route::post('claimreferralpoints', ['uses' => 'HomeController@claimedReferralPoints', 'as' => 'claim referral point']);

	Route::post('claimpointsadmin', ['uses' => 'AdminController@claimedPointsAdmin', 'as' => 'claim point admin']);

	Route::get('claimpointhistory', ['uses' => 'HomeController@claimedHistory', 'as' => 'claim history']);

	Route::get('claimpointhistoryadmin', ['uses' => 'HomeController@claimedHistoryAdmin', 'as' => 'claim history admin']);




	// KYB List

	Route::get('pendingkybbycountry', ['uses' => 'AdminController@pendingKybByCountry', 'as' => 'kyb pending by country']);

	Route::get('kybpending', ['uses' => 'AdminController@pendingKyb', 'as' => 'kybpending']);

	Route::get('completedkybbycountry', ['uses' => 'AdminController@completedKybByCountry', 'as' => 'kyb completed by country']);

	Route::get('kybcompleted', ['uses' => 'AdminController@completedKyb', 'as' => 'kybcompleted']);


	Route::get('industrycategorybycountry', ['uses' => 'AdminController@industryCategoryByCountry', 'as' => 'industry category by country']);
	Route::get('allpsmerchants', ['uses' => 'AdminController@allPsMerchants', 'as' => 'allpsmerchants']);
	Route::get('industrycategory', ['uses' => 'AdminController@industryCategory', 'as' => 'industrycategory']);






	Route::get('pricingsetup', ['uses' => 'AdminController@pricingSetup', 'as' => 'pricing setup']);
	Route::get('pricingsetupbycountry', ['uses' => 'AdminController@pricingSetupByCountry', 'as' => 'pricing setup by country']);

	Route::get('markupconversion', ['uses' => 'AdminController@markupCurrencyConversion', 'as' => 'markup conversion']);


	Route::post('savemarkup', ['uses' => 'AdminController@saveMarkup', 'as' => 'save markup']);

	Route::get('countrypricing', ['uses' => 'AdminController@countryPricing', 'as' => 'country pricing']);
	Route::get('editpricing', ['uses' => 'AdminController@editPricing', 'as' => 'edit pricing']);
	Route::post('createpricingsetup', ['uses' => 'AdminController@createPricingSetup', 'as' => 'create pricing setup']);


	Route::get('feestructure', ['uses' => 'AdminController@feeStructure', 'as' => 'fee structure']);
	Route::get('feestructurebycountry', ['uses' => 'AdminController@feeStructureByCountry', 'as' => 'fee structure by country']);
	Route::get('structurebycountry/{country}', ['uses' => 'AdminController@structureByCountry', 'as' => 'structure by country']);

	Route::get('xpaytrans', ['uses' => 'AdminController@xpaytrans', 'as' => 'xpaytrans']);

	Route::get('xreceivemoney', ['uses' => 'AdminController@xreceivemoney', 'as' => 'xreceivemoney']);

	Route::get('activity', ['uses' => 'AdminController@platformActivity', 'as' => 'platform activity']);
	Route::get('activity-report', ['uses' => 'AdminController@activityReport', 'as' => 'activity report']);
	Route::get('paysprintpoint', ['uses' => 'AdminController@paysprintPoint', 'as' => 'paysprint point']);
	Route::get('claimreward', ['uses' => 'AdminController@claimReward', 'as' => 'claim reward']);
	Route::get('walletdebit', ['uses' => 'AdminController@walletDebit', 'as' => 'wallet debit']);
	Route::post('submitwalletdebit', ['uses' => 'AdminController@submitWalletDebit', 'as' => 'submit wallet debit']);
	Route::get('cashadvancelist', ['uses' => 'AdminController@cashAdvanceList', 'as' => 'cash advance list']);
	Route::get('crossborderlist', ['uses' => 'AdminController@crossBorderList', 'as' => 'cross border list']);
	Route::get('viewbeneficiarydetail/{id}', ['uses' => 'AdminController@crossBorderBeneficiaryDetail', 'as' => 'view beneficiary detail']);

	Route::get('userspoint', ['uses' => 'AdminController@usersPoint', 'as' => 'users points']);



	Route::get('gatewayactivity', ['uses' => 'AdminController@gatewayActivity', 'as' => 'gateway activity']);
	Route::get('bvncheckdetails', ['uses' => 'AdminController@bvnCheckDetails', 'as' => 'bvncheckdetails']);
	Route::get('utilityandbills', ['uses' => 'AdminController@utilityAndBills', 'as' => 'utilityandbills']);
	Route::get('checktransaction/{id}', ['uses' => 'AdminController@checkTransaction', 'as' => 'check transaction']);
	Route::get('supportactivity', ['uses' => 'AdminController@supportPlatformActivity', 'as' => 'support activity']);
	Route::get('activityperday', ['uses' => 'AdminController@platformActivityPerDay', 'as' => 'activity per day']);

	Route::get('generatespecialinfoactivity', ['uses' => 'AdminController@generateSpecialInfoActivity', 'as' => 'generate special information activity']);


	// Create support agents
	Route::get('createusersupportagent', ['uses' => 'AdminController@createSupportAgent', 'as' => 'create user support agent']);
	Route::get('editusersupportagent/{id}', ['uses' => 'AdminController@editSupportAgent', 'as' => 'edit support agent']);
	Route::get('viewusersupportagent', ['uses' => 'AdminController@viewSupportAgent', 'as' => 'view user support agent']);
	Route::post('generateusersupportagent', ['uses' => 'AdminController@generateSupportAgent', 'as' => 'generate account for support']);
	Route::post('editthisusersupportagent', ['uses' => 'AdminController@editThisSupportAgent', 'as' => 'edit account for support']);
	Route::post('deletesupport/{id}', ['uses' => 'AdminController@deleteSupportAgent', 'as' => 'delete support agent']);
	Route::post('integrationaction/{id}', ['uses' => 'AdminController@integrationAction', 'as' => 'integration action']);


	// Create referrers
	Route::get('createreferrer', ['uses' => 'AdminController@createReferrerAgent', 'as' => 'create referrer agent']);
	Route::get('viewreferrer', ['uses' => 'AdminController@viewReferrerAgent', 'as' => 'view referrer agent']);
	Route::post('generatereferreragent', ['uses' => 'AdminController@generateReferrerAgent', 'as' => 'generate account for referrer']);
	Route::get('editreferreragent/{id}', ['uses' => 'AdminController@editReferrerAgent', 'as' => 'edit referrer agent']);
	Route::post('editthisreferreragent', ['uses' => 'AdminController@editThisReferrerAgent', 'as' => 'edit account for referrer']);
	Route::post('deletereferrer/{id}', ['uses' => 'AdminController@deleteReferrerAgent', 'as' => 'delete referrer agent']);



	Route::post('flagthismoney', ['uses' => 'AdminController@flagThisMoney', 'as' => 'flag this money']);


	Route::get('specialinfoactivity', ['uses' => 'AdminController@specialInfoActivity', 'as' => 'special information activity']);
	Route::get('editspecialinfoactivity/{id}', ['uses' => 'AdminController@editspecialInfoActivity', 'as' => 'edit special activity']);
	Route::post('createspecialinfoactivity', ['uses' => 'AdminController@createSpecialInfoActivity', 'as' => 'create special information']);
	Route::post('deletespecialactivity', ['uses' => 'AdminController@deleteSpecialInfoActivity', 'as' => 'delete special activity']);
	Route::get('allcountries', ['uses' => 'AdminController@allCountries', 'as' => 'all countries']);
	Route::get('countrypaymentgateway', ['uses' => 'AdminController@allCountriesPaymentGateway', 'as' => 'create payment gateway']);
	Route::get('countrybankinformation', ['uses' => 'AdminController@allCountriesBankInformation', 'as' => 'create bank information']);
	Route::post('countrypaymentgateway', ['uses' => 'AdminController@storeCountryPaymentGateway', 'as' => 'store payment gateway']);
	Route::post('editcountrypaymentgateway', ['uses' => 'AdminController@editCountryPaymentGateway', 'as' => 'edit payment gateway']);
	Route::post('deletecountrypaymentgateway', ['uses' => 'AdminController@deleteCountryPaymentGateway', 'as' => 'delete payment gateway']);
	Route::post('updatecountrygateway', ['uses' => 'AdminController@updateCountryGateway', 'as' => 'update country gateway']);

	Route::get('allpaiduserlist', ['uses' => 'AdminController@allPaidUserList', 'as' => 'all paid user list']);
	Route::get('allfreeuserlist', ['uses' => 'AdminController@allFreeUserList', 'as' => 'all free user list']);

	Route::get('sendmessage', ['uses' => 'AdminController@sendUserMessage', 'as' => 'send message']);
	Route::post('sendusermessage', ['uses' => 'AdminController@sendNewUserMessage', 'as' => 'send user message']);
	Route::post('runmailcampaign', ['uses' => 'AdminController@runMailChimpCampaign', 'as' => 'run mail campaign to users']);

	// Move Multiple Users
	Route::post('moveselectedusers', ['uses' => 'AdminController@ajaxmoveSelectedUser', 'as' => 'move selected users']);
});

Route::get('AdminLogin', ['uses' => 'AdminController@adminlogin', 'as' => 'AdminLogin']);
Route::get('AdminRegister', ['uses' => 'AdminController@adminregister', 'as' => 'AdminRegister']);
Route::get('otherpay', ['uses' => 'AdminController@Otherpay', 'as' => 'Otherpay']);
Route::get('editfee/{id}', ['uses' => 'AdminController@editFee', 'as' => 'editfee']);
Route::post('createfeestructure', ['uses' => 'AdminController@createFeeStructure', 'as' => 'create fee structure']);
Route::post('editfeestructure/{id}', ['uses' => 'AdminController@editFeeStructure', 'as' => 'edit fee structure']);
Route::post('deletefee/{id}', ['uses' => 'AdminController@deleteFee', 'as' => 'deletefee']);


Route::post('createcardissuer', ['uses' => 'AdminController@createCardIssuer', 'as' => 'create card issuer']);
Route::post('editcardissuer/{id}', ['uses' => 'AdminController@editThisCardIssuer', 'as' => 'edit card issuer']);
Route::post('deletecardissuer/{id}', ['uses' => 'AdminController@deleteCardIssuer', 'as' => 'deletecardissuer']);




Route::post('updateinvoice', ['uses' => 'AdminController@updateinvoice', 'as' => 'updateinvoice']);

Route::post('updateinvoicelink', ['uses' => 'AdminController@updateinvoicelink', 'as' => 'updateinvoicelink']);


Route::post('increasetranslimit', ['uses' => 'AdminController@increaseTransLimit', 'as' => 'increase trans limit']);
Route::post('increaseoverdraftlimit', ['uses' => 'AdminController@increaseOverdraftLimit', 'as' => 'increase overdraft limit']);




// Post Routes
Route::post('maintenancedelete', ['uses' => 'HomeController@maintenancedelete', 'as' => 'maintenancedelete']);
Route::post('updatemaintenance', ['uses' => 'HomeController@updatemaintenance', 'as' => 'updatemaintenance']);




// PASSWORD RESET FOR ADMIN
Route::get('reset/mypassword', ['uses' => 'PasswordResetController@index', 'as' => 'adminpasswordreset']);
Route::post('adminpasswordreset', ['uses' => 'PasswordResetController@adminpasswordreset', 'as' => 'mypasswordreset']);
Route::post('changepassword', ['uses' => 'PasswordResetController@changepassword', 'as' => 'changepassword']);
Route::get('reset/newpassword/{userid}', ['uses' => 'PasswordResetController@adminpasswordresetnew', 'as' => 'newpasswordreset']);



// Create consultan
Route::post('saveconsultant', ['uses' => 'ConsultantController@store', 'as' => 'saveconsultant']);
Route::post('assignconsultant', ['uses' => 'ConsultantController@assignConsultant', 'as' => 'assignconsultant']);
Route::post('generateInvoice', ['uses' => 'ConsultantController@generateInvoice', 'as' => 'generateInvoice']);
Route::post('generateQuote', ['uses' => 'ConsultantController@generateQuote', 'as' => 'generateQuote']);
Route::post('editconsultant', ['uses' => 'ConsultantController@editconsultant', 'as' => 'editconsultant']);
Route::post('consultantdelete', ['uses' => 'ConsultantController@consultantdelete', 'as' => 'consultantdelete']);
Route::post('completedworkorder', ['uses' => 'ConsultantController@completedworkorder', 'as' => 'completedworkorder']);




// Create Faciltiy

Route::post('create_facility', ['uses' => 'BuildingController@createFacility', 'as' => 'create_facility']);

Route::post('exporttoExcel', ['uses' => 'HomeController@exportToExcel', 'as' => 'export to excel']);
Route::post('exportstatementtoExcel', ['uses' => 'AdminController@exportStatementToExcel', 'as' => 'export statement to excel']);
Route::post('exporttoPdf', ['uses' => 'HomeController@exportToPdf', 'as' => 'export to pdf']);


//testng upload excel to DB skima
Route::get('/promopage', ['uses' => 'AdminController@promoPage', 'as' => 'promo page']);
Route::post('/uploadpromousers', ['uses' => 'AdminController@uploadPromoUsers', 'as' => 'upload promo users']);
Route::post('/uploadunverifiedmerchants', ['uses' => 'AdminController@uploadUnverifiedMerchants', 'as' => 'upload unverified merchants']);
Route::get('/promousers', ['uses' => 'AdminController@promoUsers', 'as' => 'promo users']);
Route::get('/promoreport', ['uses' => 'AdminController@promoReport', 'as' => 'promo report']);
Route::post('/topup', ['uses' => 'AdminController@topUpWallet', 'as' => 'top up']);
Route::post('/topupreferrralpoint', ['uses' => 'AdminController@topupReferralPoint', 'as' => 'topup referral point']);
Route::get('/viewreport', ['uses' => 'AdminController@viewReport', 'as' => 'view report']);
Route::get('/referralclaim', ['uses' => 'AdminController@referralClaim', 'as' => 'referral claim']);
Route::get('/referralreport', ['uses' => 'AdminController@referralReport', 'as' => 'referral report']);
Route::get('/viewreferralreport', ['uses' => 'AdminController@viewReferralReport', 'as' => 'view referral report']);
Route::get('/referraldetails', ['uses' => 'AdminController@viewReferralDetails', 'as' => 'view referral details']);
Route::post('/processreferralclaim', ['uses' => 'AdminController@processReferralClaim', 'as' => 'process referral claim']);
Route::post('/processpointclaim', ['uses' => 'AdminController@processPointClaim', 'as' => 'process point claim']);
Route::get('/successfulreferralclaim', ['uses' => 'AdminController@successfulReferralClaim', 'as' => 'successful referral claim']);
Route::get('/successfulpointclaim', ['uses' => 'AdminController@successfulPointClaim', 'as' => 'successful point claim']);
Route::post('/deleteclaim/{id}', ['uses' => 'AdminController@deleteClaim', 'as' => 'delete claim']);
Route::post('/restoreclaim/{id}', ['uses' => 'AdminController@restoreClaim', 'as' => 'restore claim']);
Route::get('/suspendedreferralclaim', ['uses' => 'AdminController@suspendedReferralClaim', 'as' => 'suspended referral claim']);

Route::get('/promodate', ['uses' => 'AdminController@promoDate', 'as' => 'promo date']);
Route::post('/promodate', ['uses' => 'AdminController@insertPromoDate', 'as' => 'insert promo date']);
Route::get('/editpromodate/{id}', ['uses' => 'AdminController@editPromoDate', 'as' => 'edit promo']);
Route::post('/updatepromodate{id}', ['uses' => 'AdminController@updatePromoDate', 'as' => 'update promo date']);
Route::get('/deletepromodate/{id}', ['uses' => 'AdminController@deletePromoDate', 'as' => 'delete promo']);
Route::get('/joinpromo/{id}', ['uses' => 'AdminController@joinPromo', 'as' => 'join promo']);
Route::get('/specialpromos', ['uses' => 'HomeController@specialPromo', 'as' => 'special promo']);
Route::get('/specialpromousers', ['uses' => 'AdminController@specialPromoUsers', 'as' => 'special promo users']);
Route::get('/promoparticipant/{id}', ['uses' => 'AdminController@promoParticipants', 'as' => 'promo participant']);
Route::get('/mobilemoneyproviders', ['uses' => 'DusupayController@mobileMoneyProviders', 'as' => 'mobile money providers']);




// Logout manually

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');


Auth::routes();


// AML Page Route
Route::prefix('Admin/aml')->group(function () {
	Route::get('/dashboard', ['uses' => 'AmlController@index', 'as' => 'aml dashboard']);
	Route::get('/activitylog', ['uses' => 'AmlController@activityLog', 'as' => 'aml activity log']);
	Route::get('/transactionreview', ['uses' => 'AmlController@transactionReview', 'as' => 'aml transaction review']);
	Route::get('refundmoneyrequestbycountry', ['uses' => 'AdminController@refundMoneyRequestByCountry', 'as' => 'refund details by country aml']);
	Route::get('/transactionanalysis', ['uses' => 'AmlController@transactionAnalysis', 'as' => 'aml transaction analysis']);
	Route::get('/transactionanalysissubpage', ['uses' => 'AmlController@transactionAnalysisSubPage', 'as' => 'aml transaction analysis subpage']);
	Route::get('/compliancedeskreview', ['uses' => 'AmlController@complianceDeskReview', 'as' => 'aml compliance desk review']);
	Route::get('/compliancedeskreviewsubpage', ['uses' => 'AmlController@complianceDeskReviewSubPage', 'as' => 'aml compliance desk review subpage']);
	Route::get('/reports', ['uses' => 'AmlController@reports', 'as' => 'aml reports']);
	Route::get('/creditcardholdreturn', ['uses' => 'AmlController@creditCardHoldReturn', 'as' => 'credit card hold return']);
	Route::get('/platform', ['uses' => 'AmlController@platForm', 'as' => 'platform']);
	Route::get('/customerservice', ['uses' => 'AmlController@customerService', 'as' => 'customer service']);
	Route::get('/viewdocument', ['uses' => 'AmlController@viewDocument', 'as' => 'viewdocument']);
	Route::get('/viewkyckybreport', ['uses' => 'AmlController@viewKycKybReport', 'as' => 'viewkyckybreport']);
	Route::get('/viewcomplianceinformation', ['uses' => 'AmlController@viewComplianceInformation', 'as' => 'viewcomplianceinformation']);
	Route::get('/viewindustry', ['uses' => 'AmlController@viewIndustry', 'as' => 'viewindustry']);
	Route::get('/linkedaccount', ['uses' => 'AmlController@linkedAccount', 'as' => 'linkedaccount']);
	Route::get('/connectedaccounts', ['uses' => 'AmlController@connectedAccounts', 'as' => 'connectedaccounts']);
	Route::get('/moneysent', ['uses' => 'AmlController@moneySent', 'as' => 'moneysent']);
	Route::get('/moneyreceived', ['uses' => 'AmlController@moneyReceived', 'as' => 'moneyreceived']);
	Route::get('/technology', ['uses' => 'AmlController@technology', 'as' => 'technology']);
	Route::post('/gettechnology', ['uses' => 'AmlController@gettechnology', 'as' => 'gettechnology']);
	Route::get('/bankrequestamlwithdrawalbycountry', ['uses' => 'AmlController@requestForWithdrawalToBank', 'as' => 'Request aml for Withdrawal to bank']);

	Route::get('/watchlist', ['uses' => 'AmlController@watchList', 'as' => 'watchlist']);
	Route::get('/getwatchlist', ['uses' => 'AmlController@getWatchList', 'as' => 'getwatchlist']);
	Route::get('/viewwatchlist', ['uses' => 'AmlController@viewWatchListActivity', 'as' => 'viewwatchlist']);
	Route::get('/view', ['uses' => 'AmlController@view', 'as' => 'View']);
	Route::get('/upload', ['uses' => 'AmlController@upload', 'as' => 'Upload']);
	Route::post('/uploads', ['uses' => 'AmlController@uploads', 'as' => 'Uploads']);
	Route::get('amlbvnactivity', ['uses' => 'AmlController@amlBvnActivity', 'as' => 'amlbvnactivity']);

	Route::get('/purchaserequestreturnaml', ['uses' => 'AmlController@purchaseRequestReturnAml', 'as' => 'Purchase aml Refund Request']);
	Route::get('refunddetail/{transid}', ['uses' => 'AmlController@getRefundDetailAml', 'as' => 'refund detail']);

	Route::get('/creditcardwithdrawalrequest', ['uses' => 'AmlController@creditCardWithdrawalRequest', 'as' => 'Credit Card withdrawal Request']);

	Route::get('/pendingtransferaml', ['uses' => 'AmlController@pendingTransfer', 'as' => 'Pending aml Transfer']);

	Route::get('/prepaidcardwithdrawalrequest', ['uses' => 'AmlController@prepaidCardWithdrawalRequest', 'as' => 'Prepaid Card withdrawal Request']);
	Route::get('/requestforremittancetoclient', ['uses' => 'AmlController@requestForRemittanceToClient', 'as' => 'Request for Remittance to Client']);
	Route::get('/requestforrefund', ['uses' => 'AmlController@requestRefund', 'as' => 'Request for Refund']);
	Route::get('/bankinginformation', ['uses' => 'AmlController@bankingInformation', 'as' => 'Banking Information']);
	Route::get('/topupredflagged', ['uses' => 'AmlController@topUpRedFlagged', 'as' => 'Top-Up Red Flagged']);
	Route::get('/compliance', ['uses' => 'AmlController@compliance', 'as' => 'Compliance']);
	Route::get('/suspicioustransaction', ['uses' => 'AmlController@suspiciousTransaction', 'as' => 'Suspicious Transaction']);
	Route::get('pendingtransferbycountryaml', ['uses' => 'AmlController@textsToTransferByCountry', 'as' => 'texts to transfer by country']);

	Route::get('bankrequestwithdrawalbycountry', ['uses' => 'AmlController@bankRequestWithdrawalByCountry', 'as' => 'bank aml withdrawal by country']);

	Route::get('bankrequestwithdrawal', ['uses' => 'AmlController@bankRequestWithdrawal', 'as' => 'bank aml request withdrawal']);

	Route::get('refundmoneyrequestbycountryaml', ['uses' => 'AmlController@refundMoneyRequestByCountryAml', 'as' => 'refund aml details by country']);

	Route::get('merchantbankdetail', ['uses' => 'AmlController@merchantBanksDetails', 'as' => 'aml merchant banking details']);

	Route::get('merchantbankdetailbycountry', ['uses' => 'AmlController@merchantBankDetailByCountryAml', 'as' => 'merchant bank detail by country']);


	Route::get('bankrequestwithdrawal', ['uses' => 'AmlController@merchantBanksDetailsAml', 'as' => 'merchant banking detail aml']);
	Route::get('activitylogaml', ['uses' => 'AmlController@activityLogAml', 'as' => 'log aml']);
	Route::get('purchaserefundrequest', ['uses' => 'AmlController@purchaseRefundRequest', 'as' => 'aml purchase refund request']);
});

//Estore Manager Route
Route::prefix('Admin/estore')->group(function () {
	Route::get('/dashboard', ['uses' => 'StoreController@index', 'as' => 'store dashboard']);
	Route::get('/reviewstore', ['uses' => 'StoreController@reviewStore', 'as' => 'review e-store']);
	Route::get('/suspendedstore', ['uses' => 'StoreController@suspendedStores', 'as' => 'suspended stores']);
	Route::get('/productscategory', ['uses' => 'StoreController@productsCategory', 'as' => 'products category']);
	Route::get('/feedback', ['uses' => 'StoreController@feedback', 'as' => 'feedback']);
	Route::get('/refundanddisputereport', ['uses' => 'StoreController@refundDisputeReport', 'as' => 'refund and dispute report']);
	Route::get('/expiredotp', ['uses' => 'StoreController@expiredOtp', 'as' => 'expired otp']);
	Route::get('/editstore/{id}', ['uses' => 'StoreController@editStore', 'as' => 'edit store']);
	Route::get('/images/{id}', ['uses' => 'StoreController@viewImages', 'as' => 'view images']);
	Route::get('/advertimages/{id}', ['uses' => 'StoreController@viewAdvertImages', 'as' => 'view advert images']);
	Route::post('/updatestore/{id}', ['uses' => 'StoreController@updateStore', 'as' => 'update store']);
	Route::post('/deletestore/{id}', ['uses' => 'StoreController@deleteStore', 'as' => 'delete store']);
	Route::post('/restorestore/{id}', ['uses' => 'StoreController@restoreStore', 'as' => 'restore store']);
	Route::get('/editcategory/{id}', ['uses' => 'StoreController@editCategory', 'as' => 'edit category']);
	Route::post('/updatecategory/{id}', ['uses' => 'StoreController@updateCategory', 'as' => 'update category']);
	Route::post('/deletecategory/{id}', ['uses' => 'StoreController@deleteCategory', 'as' => 'delete category']);
	Route::post('/updatestate/{id}', ['uses' => 'StoreController@updateState', 'as' => 'update state']);
	Route::post('/activate/{id}', ['uses' => 'StoreController@activateStore', 'as' => 'activate store']);
	Route::get('/activatestore', ['uses' => 'StoreController@activateEstore', 'as' => 'activate e-store']);
	Route::get('/unverifiedmerchants', ['uses' => 'StoreController@unverifiedMerchants', 'as' => 'unverified merchants']);
	Route::get('marketplace', ['uses' => 'StoreController@newMarketplacePost', 'as' => 'new marketplace post']);
	Route::post('createnews', ['uses' => 'AdminController@createMarketplaceNews', 'as' => 'create marketplace news']);
	Route::get('/marketplacenews', ['uses' => 'StoreController@FetchMarketplaceNews', 'as' => 'marketplacenews']);
	Route::get('editmarketplacenews/{id}', ['uses' => 'StoreController@editMarketplaceNews', 'as' => 'edit marketplace news']);
	Route::post('updatemarketplacenews/{id}', ['uses' => 'AdminController@updateMarketplaceNews', 'as' => 'update marketplace news']);
	Route::post('deletemarketplacenews/{id}', ['uses' => 'AdminController@deleteMarketplaceNews', 'as' => 'delete marketplace news']);
	Route::get('/estoreproducts', ['uses' => 'StoreController@estoreProducts', 'as' => 'estore products']);
	Route::get('/editestoreproducts/{id}', ['uses' => 'StoreController@editEstoreProducts', 'as' => 'edit estore product']);
	Route::post('/updateestoreproducts/{id}', ['uses' => 'StoreController@updateEstoreProducts', 'as' => 'update estore product']);
});





// Ajax Route
Route::group(['prefix' => 'Ajax'], function () {

	// User Registrations
	Route::post('Ajaxregister', ['uses' => 'HomeController@ajaxregister', 'as' => 'Ajaxregister']);
	Route::post('Ajaxlogin', ['uses' => 'HomeController@ajaxlogin', 'as' => 'Ajaxlogin']);
	Route::post('contactus', ['uses' => 'HomeController@contactus', 'as' => 'contactus']);



	// Logout
	// Route::get('logout', 'LoginController@logout');


	// Setup Billing
	Route::post('setupBills', ['uses' => 'HomeController@setupBills', 'as' => 'setupBills']);
	Route::post('checkmyBills', ['uses' => 'HomeController@checkmyBills', 'as' => 'checkmyBills']);
	Route::post('getmyInvoice', ['uses' => 'HomeController@getmyInvoice', 'as' => 'getmyInvoice']);
	Route::post('getPayment', ['uses' => 'HomeController@getPayment', 'as' => 'getPayment']);
	Route::post('getmystatement', ['uses' => 'HomeController@getmystatement', 'as' => 'getmystatement']);

	Route::post('getOrganization', ['uses' => 'HomeController@getOrganization', 'as' => 'getOrganization']);

	// Check IDV Information
	Route::post('checkIdvPassInfo', ['uses' => 'IdvController@checkIdvPassInfo', 'as' => 'checkIdvPassInfo']);



	Route::post('PaymentInvoice', ['uses' => 'MonerisController@purchase', 'as' => 'PaymentInvoice']);
	// Route::post('orgPaymentInvoice', ['uses' => 'MonerisController@orgPaymentInvoice', 'as' => 'orgPaymentInvoice']);
	Route::post('orgPaymentInvoice', ['uses' => 'GooglePaymentController@orgPaymentInvoice', 'as' => 'orgPaymentInvoice']);
	Route::post('receivemoneyProcess', ['uses' => 'MonerisController@receivemoneyProcess', 'as' => 'receivemoneyProcess']);

	// External Source
	Route::post('loginApi', ['uses' => 'HomeController@loginApi', 'as' => 'loginApi']);

	// Create Event Ajax
	Route::post('Adminlogin', ['uses' => 'AdminController@ajaxadminlogin', 'as' => 'AjaxAdminlogin']);
	Route::post('Adminspeciallogin', ['uses' => 'AdminController@ajaxAdminspeciallogin', 'as' => 'AjaxAdminspeciallogin']);
	Route::post('Adminlogout', ['uses' => 'AdminController@ajaxadminLogout', 'as' => 'AjaxAdminlogout']);
	Route::post('Adminregister', ['uses' => 'AdminController@ajaxadminregister', 'as' => 'AjaxAdminRegister']);
	Route::post('claimmerchantbusiness', ['uses' => 'AdminController@ajaxclaimbusiness', 'as' => 'AjaxClaimBusinesss']);
	Route::post('declineclaimbusiness', ['uses' => 'AdminController@declineclaimbusiness', 'as' => 'DeclineClaimBusinesss']);
	Route::post('CreateEvent', ['uses' => 'AdminController@ajaxcreateEvent', 'as' => 'AjaxCreateEvent']);
	Route::post('WithdrawCash', ['uses' => 'AdminController@ajaxWithdrawCash', 'as' => 'AjaxWithdrawCash']);
	Route::post('getmyStatement', ['uses' => 'AdminController@ajaxgetmyStatement', 'as' => 'AjaxgetmyStatement']);
	Route::post('getmyreportStatement', ['uses' => 'AdminController@ajaxgetmyreportStatement', 'as' => 'AjaxgetmyreportStatement']);
	Route::post('getBronchure', ['uses' => 'HomeController@ajaxgetBronchure', 'as' => 'AjaxgetBronchure']);



	Route::post('epaywithdraw', ['uses' => 'AdminController@ajaxepaywithdraw', 'as' => 'Ajaxepaywithdraw']);
	Route::post('remitCash', ['uses' => 'AdminController@ajaxremitCash', 'as' => 'AjaxremitCash']);
	Route::post('remitdetailsCash', ['uses' => 'AdminController@ajaxremitdetailsCash', 'as' => 'AjaxremitdetailsCash']);

	Route::post('getmremittance', ['uses' => 'AdminController@ajaxgetmremittance', 'as' => 'Ajaxgetmremittance']);

	Route::post('setupTrans', ['uses' => 'AdminController@ajaxsetupTrans', 'as' => 'AjaxsetupTrans']);
	Route::post('checkfeeReport', ['uses' => 'AdminController@ajaxcheckfeeReport', 'as' => 'AjaxcheckfeeReport']);
	Route::post('invoiceVisit', ['uses' => 'AdminController@ajaxinvoiceVisit', 'as' => 'AjaxinvoiceVisit']);

	Route::post('invoicelinkVisit', ['uses' => 'AdminController@ajaxinvoicelinkVisit', 'as' => 'AjaxinvoicelinkVisit']);

	Route::post('confirmpayment', ['uses' => 'AdminController@ajaxconfirmpayment', 'as' => 'Ajaxconfirmpayment']);


	Route::post('openuseraccount', ['uses' => 'AdminController@ajaxOpenUserAccount', 'as' => 'Ajaxopenuseraccount']);
	Route::post('closeuseraccount', ['uses' => 'AdminController@ajaxCloseUserAccount', 'as' => 'Ajaxcloseuseraccount']);
	Route::post('approveUser', ['uses' => 'AdminController@ajaxapproveUser', 'as' => 'AjaxapproveUser']);
	Route::post('disapproveUser', ['uses' => 'AdminController@ajaxdisapproveUser', 'as' => 'AjaxdisapproveUser']);
	Route::post('downgradeaccount', ['uses' => 'AdminController@ajaxdowngradeaccount', 'as' => 'Ajaxdowngradeaccount']);


	Route::post('paychargeback', ['uses' => 'MonerisController@paymentChargeBack', 'as' => 'Ajaxpaychargeback']);
	Route::post('releasefeeback', ['uses' => 'MonerisController@paymentReleaseFeeBack', 'as' => 'Ajaxreleasefeeback']);


	Route::post('moveUser', ['uses' => 'AdminController@ajaxmoveUser', 'as' => 'AjaxmoveUser']);


	Route::post('checkverification', ['uses' => 'AdminController@ajaxCheckVerification', 'as' => 'Ajaxcheckverification']);

	Route::post('paybankwithdrawal', ['uses' => 'AdminController@ajaxpayBankWithdrawal', 'as' => 'Ajaxpaybankwithdrawal']);

	Route::post('paymobilemoneywithdrawal/{id}', ['uses' => 'AdminController@ajaxpayMobileMoneyWithdrawal', 'as' => 'Ajaxpaymobilemoneywithdrawal']);

	Route::post('paycardwithdrawal', ['uses' => 'AdminController@ajaxpayCardWithdrawal', 'as' => 'Ajaxpaycardwithdrawal']);
	Route::post('flagguser', ['uses' => 'AdminController@ajaxflagUser', 'as' => 'Ajaxflagguser']);

	Route::post('singleinvoiceusercheck', ['uses' => 'AdminController@ajaxSingleInvoiceUserCheck', 'as' => 'Ajaxsingleinvoiceusercheck']);
	Route::post('refundmoneybacktowallet', ['uses' => 'AdminController@ajaxRefundMoneyBackToWallet', 'as' => 'Ajaxrefundmoneybacktowallet']);
	Route::post('accesstousepaysprint', ['uses' => 'AdminController@ajaxAccessToUsePaysprint', 'as' => 'grant country']);
	Route::post('accesstousepaysprintimt', ['uses' => 'AdminController@ajaxAccessToUsePaysprintImt', 'as' => 'grant imt']);
	Route::post('activatemerchantaccount', ['uses' => 'AdminController@activatemerchantaccount', 'as' => 'active merchant account']);


	Route::post('quotedecision', ['uses' => 'ConsultantController@ajaxquotedecision', 'as' => 'Ajaxquotedecision']);
	Route::post('quotedecisionmaker', ['uses' => 'ConsultantController@ajaxquotedecisionmaker', 'as' => 'Ajaxquotedecisionmaker']);
	Route::post('negotiatequote', ['uses' => 'ConsultantController@ajaxnegotiatequote', 'as' => 'negotiatequote']);
	Route::post('respondquote', ['uses' => 'ConsultantController@ajaxrespondquote', 'as' => 'respondquote']);



	Route::post('createMaintenance', ['uses' => 'HomeController@ajaxcreateMaintenance', 'as' => 'AjaxcreateMaintenance']);

	Route::post('getFacility', ['uses' => 'HomeController@ajaxgetFacility', 'as' => 'AjaxgetFacility']);
	Route::post('getbuildingaddress', ['uses' => 'HomeController@ajaxgetbuildingaddress', 'as' => 'Ajaxgetbuildingaddress']);


	Route::post('notifyupdate', ['uses' => 'HomeController@ajaxnotifyupdate', 'as' => 'Ajaxnotifyupdate']);

	Route::post('promotionaction', ['uses' => 'AdminController@ajaxpromotionaction', 'as' => 'Ajaxpromotionaction']);

	Route::post('acceptcrossborderpayment', ['uses' => 'AdminController@ajaxacceptcrossborderpayment', 'as' => 'Ajaxacceptcrossborderpayment']);
	// bulk payment
     Route::post('makebulkpayment', ['uses' => 'HomeController@ajaxMakeBulkPayment', 'as' => 'Ajaxmakebulkpayment']);

	// Get Commision and payment
	Route::post('getCommission', ['uses' => 'HomeController@ajaxgetCommission', 'as' => 'AjaxgetCommission']);
	Route::post('getlinkCommission', ['uses' => 'HomeController@ajaxgetlinkCommission', 'as' => 'AjaxgetlinkCommission']);
	Route::post('getwalletBalance', ['uses' => 'HomeController@ajaxgetwalletBalance', 'as' => 'AjaxgetwalletBalance']);

	Route::post('charges', ['uses' => 'ApplePayController@ajaxcharges', 'as' => 'charges']);

	Route::post('getconversion', ['uses' => 'CurrencyConverterApiController@currencyConverter', 'as' => 'getconversion']);
	Route::post('getfxconversion', ['uses' => 'CurrencyConverterApiController@currencyFxConverter', 'as' => 'getfxconversion']);
	Route::post('getmyfxwallet', ['uses' => 'CurrencyFxController@getMyFxWallet', 'as' => 'getmyfxwallet']);
});



// Exbc Route
Route::group(['prefix' => 'Exbc'], function () {
	Route::post('index', ['uses' => 'ExbcController@index', 'as' => 'index']);
});
