<?php

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

// App Logger
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::get('feecharge', 'MaintenanceFeeCharge@monthlyMaintenaceFee');

Route::get('quicksetup', 'CheckSetupController@updateQuickSetup');
Route::get('autodepositoff', 'CheckSetupController@autoDepositOff');
Route::get('accountactivity', 'CheckSetupController@checkAccountAcvtivity');
Route::get('updatestatementcountry', 'CheckSetupController@statementCountry');
Route::get('chargefee', 'CheckSetupController@chargeFee');
Route::get('insertcountry', 'CheckSetupController@insertCountry');
Route::get('reportstatus', 'CheckSetupController@reportStatus');
Route::get('updatefee', 'CheckSetupController@updateMonthlyFee');
Route::get('refundbycountryupdate', 'CheckSetupController@refundbyCountry');
Route::get('passwordreminder', 'CheckSetupController@passwordReminder');
Route::get('epsvendorupdate', 'CheckSetupController@updateEPSVendor');
Route::get('notification-table', 'CheckSetupController@notificationTable');
Route::get('monthlytransaction', 'CheckSetupController@monthlyTransactionHistory');
Route::get('exbccardrequest', 'CheckSetupController@checkExbcCardRequest');
Route::get('migratetolevelone', 'CheckSetupController@migrateUsersToLevelOne');
Route::get('insertspecialinfoactivity', 'CheckSetupController@insertspecialinfoActivity');
Route::get('autofeestructure', 'CheckSetupController@setupFeeStructure');
Route::get('checktelephone', 'CheckSetupController@checkTelephone');

Route::get('merchantinvoiceupdate', 'WorkorderController@controlInvoice');

Route::get('/run-queue', function() {

    Artisan::call('queue:work');
    return "Queue work done!";
    
});

Route::get('/clear', function() {

    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "Package Cleared!";
    
});

// Major Routes

Route::get('/', ['uses' => 'HomeController@homePage', 'as' => 'home']);

Route::get('/merchant-home', ['uses' => 'HomeController@merchantIndex', 'as' => 'merchant home']);

Route::get('/home', ['uses' => 'HomeController@authIndex', 'as' => 'user home']);

Route::get('about', ['uses' => 'HomeController@about', 'as' => 'about']);

Route::get('Invoice', ['uses' => 'HomeController@invoice', 'as' => 'invoice']);

Route::get('Statement', ['uses' => 'HomeController@statement', 'as' => 'statement']);

Route::get('payorganization', ['uses' => 'HomeController@payOrganization', 'as' => 'payorganization']);

Route::get('contact', ['uses' => 'HomeController@contact', 'as' => 'contact']);

Route::get('Service', ['uses' => 'HomeController@service', 'as' => 'service']);

Route::get('Ticket', ['uses' => 'HomeController@ticket', 'as' => 'ticket']);


Route::get('profile', ['uses' => 'HomeController@profile', 'as' => 'profile']);

// Terms or USE
Route::get('terms-of-service', ['uses' => 'HomeController@termsOfUse', 'as' => 'terms of use']);

// Pricing
Route::get('pricing', ['uses' => 'HomeController@feeStructure', 'as' => 'pricing structure']);

// Privacy Policy
Route::get('privacy-policy', ['uses' => 'HomeController@privacyPolicy', 'as' => 'privacy policy']);


Route::get('payment/{invoice}', ['uses' => 'HomeController@payment', 'as' => 'payment']);

Route::get('payment/sendmoney/{user_id}', ['uses' => 'HomeController@paymentOrganization', 'as' => 'sendmoney payment']);
Route::get('new/payment/createuser', ['uses' => 'HomeController@createnewPayment', 'as' => 'create new payment']);
Route::get('payment/receivemoney/{id}', ['uses' => 'HomeController@receiveMoney', 'as' => 'receivemoney payment']);



// Stripe Route
Route::post('create-payment-intent', ['uses' => 'MonerisController@paymentIntent', 'as' => 'stripe payment intent']);



// Wallet Page

Route::prefix('mywallet')->group(function () {

	Route::get('/', ['uses' => 'HomeController@myAccount', 'as' => 'my account']);
	Route::get('card', ['uses' => 'HomeController@addCard', 'as' => 'Add card']);
	Route::get('exbccard', ['uses' => 'HomeController@requestExbcCard', 'as' => 'request exbc card']);
	Route::get('editcard/{id}', ['uses' => 'HomeController@editCard', 'as' => 'Edit card']);
	Route::get('editbank/{id}', ['uses' => 'HomeController@editBank', 'as' => 'Edit bank']);
	Route::get('addmoney', ['uses' => 'HomeController@addMoney', 'as' => 'Add Money']);
	Route::get('withdrawmoney', ['uses' => 'HomeController@withdrawMoney', 'as' => 'Withdraw Money']);
	Route::get('addbank', ['uses' => 'HomeController@addBankDetail', 'as' => 'Add bank detail']);
	Route::get('requestrefund', ['uses' => 'HomeController@requestForRefund', 'as' => 'request for refund']);
	Route::get('notifications', ['uses' => 'HomeController@allNotifications', 'as' => 'notifications']);
	Route::get('paymentgateway', ['uses' => 'HomeController@paymentGateway', 'as' => 'payment gateway']);
	
});

Route::get('merchantcategory', ['uses' => 'HomeController@merchantCategory', 'as' => 'merchant category']);
Route::get('allmerchantcategory', ['uses' => 'HomeController@allMerchantCategory', 'as' => 'all merchant']);
Route::get('payutilitybills', ['uses' => 'HomeController@expressUtilities', 'as' => 'utility bills']);
Route::get('buyutilitybills/{id}', ['uses' => 'HomeController@expressBuyUtilities', 'as' => 'buy utility bills']);

Route::get('signout/{id}',  ['uses' => 'api\v1\UserController@logout'])->name('sign out');



 



// General Rental Management PAGE
Route::get('rentalmanagement-start', ['uses' => 'HomeController@rentalManagementStart', 'as' => 'rentalmanagement start']);

Route::get('rentalmanagement', ['uses' => 'HomeController@rentalManagement', 'as' => 'rentalmanagement']);

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
Route::get('matchedusers', ['uses' => 'AdminController@allMatchedUsers', 'as' => 'matchedusers']);
Route::get('leveltwousers', ['uses' => 'AdminController@allLevelTwoUsers', 'as' => 'leveltwousers']);
Route::get('pendingusers', ['uses' => 'AdminController@allPendingUsers', 'as' => 'pendingusers']);
Route::get('overrideusers', ['uses' => 'AdminController@allOverrideUsers', 'as' => 'overrideusers']);
Route::get('closedusers', ['uses' => 'AdminController@allClosedUsers', 'as' => 'closedusers']);
Route::get('newusers', ['uses' => 'AdminController@allNewusers', 'as' => 'newusers']);
Route::get('newmerchants', ['uses' => 'AdminController@allNewMerchants', 'as' => 'newmerchants']);




Route::get('allusersbycountry', ['uses' => 'AdminController@allPlatformUsersByCountry', 'as' => 'all users by country']);


Route::get('approvedusersbycountry', ['uses' => 'AdminController@allApprovedUsersByCountry', 'as' => 'approved users by country']);
Route::get('leveltwousersbycountry', ['uses' => 'AdminController@levelTwoUsersByCountry', 'as' => 'level two users by country']);
Route::get('matchedusersbycountry', ['uses' => 'AdminController@allMatchedUsersByCountry', 'as' => 'matched users by country']);
Route::get('pendingusersbycountry', ['uses' => 'AdminController@allPendingUsersByCountry', 'as' => 'pending users by country']);
Route::get('overrideusersbycountry', ['uses' => 'AdminController@allOverrideUsersByCountry', 'as' => 'override users by country']);
Route::get('closedusersbycountry', ['uses' => 'AdminController@allClosedUsersByCountry', 'as' => 'closed users by country']);


Route::get('newusersbycountry', ['uses' => 'AdminController@newUsersByCountry', 'as' => 'new users by country']);
Route::get('newmerchantsbycountry', ['uses' => 'AdminController@newMerchantsByCountry', 'as' => 'new merchants by country']);


Route::get('usermoredetail/{id}', ['uses' => 'AdminController@userMoreDetail', 'as' => 'user more detail']);
Route::get('closedusermoredetail/{id}', ['uses' => 'AdminController@closedUserMoreDetail', 'as' => 'closed user more detail']);


Route::prefix('Admin/wallet')->group(function () {

	Route::get('/', ['uses' => 'AdminController@walletBalance', 'as' => 'wallet balance']);
	Route::get('/user-statement', ['uses' => 'AdminController@userWalletStatement', 'as' => 'users wallet statement']);
	Route::get('bankrequestwithdrawal', ['uses' => 'AdminController@bankRequestWithdrawal', 'as' => 'bank request withdrawal']);
	Route::get('bankrequestwithdrawalbycountry', ['uses' => 'AdminController@bankRequestWithdrawalByCountry', 'as' => 'bank withdrawal by country']);
	Route::get('returnwithdrawal/{id}', ['uses' => 'AdminController@returnWithdrawal', 'as' => 'return withdrawal request']);
	Route::get('cardrequestwithdrawal', ['uses' => 'AdminController@cardRequestWithdrawal', 'as' => 'card request withdrawal']);



	Route::get('cardprocessedwithdrawal', ['uses' => 'AdminController@cardProcessedWithdrawal', 'as' => 'card processed withdrawal']);
	Route::get('bankprocessedwithdrawal', ['uses' => 'AdminController@bankProcessedWithdrawal', 'as' => 'bank processed withdrawal']);



	Route::get('cardrequestwithdrawalbycountry', ['uses' => 'AdminController@cardRequestWithdrawalByCountry', 'as' => 'card withdraw by country']);
	Route::get('cardrequestprocessedbycountry', ['uses' => 'AdminController@cardRequestProcessedByCountry', 'as' => 'card processed by country']);
	Route::get('bankrequestprocessedbycountry', ['uses' => 'AdminController@bankRequestProcessedByCountry', 'as' => 'bank processed by country']);


	// Pending Transfers

	Route::get('texttotransfer', ['uses' => 'AdminController@pendingTransfer', 'as' => 'text to transfer']);

	Route::get('pendingtransfer', ['uses' => 'AdminController@textToTransfer', 'as' => 'pending transfer']);

	Route::get('texttotransferbycountry', ['uses' => 'AdminController@pendingTransferByCountry', 'as' => 'pending transfer by country']);
	Route::get('pendingtransferbycountry', ['uses' => 'AdminController@textToTransferByCountry', 'as' => 'text to transfer by country']);

	Route::get('prepaidrequestwithdrawal', ['uses' => 'AdminController@prepaidRequestWithdrawal', 'as' => 'prepaid request withdrawal']);
	Route::get('prepaidcardrequest', ['uses' => 'AdminController@prepaidCardRequest', 'as' => 'prepaid card request']);


	Route::get('refundmoneyrequest', ['uses' => 'AdminController@refundMoneyRequest', 'as' => 'refund money request']);
	Route::get('refundmoneyrequestbycountry', ['uses' => 'AdminController@refundMoneyRequestByCountry', 'as' => 'refund details by country']);
	Route::get('processedrefund', ['uses' => 'AdminController@processedRefundMoneyRequest', 'as' => 'refund processed']);


	Route::get('bankrequestprocessed', ['uses' => 'AdminController@bankRequestProcessed', 'as' => 'processed payment']);
	Route::get('refunddetails/{transid}', ['uses' => 'AdminController@getRefundDetails', 'as' => 'refund details']);

	Route::post('returnrefundmoney/{reference_code}', ['uses' => 'AdminController@returnRefundMoney', 'as' => 'return refund money']);

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
	Route::get('accountreport', ['uses' => 'AdminController@accountReport', 'as' => 'account report']);
	Route::get('businessreport', ['uses' => 'AdminController@getBusinessReport', 'as' => 'get business report']);
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
	Route::get('chargeonaddmoney', ['uses' => 'AdminController@chargeOnAddMoney', 'as' => 'charge on add money']);
	Route::get('amountwithdrawnfromwallet', ['uses' => 'AdminController@amountWithdrawnFromWallet', 'as' => 'amount withdrawn from wallet']);
	Route::get('chargesonwithdrawal', ['uses' => 'AdminController@chargesOnWithdrawals', 'as' => 'charges on withdrawal']);
	Route::get('walletmaintenancefee', ['uses' => 'AdminController@walletMaintenanceFee', 'as' => 'wallet maintenance fee']);
	
});


Route::prefix('Admin/')->group(function () {

	Route::get('invoicetypes', ['uses' => 'AdminController@createServiceTypes', 'as' => 'create service types']);
	Route::get('setuptax', ['uses' => 'AdminController@setupTax', 'as' => 'setup tax']);
	Route::get('edittax/{id}', ['uses' => 'AdminController@editTax', 'as' => 'edit tax']);
	Route::get('api-documentation', ['uses' => 'AdminController@apiDocumentation', 'as' => 'api integration']);

	Route::get('statement', ['uses' => 'AdminController@getStatement', 'as' => 'getStatement']);
	Route::get('statementreport', ['uses' => 'AdminController@getStatementReport', 'as' => 'statement report']);

	Route::get('walletstatement', ['uses' => 'AdminController@getWalletStatement', 'as' => 'getwalletStatement']);
	Route::get('walletstatementreport', ['uses' => 'AdminController@getWalletStatementReport', 'as' => 'wallet report']);
	Route::get('user-wallet-report', ['uses' => 'AdminController@getUserWalletStatementReport', 'as' => 'user wallet report']);

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





	Route::get('pricingsetup', ['uses' => 'AdminController@pricingSetup', 'as' => 'pricing setup']);
	Route::get('pricingsetupbycountry', ['uses' => 'AdminController@pricingSetupByCountry', 'as' => 'pricing setup by country']);
	Route::get('countrypricing', ['uses' => 'AdminController@countryPricing', 'as' => 'country pricing']);
	Route::get('editpricing', ['uses' => 'AdminController@editPricing', 'as' => 'edit pricing']);
	Route::post('createpricingsetup', ['uses' => 'AdminController@createPricingSetup', 'as' => 'create pricing setup']);


	Route::get('feestructure', ['uses' => 'AdminController@feeStructure', 'as' => 'fee structure']);
	Route::get('feestructurebycountry', ['uses' => 'AdminController@feeStructureByCountry', 'as' => 'fee structure by country']);
	Route::get('structurebycountry/{country}', ['uses' => 'AdminController@structureByCountry', 'as' => 'structure by country']);

	Route::get('xpaytrans', ['uses' => 'AdminController@xpaytrans', 'as' => 'xpaytrans']);

	Route::get('xreceivemoney', ['uses' => 'AdminController@xreceivemoney', 'as' => 'xreceivemoney']);

	Route::get('activity', ['uses' => 'AdminController@platformActivity', 'as' => 'platform activity']);

	Route::get('gatewayactivity', ['uses' => 'AdminController@gatewayActivity', 'as' => 'gateway activity']);
	Route::get('checktransaction/{id}', ['uses' => 'AdminController@checkTransaction', 'as' => 'check transaction']);
	Route::get('supportactivity', ['uses' => 'AdminController@supportPlatformActivity', 'as' => 'support activity']);

	Route::get('generatespecialinfoactivity', ['uses' => 'AdminController@generateSpecialInfoActivity', 'as' => 'generate special information activity']);

	Route::get('createusersupportagent', ['uses' => 'AdminController@createSupportAgent', 'as' => 'create user support agent']);
	Route::get('editusersupportagent/{id}', ['uses' => 'AdminController@editSupportAgent', 'as' => 'edit support agent']);
	Route::get('viewusersupportagent', ['uses' => 'AdminController@viewSupportAgent', 'as' => 'view user support agent']);
	Route::post('generateusersupportagent', ['uses' => 'AdminController@generateSupportAgent', 'as' => 'generate account for support']);
	Route::post('editthisusersupportagent', ['uses' => 'AdminController@editThisSupportAgent', 'as' => 'edit account for support']);
	Route::post('deletesupport/{id}', ['uses' => 'AdminController@deleteSupportAgent', 'as' => 'delete support agent']);



	Route::post('flagthismoney', ['uses' => 'AdminController@flagThisMoney', 'as' => 'flag this money']);


	Route::get('specialinfoactivity', ['uses' => 'AdminController@specialInfoActivity', 'as' => 'special information activity']);
	Route::get('editspecialinfoactivity/{id}', ['uses' => 'AdminController@editspecialInfoActivity', 'as' => 'edit special activity']);
	Route::post('createspecialinfoactivity', ['uses' => 'AdminController@createSpecialInfoActivity', 'as' => 'create special information']);
	Route::post('deletespecialactivity', ['uses' => 'AdminController@deleteSpecialInfoActivity', 'as' => 'delete special activity']);
	Route::get('allcountries', ['uses' => 'AdminController@allCountries', 'as' => 'all countries']);


	Route::get('sendmessage', ['uses' => 'AdminController@sendUserMessage', 'as' => 'send message']);
	Route::post('sendusermessage', ['uses' => 'AdminController@sendNewUserMessage', 'as' => 'send user message']);
	
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
Route::post('exporttoPdf', ['uses' => 'HomeController@exportToPdf', 'as' => 'export to pdf']);





Auth::routes();

// Ajax Route
Route::group(['prefix' => 'Ajax'], function(){

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
Route::post('confirmpayment', ['uses' => 'AdminController@ajaxconfirmpayment', 'as' => 'Ajaxconfirmpayment']);


Route::post('openuseraccount', ['uses' => 'AdminController@ajaxOpenUserAccount', 'as' => 'Ajaxopenuseraccount']);
Route::post('closeuseraccount', ['uses' => 'AdminController@ajaxCloseUserAccount', 'as' => 'Ajaxcloseuseraccount']);
Route::post('approveUser', ['uses' => 'AdminController@ajaxapproveUser', 'as' => 'AjaxapproveUser']);
Route::post('disapproveUser', ['uses' => 'AdminController@ajaxdisapproveUser', 'as' => 'AjaxdisapproveUser']);
Route::post('downgradeaccount', ['uses' => 'AdminController@ajaxdowngradeaccount', 'as' => 'Ajaxdowngradeaccount']);


Route::post('paychargeback', ['uses' => 'MonerisController@paymentChargeBack', 'as' => 'Ajaxpaychargeback']);


Route::post('moveUser', ['uses' => 'AdminController@ajaxmoveUser', 'as' => 'AjaxmoveUser']);
Route::post('checkverification', ['uses' => 'AdminController@ajaxCheckVerification', 'as' => 'Ajaxcheckverification']);
Route::post('paybankwithdrawal', ['uses' => 'AdminController@ajaxpayBankWithdrawal', 'as' => 'Ajaxpaybankwithdrawal']);
Route::post('paycardwithdrawal', ['uses' => 'AdminController@ajaxpayCardWithdrawal', 'as' => 'Ajaxpaycardwithdrawal']);
Route::post('flagguser', ['uses' => 'AdminController@ajaxflagUser', 'as' => 'Ajaxflagguser']);

Route::post('singleinvoiceusercheck', ['uses' => 'AdminController@ajaxSingleInvoiceUserCheck', 'as' => 'Ajaxsingleinvoiceusercheck']);
Route::post('refundmoneybacktowallet', ['uses' => 'AdminController@ajaxRefundMoneyBackToWallet', 'as' => 'Ajaxrefundmoneybacktowallet']);
Route::post('accesstousepaysprint', ['uses' => 'AdminController@ajaxAccessToUsePaysprint', 'as' => 'grant country']);


Route::post('quotedecision', ['uses' => 'ConsultantController@ajaxquotedecision', 'as' => 'Ajaxquotedecision']);
Route::post('quotedecisionmaker', ['uses' => 'ConsultantController@ajaxquotedecisionmaker', 'as' => 'Ajaxquotedecisionmaker']);
Route::post('negotiatequote', ['uses' => 'ConsultantController@ajaxnegotiatequote', 'as' => 'negotiatequote']);
Route::post('respondquote', ['uses' => 'ConsultantController@ajaxrespondquote', 'as' => 'respondquote']);



Route::post('createMaintenance', ['uses' => 'HomeController@ajaxcreateMaintenance', 'as' => 'AjaxcreateMaintenance']);

Route::post('getFacility', ['uses' => 'HomeController@ajaxgetFacility', 'as' => 'AjaxgetFacility']);
Route::post('getbuildingaddress', ['uses' => 'HomeController@ajaxgetbuildingaddress', 'as' => 'Ajaxgetbuildingaddress']);


Route::post('notifyupdate', ['uses' => 'HomeController@ajaxnotifyupdate', 'as' => 'Ajaxnotifyupdate']);


// Get Commision and payment
Route::post('getCommission', ['uses' => 'HomeController@ajaxgetCommission', 'as' => 'AjaxgetCommission']);
Route::post('getwalletBalance', ['uses' => 'HomeController@ajaxgetwalletBalance', 'as' => 'AjaxgetwalletBalance']);

Route::post('charges', ['uses' => 'ApplePayController@ajaxcharges', 'as' => 'charges']);

Route::post('getconversion', ['uses' => 'CurrencyConverterApiController@currencyConverter', 'as' => 'getconversion']);

});



// Exbc Route
Route::group(['prefix' => 'Exbc'], function() {
	Route::post('index', ['uses' => 'ExbcController@index', 'as' => 'index']);
});
