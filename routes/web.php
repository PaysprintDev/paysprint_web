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

// Major Routes

Route::get('/', ['uses' => 'HomeController@index', 'as' => 'home']);

Route::get('about', ['uses' => 'HomeController@about', 'as' => 'about']);

Route::get('Invoice', ['uses' => 'HomeController@invoice', 'as' => 'invoice']);

Route::get('Statement', ['uses' => 'HomeController@statement', 'as' => 'statement']);

Route::get('payorganization', ['uses' => 'HomeController@payOrganization', 'as' => 'payorganization']);

Route::get('contact', ['uses' => 'HomeController@contact', 'as' => 'contact']);

Route::get('Service', ['uses' => 'HomeController@service', 'as' => 'service']);

Route::get('Ticket', ['uses' => 'HomeController@ticket', 'as' => 'ticket']);


Route::get('profile', ['uses' => 'HomeController@profile', 'as' => 'profile']);


Route::get('payment/{invoice}', ['uses' => 'HomeController@payment', 'as' => 'payment']);

Route::get('payment/sendmoney/{user_id}', ['uses' => 'HomeController@paymentOrganization', 'as' => 'sendmoney payment']);
Route::get('payment/receivemoney/{id}', ['uses' => 'HomeController@receiveMoney', 'as' => 'receivemoney payment']);




// General Rental Management PAGE
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


// Client Admin ROute
Route::get('Admin', ['uses' => 'AdminController@index', 'as' => 'Admin']);

Route::get('allusers', ['uses' => 'AdminController@allPlatformUsers', 'as' => 'allusers']);


Route::get('AdminLogin', ['uses' => 'AdminController@adminlogin', 'as' => 'AdminLogin']);
Route::get('AdminRegister', ['uses' => 'AdminController@adminregister', 'as' => 'AdminRegister']);
Route::get('otherpay', ['uses' => 'AdminController@Otherpay', 'as' => 'Otherpay']);
Route::get('Admin/statement', ['uses' => 'AdminController@getStatement', 'as' => 'getStatement']);
Route::get('Admin/payreport', ['uses' => 'AdminController@payreport', 'as' => 'payreport']);
Route::get('Admin/epayreport', ['uses' => 'AdminController@epayreport', 'as' => 'epayreport']);
Route::get('Admin/payremittancereport', ['uses' => 'AdminController@payremittancereport', 'as' => 'payremittancereport']);
Route::get('Admin/epayremittancereport', ['uses' => 'AdminController@epayremittancereport', 'as' => 'epayremittancereport']);
Route::get('Admin/remittance', ['uses' => 'AdminController@remittance', 'as' => 'remittance']);
Route::get('Admin/paycaremittance', ['uses' => 'AdminController@paycaremittance', 'as' => 'paycaremittance']);
Route::get('Admin/remittancepaycareport', ['uses' => 'AdminController@remittancepaycareport', 'as' => 'remittancepaycareport']);
Route::get('Admin/remittanceepayreport', ['uses' => 'AdminController@remittanceepayreport', 'as' => 'remittanceepayreport']);
Route::get('Admin/clientfeereport', ['uses' => 'AdminController@clientfeereport', 'as' => 'clientfeereport']);
Route::get('Admin/collectionfee', ['uses' => 'AdminController@collectionfee', 'as' => 'collectionfee']);
Route::get('Admin/comissionreport', ['uses' => 'AdminController@comissionreport', 'as' => 'comissionreport']);

Route::get('Admin/customer/{id}', ['uses' => 'AdminController@customer', 'as' => 'customer']);


Route::get('Admin/xpaytrans', ['uses' => 'AdminController@xpaytrans', 'as' => 'xpaytrans']);

Route::get('Admin/xreceivemoney', ['uses' => 'AdminController@xreceivemoney', 'as' => 'xreceivemoney']);


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

Route::post('approveUser', ['uses' => 'AdminController@ajaxapproveUser', 'as' => 'AjaxapproveUser']);


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

Route::post('charges', ['uses' => 'ApplePayController@ajaxcharges', 'as' => 'charges']);

Route::post('getconversion', ['uses' => 'CurrencyConverterApiController@currencyConvert', 'as' => 'getconversion']);

});



// Exbc Route
Route::group(['prefix' => 'Exbc'], function() {
	Route::post('index', ['uses' => 'ExbcController@index', 'as' => 'index']);
});
