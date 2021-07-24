<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Log;

use App\Mail\sendEmail;
use App\User as User;
use App\AddCard as AddCard;
use App\AddBank as AddBank;
use App\Statement as Statement;
use App\FeeTransaction as FeeTransaction;
use App\AllCountries as AllCountries;
use App\TransactionCost as TransactionCost;
use App\RequestRefund as RequestRefund;


use App\Traits\ExpressPayment;
use App\Traits\AccountNotify;

class CheckSetupController extends Controller
{

    public $name;
    public $email;
    public $subject;
    public $message;

    use ExpressPayment;
    use AccountNotify;
    // Check user quick wallet setup

    public function updateQuickSetup(){
        // Get User
        $user = User::where('disableAccount', 'off')->inRandomOrder()->get();

        try {
            
            foreach($user as $key => $value){

                $info = $this->accountInfo($value->id);

                if($value->approval == 0){
                    $approval = "<li>Upload a copy of Government Issued Photo ID</li>";
                }
                else{
                    $approval = "";
                }

                
                if($value->transaction_pin == null){
                    $transaction = "<li>Set Up Transaction Pin-You will need the PIN to Send Money, Pay Invoice/Bill or Withdraw Money from Your PaySprint Account</li>";
                }
                else{
                    $transaction = "";
                }
                if($value->securityQuestion == null){
                    $security = "<li>Set up Security Question and Answer-You will need this to reset your PIN code or Login Password</li>";
                }
                else{
                    $security = "";
                }
                if($value->country == "Nigeria" && $value->bvn_verification == null){
                    $bankVerify = "<li>Verify your account with your bank verification number</li>";
                }
                else{
                    $bankVerify = "";
                }
                if($info == 0){
                    $card = "<li>Add Credit Card/Prepaid Card/Bank Account-You need this to add money to your PaySprint Wallet.</li>";
                }
                else{
                    $card = "";
                }

                // Send Mail

                if($value->approval == 0 || $value->transaction_pin == null || $value->securityQuestion == null || $info == 0){

                    $this->name = $value->name;
                    $this->email = $value->email;
                    $this->subject = "You have some incomplete information on your PaySprint account";

                    $this->message = '<p>We noticed you are yet to properly complete the set-up your PaySprint Account. You need to provide the outstanding information and complete the quick set up in order to enjoy the full benefits of a PaySprint Account.</p><p><ul>'.$approval.''.$transaction.''.$security.''.$bankVerify.''.$card.'</ul></p><p>Kindly complete these important steps in your profile. <a href='.route('profile').' class="text-primary" style="text-decoration: underline">Click here to login to your account</a></p>';


                    $this->sendEmail($this->email, "Incomplete Setup");

                    Log::info('Quick wallet set up cron sent to '.$this->name);


                    echo "Sent to ".$this->name."<hr>";
                }

                

            }

        } catch (\Throwable $th) {
            Log::critical('Cannot send quick setup mail '.$th->getMessage());
        }


    }

    public function accountInfo($id){

        $getCard = AddCard::where('user_id', $id)->first();

        if(isset($getCard) == false){
            // Check Bank
            $getBank = AddBank::where('user_id', $id)->first();

            if(isset($getBank) == false){
                $data = 0;
            }
            else{
                // Do nothing
                $data = 1;
            }
        }
        else{
            // Do nothing
            $data = 1;
        }


        return $data;

    }


    public function autoDepositOff(){
        $user = User::where('auto_deposit', 'off')->where('disableAccount', 'off')->inRandomOrder()->get();

        if(count($user) > 0){
            // Send mail
            foreach($user as $key => $value){
                $this->name = $value->name;
                $this->email = $value->email;
                $this->subject = "Your Auto Deposit status is OFF on PaySprint.";

                $this->message = '<p>The Auto Deposit feature on PaySprint is turned OFF. You will need to manually accept all transfers made to your PaySprint wallet. If you want to enjoy a stress-free transaction deposit, you may have visit your profile on PaySprint Account to turn ON the feature. <br><br> Thanks, PaySprint Team</p>';

                $this->sendEmail($this->email, "Incomplete Setup");

                Log::info('Auto Deposit Status cron sent to '.$this->name);

                echo "Sent to ".$this->name."<hr>";
            }
        }
        else{
            // Do nothing
        }
    }


    public function checkAccountAcvtivity(){
        $user = User::where('lastLogin', '!=', null)->where('disableAccount', 'off')->inRandomOrder()->get();

        if(count($user) > 0){

            $date2 = date('Y-m-d');

            foreach($user as $key => $value){
                $lastLogin = date('Y-m-d', strtotime($value->lastLogin));

                $date1 = $lastLogin;

                $ts1 = strtotime($date1);
                $ts2 = strtotime($date2);

                $year1 = date('Y', $ts1);
                $year2 = date('Y', $ts2);

                $month1 = date('m', $ts1);
                $month2 = date('m', $ts2);

                $diff = (($year2 - $year1) * 12) + ($month2 - $month1);


                if($diff == 1){

                    $this->name = $value->name;
                    $this->email = $value->email;
                    $this->subject = "We missed you on PaySprint!";

                    $this->message = '<p>You have been away for a while on PaySprint. Your last activity was recorded on <b>'.date($value->lastLogin).'</b>. <br><br> We hope to see you soon. <br><br> Thanks, PaySprint Team</p>';


                    Log::info('We missed you on PaySprint: '.$this->name.'. Been away for '.$diff.' Last login was '.date($value->lastLogin));

                    $this->sendEmail($this->email, "Incomplete Setup");
                }
                elseif($diff == 2){
                    $this->name = $value->name;
                    $this->email = $value->email;
                    $this->subject = "We missed you on PaySprint!";

                    $this->message = '<p>We noticed you have been away for about '.$diff.' months. Your last activity was recorded on <b>'.$value->lastLogin.'</b>. <br><br> Your PaySprint Account would be disabled if there are no activity in the next days. The qualifying activities include, Add and send money, Pay invoice or withdraw money from your PaySprint Account. <br><br> We hope to see you soon. <br><br> Thanks, PaySprint Team</p>';


                    Log::info('We missed you on PaySprint: '.$this->name.'. Been away for '.$diff.' Last login was '.$value->lastLogin);

                    $this->sendEmail($this->email, "Incomplete Setup");
                }
                elseif($diff == 3){

                    User::where('email', $value->email)->update(['disableAccount' => 'on']);

                    $this->name = $value->name;
                    $this->email = $value->email;
                    $this->subject = "Your account has been inactive on PaySprint for ".$diff." months!";

                    $this->message = '<p>Your last activity was recorded on <b>'.$value->lastLogin.'</b>. <br><br> Your account is now suspended due to inactive use. Kindly contact the admin using contact us form, providing Account number and your name for your account to be activated. <br><br> Thanks, PaySprint Team</p>';

                    Log::info('We missed you on PaySprint: '.$this->name.'. Been away for '.$diff.' Last login was '.$value->lastLogin.' and account is disabled');

                    $this->sendEmail($this->email, "Incomplete Setup");
                }
                else{
                    // Do nothing
                }


            }

            echo "Mail Sent";

        }
        else{
            // Do nothing
        }
    }


    public function statementCountry(){
        $query = User::where('disableAccount', 'off')->orderBy('created_at', 'DESC')->get();

        if(count($query) > 0){
            foreach($query as $value => $key){
                $country = $key->country;
                $email = $key->email;

                // Update Statememt country
                Statement::where('user_id', $email)->update(['country' => $country]);
            }

        }
        else{
            // Do nothing
        }
    }


    // Update charge fee
    public function chargeFee(){
        $query = FeeTransaction::orderBy('created_at', 'DESC')->get();

        if(count($query) > 0){
            foreach($query as $value => $key){
                $transaction_id = $key->transaction_id;
                $fee = $key->fee;

                // Update Statememt chargefee
                Statement::where('reference_code', $transaction_id)->update(['chargefee' => $fee]);

                // Log::info("Update charge fee: ".$fee);
            }

        }
        else{
            // Do nothing
        }

    }


    public function updateMonthlyFee(Request $req){

        $getUser = User::where('created_at', '<=', '2021-04-30')->where('disableAccount', 'off')->inRandomOrder()->get();

        foreach($getUser as $key => $value){

                
                $getTranscost = TransactionCost::where('structure', 'Wallet Maintenance fee')->where('country', $value->country)->first();

                if(isset($getTranscost)){



                    $walletBalance = $value->wallet_balance - $getTranscost->fixed;

                    // Send Mail
                    $transaction_id = "wallet-".date('dmY').time();

                    $activity = "Monthly maintenance fee of CAD5.00 for April/2021 was deducted from Wallet";
                    $credit = 0;
                    $debit = number_format($getTranscost->fixed, 2);
                    $reference_code = $transaction_id;
                    $balance = 0;
                    $trans_date = date('Y-m-d');
                    $status = "Delivered";
                    $action = "Wallet debit";
                    $regards = $value->ref_code;
                    $statement_route = "wallet";


                    $sendMsg = 'Hello '.strtoupper($value->name).', '.$activity.'. You now have '.$value->currencyCode.' '.number_format($walletBalance, 2).' balance in your account';
                    $sendPhone = "+".$value->code.$value->telephone;


                    // Senders statement
                    $this->maintinsStatement($value->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route);

                    $this->createNotification($value->ref_code, "Hello ".strtoupper($value->name).", ".$sendMsg);

                    $this->name = $value->name;
                    $this->email = $value->email;
                    $this->subject = $activity;

                    $this->message = '<p>'.$activity.'</p><p>You now have <strong>'.$value->currencyCode.' '.number_format($walletBalance, 2).'</strong> balance in your account</p>';


                    Log::info($sendMsg);

                    // $this->sendMessage($sendMsg, $sendPhone);

                    // $this->sendEmail($this->email, "Fund remittance");

                    // $this->monthlyChargeInsert($value->ref_code, $value->country, $getTranscost->fixed, $value->currencyCode);


                    echo "Sent to ".$this->name."<hr>";

                }
                else{
                    // Log::info($value->name." was not charged because they are in ".$value->country." and the fee charge is not yet available");
                }
            

            
        }

    }

    public function maintinsStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $statement_route){
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'statement_route' => $statement_route]);
    }


    // Update Statement Report Satus
    public function reportStatus(){

        Statement::where('activity', 'LIKE', '%Payment on%')->where('debit', '>', 0)->update(['report_status' => 'Money sent']);
        Statement::where('activity', 'LIKE', '%Payment for%')->where('debit', '>', 0)->update(['report_status' => 'Money sent']);

        Statement::where('activity', 'LIKE', '%Payment to%')->where('debit', '!=', 0)->update(['report_status' => 'Money sent']);

        Statement::where('activity', 'LIKE', '%transfer of%')->where('debit', '>', 0)->update(['report_status' => 'Money sent']);
        Statement::where('activity', 'LIKE', '%Debited%')->where('debit', '>', 0)->update(['report_status' => 'Money sent']);
        Statement::where('activity', 'LIKE', '%Refund reversal of%')->where('debit', '>', 0)->update(['report_status' => 'Money sent']);


        Statement::where('activity', 'LIKE', '%Monthly maintenance %')->where('debit', '>', 0)->update(['report_status' => 'Monthly fee']);


        Statement::where('activity', 'LIKE', '%Added%')->where('credit', '>', 0)->update(['report_status' => 'Added to wallet']);

        Statement::where('activity', 'LIKE', '%withdraw%')->where('debit', '>', 0)->update(['report_status' => 'Withdraw from wallet']);


        Statement::where('activity', 'LIKE', '%Received Payment for%')->update(['report_status' => 'Money received']);

        Statement::where('activity', 'LIKE', '%Received%')->where('credit', '>', 0)->update(['report_status' => 'Money received']);
        Statement::where('activity', 'LIKE', '%Refund of %')->where('credit', '>', 0)->update(['report_status' => 'Money received']);

        
        // Log::info("Report Schedule Status Completed on ".date('d/M/Y h:i:a'));
    }


    public function insertCountry(){
        $country = '[{"name": "Afghanistan", "code": "AF"},
        {"name": "Åland Islands", "code": "AX"},
        {"name": "Albania", "code": "AL"},
        {"name": "Algeria", "code": "DZ"},
        {"name": "American Samoa", "code": "AS"},
        {"name": "AndorrA", "code": "AD"},
        {"name": "Angola", "code": "AO"},
        {"name": "Anguilla", "code": "AI"},
        {"name": "Antarctica", "code": "AQ"},
        {"name": "Antigua and Barbuda", "code": "AG"},
        {"name": "Argentina", "code": "AR"},
        {"name": "Armenia", "code": "AM"},
        {"name": "Aruba", "code": "AW"},
        {"name": "Australia", "code": "AU"},
        {"name": "Austria", "code": "AT"},
        {"name": "Azerbaijan", "code": "AZ"},
        {"name": "Bahamas", "code": "BS"},
        {"name": "Bahrain", "code": "BH"},
        {"name": "Bangladesh", "code": "BD"},
        {"name": "Barbados", "code": "BB"},
        {"name": "Belarus", "code": "BY"},
        {"name": "Belgium", "code": "BE"},
        {"name": "Belize", "code": "BZ"},
        {"name": "Benin", "code": "BJ"},
        {"name": "Bermuda", "code": "BM"},
        {"name": "Bhutan", "code": "BT"},
        {"name": "Bolivia", "code": "BO"},
        {"name": "Bosnia and Herzegovina", "code": "BA"},
        {"name": "Botswana", "code": "BW"},
        {"name": "Bouvet Island", "code": "BV"},
        {"name": "Brazil", "code": "BR"},
        {"name": "British Indian Ocean Territory", "code": "IO"},
        {"name": "Brunei Darussalam", "code": "BN"},
        {"name": "Bulgaria", "code": "BG"},
        {"name": "Burkina Faso", "code": "BF"},
        {"name": "Burundi", "code": "BI"},
        {"name": "Cambodia", "code": "KH"},
        {"name": "Cameroon", "code": "CM"},
        {"name": "Canada", "code": "CA"},
        {"name": "Cape Verde", "code": "CV"},
        {"name": "Cayman Islands", "code": "KY"},
        {"name": "Central African Republic", "code": "CF"},
        {"name": "Chad", "code": "TD"},
        {"name": "Chile", "code": "CL"},
        {"name": "China", "code": "CN"},
        {"name": "Christmas Island", "code": "CX"},
        {"name": "Cocos (Keeling) Islands", "code": "CC"},
        {"name": "Colombia", "code": "CO"},
        {"name": "Comoros", "code": "KM"},
        {"name": "Congo", "code": "CG"},
        {"name": "Congo, The Democratic Republic of the", "code": "CD"},
        {"name": "Cook Islands", "code": "CK"},
        {"name": "Costa Rica", "code": "CR"},
        {"name": "Cote D\'Ivoire", "code": "CI"},
        {"name": "Croatia", "code": "HR"},
        {"name": "Cuba", "code": "CU"},
        {"name": "Cyprus", "code": "CY"},
        {"name": "Czech Republic", "code": "CZ"},
        {"name": "Denmark", "code": "DK"},
        {"name": "Djibouti", "code": "DJ"},
        {"name": "Dominica", "code": "DM"},
        {"name": "Dominican Republic", "code": "DO"},
        {"name": "Ecuador", "code": "EC"},
        {"name": "Egypt", "code": "EG"},
        {"name": "El Salvador", "code": "SV"},
        {"name": "Equatorial Guinea", "code": "GQ"},
        {"name": "Eritrea", "code": "ER"},
        {"name": "Estonia", "code": "EE"},
        {"name": "Ethiopia", "code": "ET"},
        {"name": "Falkland Islands (Malvinas)", "code": "FK"},
        {"name": "Faroe Islands", "code": "FO"},
        {"name": "Fiji", "code": "FJ"},
        {"name": "Finland", "code": "FI"},
        {"name": "France", "code": "FR"},
        {"name": "French Guiana", "code": "GF"},
        {"name": "French Polynesia", "code": "PF"},
        {"name": "French Southern Territories", "code": "TF"},
        {"name": "Gabon", "code": "GA"},
        {"name": "Gambia", "code": "GM"},
        {"name": "Georgia", "code": "GE"},
        {"name": "Germany", "code": "DE"},
        {"name": "Ghana", "code": "GH"},
        {"name": "Gibraltar", "code": "GI"},
        {"name": "Greece", "code": "GR"},
        {"name": "Greenland", "code": "GL"},
        {"name": "Grenada", "code": "GD"},
        {"name": "Guadeloupe", "code": "GP"},
        {"name": "Guam", "code": "GU"},
        {"name": "Guatemala", "code": "GT"},
        {"name": "Guernsey", "code": "GG"},
        {"name": "Guinea", "code": "GN"},
        {"name": "Guinea-Bissau", "code": "GW"},
        {"name": "Guyana", "code": "GY"},
        {"name": "Haiti", "code": "HT"},
        {"name": "Heard Island and Mcdonald Islands", "code": "HM"},
        {"name": "Holy See (Vatican City State)", "code": "VA"},
        {"name": "Honduras", "code": "HN"},
        {"name": "Hong Kong", "code": "HK"},
        {"name": "Hungary", "code": "HU"},
        {"name": "Iceland", "code": "IS"},
        {"name": "India", "code": "IN"},
        {"name": "Indonesia", "code": "ID"},
        {"name": "Iran, Islamic Republic Of", "code": "IR"},
        {"name": "Iraq", "code": "IQ"},
        {"name": "Ireland", "code": "IE"},
        {"name": "Isle of Man", "code": "IM"},
        {"name": "Israel", "code": "IL"},
        {"name": "Italy", "code": "IT"},
        {"name": "Jamaica", "code": "JM"},
        {"name": "Japan", "code": "JP"},
        {"name": "Jersey", "code": "JE"},
        {"name": "Jordan", "code": "JO"},
        {"name": "Kazakhstan", "code": "KZ"},
        {"name": "Kenya", "code": "KE"},
        {"name": "Kiribati", "code": "KI"},
        {"name": "Korea, Democratic People\'S Republic of", "code": "KP"},
        {"name": "Korea, Republic of", "code": "KR"},
        {"name": "Kuwait", "code": "KW"},
        {"name": "Kyrgyzstan", "code": "KG"},
        {"name": "Lao People\'S Democratic Republic", "code": "LA"},
        {"name": "Latvia", "code": "LV"},
        {"name": "Lebanon", "code": "LB"},
        {"name": "Lesotho", "code": "LS"},
        {"name": "Liberia", "code": "LR"},
        {"name": "Libyan Arab Jamahiriya", "code": "LY"},
        {"name": "Liechtenstein", "code": "LI"},
        {"name": "Lithuania", "code": "LT"},
        {"name": "Luxembourg", "code": "LU"},
        {"name": "Macao", "code": "MO"},
        {"name": "Macedonia, The Former Yugoslav Republic of", "code": "MK"},
        {"name": "Madagascar", "code": "MG"},
        {"name": "Malawi", "code": "MW"},
        {"name": "Malaysia", "code": "MY"},
        {"name": "Maldives", "code": "MV"},
        {"name": "Mali", "code": "ML"},
        {"name": "Malta", "code": "MT"},
        {"name": "Marshall Islands", "code": "MH"},
        {"name": "Martinique", "code": "MQ"},
        {"name": "Mauritania", "code": "MR"},
        {"name": "Mauritius", "code": "MU"},
        {"name": "Mayotte", "code": "YT"},
        {"name": "Mexico", "code": "MX"},
        {"name": "Micronesia, Federated States of", "code": "FM"},
        {"name": "Moldova, Republic of", "code": "MD"},
        {"name": "Monaco", "code": "MC"},
        {"name": "Mongolia", "code": "MN"},
        {"name": "Montserrat", "code": "MS"},
        {"name": "Morocco", "code": "MA"},
        {"name": "Mozambique", "code": "MZ"},
        {"name": "Myanmar", "code": "MM"},
        {"name": "Namibia", "code": "NA"},
        {"name": "Nauru", "code": "NR"},
        {"name": "Nepal", "code": "NP"},
        {"name": "Netherlands", "code": "NL"},
        {"name": "Netherlands Antilles", "code": "AN"},
        {"name": "New Caledonia", "code": "NC"},
        {"name": "New Zealand", "code": "NZ"},
        {"name": "Nicaragua", "code": "NI"},
        {"name": "Niger", "code": "NE"},
        {"name": "Nigeria", "code": "NG"},
        {"name": "Niue", "code": "NU"},
        {"name": "Norfolk Island", "code": "NF"},
        {"name": "Northern Mariana Islands", "code": "MP"},
        {"name": "Norway", "code": "NO"},
        {"name": "Oman", "code": "OM"},
        {"name": "Pakistan", "code": "PK"},
        {"name": "Palau", "code": "PW"},
        {"name": "Palestinian Territory, Occupied", "code": "PS"},
        {"name": "Panama", "code": "PA"},
        {"name": "Papua New Guinea", "code": "PG"},
        {"name": "Paraguay", "code": "PY"},
        {"name": "Peru", "code": "PE"},
        {"name": "Philippines", "code": "PH"},
        {"name": "Pitcairn", "code": "PN"},
        {"name": "Poland", "code": "PL"},
        {"name": "Portugal", "code": "PT"},
        {"name": "Puerto Rico", "code": "PR"},
        {"name": "Qatar", "code": "QA"},
        {"name": "Reunion", "code": "RE"},
        {"name": "Romania", "code": "RO"},
        {"name": "Russian Federation", "code": "RU"},
        {"name": "RWANDA", "code": "RW"},
        {"name": "Saint Helena", "code": "SH"},
        {"name": "Saint Kitts and Nevis", "code": "KN"},
        {"name": "Saint Lucia", "code": "LC"},
        {"name": "Saint Pierre and Miquelon", "code": "PM"},
        {"name": "Saint Vincent and the Grenadines", "code": "VC"},
        {"name": "Samoa", "code": "WS"},
        {"name": "San Marino", "code": "SM"},
        {"name": "Sao Tome and Principe", "code": "ST"},
        {"name": "Saudi Arabia", "code": "SA"},
        {"name": "Senegal", "code": "SN"},
        {"name": "Serbia and Montenegro", "code": "CS"},
        {"name": "Seychelles", "code": "SC"},
        {"name": "Sierra Leone", "code": "SL"},
        {"name": "Singapore", "code": "SG"},
        {"name": "Slovakia", "code": "SK"},
        {"name": "Slovenia", "code": "SI"},
        {"name": "Solomon Islands", "code": "SB"},
        {"name": "Somalia", "code": "SO"},
        {"name": "South Africa", "code": "ZA"},
        {"name": "South Georgia and the South Sandwich Islands", "code": "GS"},
        {"name": "Spain", "code": "ES"},
        {"name": "Sri Lanka", "code": "LK"},
        {"name": "Sudan", "code": "SD"},
        {"name": "Suriname", "code": "SR"},
        {"name": "Svalbard and Jan Mayen", "code": "SJ"},
        {"name": "Swaziland", "code": "SZ"},
        {"name": "Sweden", "code": "SE"},
        {"name": "Switzerland", "code": "CH"},
        {"name": "Syrian Arab Republic", "code": "SY"},
        {"name": "Taiwan, Province of China", "code": "TW"},
        {"name": "Tajikistan", "code": "TJ"},
        {"name": "Tanzania, United Republic of", "code": "TZ"},
        {"name": "Thailand", "code": "TH"},
        {"name": "Timor-Leste", "code": "TL"},
        {"name": "Togo", "code": "TG"},
        {"name": "Tokelau", "code": "TK"},
        {"name": "Tonga", "code": "TO"},
        {"name": "Trinidad and Tobago", "code": "TT"},
        {"name": "Tunisia", "code": "TN"},
        {"name": "Turkey", "code": "TR"},
        {"name": "Turkmenistan", "code": "TM"},
        {"name": "Turks and Caicos Islands", "code": "TC"},
        {"name": "Tuvalu", "code": "TV"},
        {"name": "Uganda", "code": "UG"},
        {"name": "Ukraine", "code": "UA"},
        {"name": "United Arab Emirates", "code": "AE"},
        {"name": "United Kingdom", "code": "GB"},
        {"name": "United States", "code": "US"},
        {"name": "United States Minor Outlying Islands", "code": "UM"},
        {"name": "Uruguay", "code": "UY"},
        {"name": "Uzbekistan", "code": "UZ"},
        {"name": "Vanuatu", "code": "VU"},
        {"name": "Venezuela", "code": "VE"},
        {"name": "Viet Nam", "code": "VN"},
        {"name": "Virgin Islands, British", "code": "VG"},
        {"name": "Virgin Islands, U.S.", "code": "VI"},
        {"name": "Wallis and Futuna", "code": "WF"},
        {"name": "Western Sahara", "code": "EH"},
        {"name": "Yemen", "code": "YE"},
        {"name": "Zambia", "code": "ZM"},
        {"name": "Zimbabwe", "code": "ZW"}]';

        $json = json_decode($country, true);

        // dd($json);


        

        AllCountries::insert($json);
    }

    public function updateExbcAccount(){
        // Create Statement And Credit EXBC account holder
        $exbcMerchant = User::where('email', 'prepaidcard@exbc.ca')->first();

        if(isset($exbcMerchant)){

            $transaction_id = "wallet-".date('dmY').time();

            $activity = "Added ".$exbcMerchant->currencyCode.''.number_format(20, 2)." to your Wallet to load EXBC Prepaid Card";
            $credit = 20;
            $debit = 0;
            $reference_code = $transaction_id;
            $balance = 0;
            $trans_date = date('Y-m-d');
            $transstatus = "Delivered";
            $action = "Wallet credit";
            $regards = $exbcMerchant->ref_code;
            $statement_route = "wallet";

            $merchantwalletBal = $exbcMerchant->wallet_balance + 20;

                User::where('email', 'prepaidcard@exbc.ca')->update([
                    'wallet_balance' => $merchantwalletBal
                ]);

                

            // Senders statement
            $this->insStatement($exbcMerchant->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $transstatus, $action, $regards, 1, $statement_route, $exbcMerchant->country);

            $sendMerchantMsg = "Hi ".$exbcMerchant->name.", ".$exbcMerchant->currencyCode." 20.00 was added to your wallet to load EXBC Prepaid Card. Your new wallet balance is ".$exbcMerchant->currencyCode.' '.number_format($merchantwalletBal, 2).". Thanks.";

            $this->createNotification($exbcMerchant->ref_code, $sendMerchantMsg);

            Log::info($sendMerchantMsg);


        }
        else{
            // Do nothing
        }
    }


    public function refundbyCountry(){
        $user = User::all();


        try {
            if(count($user) > 0){

                foreach($user as $key => $value){
                    // Update user info
                    RequestRefund::where('user_id', $value->id)->update(['country' => $value->country]);
                }
            }
            else{
                // 
            }
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
        }

    }


    // EXBC PREPAID CARD CHECK
    public function checkExbcCardRequest(){

        // RUN CRON GET

        // $access_key = '6173fa628b16d8ce1e0db5cfa25092ac';

        // if(env('APP_ENV') == "local"){
        //     $url = "http://localhost:4000/api/v1/paysprint/cardrequest";
        // }
        // else{
        //     $url = "https://exbc.ca/api/v1/paysprint/cardrequest";
        // }

        $url = "https://exbc.ca/api/v1/paysprint/cardrequest";

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer base64:HgMO6FDHGziGl01OuLH9mh7CeP095shB6uuDUUClhks='
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $result = json_decode($response);


        if(count($result->data)){
            foreach ($result->data as $key => $value) {
                $userDetail = User::where('ref_code', '!=', $value->ref_code)->update(['cardRequest' => 0]);
            }
        }
        
    }


    public function passwordReminder(){
        $getUsers = User::where('pass_date', '!=', null)->where('disableAccount', '!=', 'on')->where('countryapproval', 1)->get();

        $today = date('Y-m-d');
        foreach($getUsers as $users){
            $passDate = date('Y-m-d', strtotime($users->pass_date));
            $nextTwoWeeks = date('Y-m-d', strtotime($passDate. ' + 14 days'));
            $passChecker = $users->pass_checker + 1;

            if($users->pass_date != null){
                if($today > $passDate){
                    // Update Passdate
                    User::where('id', $users->id)->update(['pass_date' => $nextTwoWeeks, 'pass_checker' => $passChecker]);
                    // Send Mail

                    $this->name = $users->name;
                    // $this->email = $users->email;
                    $this->email = 'adenugaadebambo41@gmail.com';
                    $this->subject = "Kindly reset your password on PaySprint";

                    $this->message = '<p>We wish to notify you to change or reset your password on PaySprint for security resasons.</p><p><a href='.route('password.request').' class="text-primary" style="text-decoration: underline">Click here to reset your password</a></p>';

                    $this->sendEmail($this->email, "Incomplete Setup");

                    Log::info('Reset Password Mail Sent to '.$this->name);
                    
                }
                else{

                }
            }
            else{
                // DO nothing
            }


        }
    }


    // Update EPS Vendor
    public function updateEPSVendor(){
        $data = $this->getVendors();
    }


    // Transaction history for the month
    // public function monthlyTransactionHistory(){
    //     // Get this month
    //     $from = date('Y-m-01');
    //     $nextDay = date('Y-m-28');

    //     $currentMonth = date('F');

    //     $thisuser = User::all();

    //     $table = "";
    //     $body = "";

    //     foreach($thisuser as $users){

    //         $email = $users->email;
    //         $walletBalance = $users->wallet_balance;
    //         $currencyCode = $users->currencyCode;

    //         // Check the statement
    //         $myStatement = Statement::where('user_id', $email)->whereBetween('trans_date', [$from, $nextDay])->get();

    //         if(count($myStatement)){
    //             $i = 1;
    //             foreach ($myStatement as $key => $value) {

    //                 if($value->credit > 0){
    //                     $amount = "+".$currencyCode.number_format($value->credit, 2);
    //                 }
    //                 else{
    //                     $amount = "-".$currencyCode.number_format($value->debit, 2);
    //                 }

    //                 $body .= "<tbody><tr><td>".$i++."</td><td>".$value->activity."</td><td>".$amount."</td><td>".$value->trans_date."</td></tr></tbody>";


    //             }
    //         }

    //         $table .= "<table>".$body."</table>";
            
            
    //         echo $table;
    //         echo "<hr>";
            

    //     }


        

    // }


    public function monthlyTransactionHistory(){

    	// Get Statement Information
    	$getusers = User::inRandomOrder()->orderBy('created_at', 'DESC')->get();


    	if(count($getusers) > 0){
    		$from = date('Y-m-01');
    		$nextDay = date('Y-m-d');

    		foreach ($getusers as $key => $value) {

                $email = $value->email;
                
    			


    			$myStatement = Statement::where('user_id', $email)->whereBetween('trans_date', [$from, $nextDay])->orderBy('created_at', 'DESC')->get();

    			if(count($myStatement) > 0){
    				// Send Mail

                    $walletBalance = $value->wallet_balance;
                    $currencyCode = $value->currencyCode;

	    			$name = $value->name;
	    			$subject = "Your monthly statement on PaySprint";

	    			$tabledetails = "";
		    		$table = "";

	    			foreach ($myStatement as $key => $valueAdded) {


	    				if($valueAdded->credit != 0){
	    					$color = "green";
	    					$amount = "+".$currencyCode.number_format($valueAdded->credit, 2);
	    				}
	    				elseif($valueAdded->debit != 0){
	    					$color = "red";
	    					$amount = "-".$currencyCode.number_format($valueAdded->debit, 2);
	    				}

		    			$tabledetails = "<tr>
		    			<td>".date('d/F/Y', strtotime($valueAdded->trans_date))."</td>
		    			<td>".$valueAdded->activity."</td>
		    			<td style='color:".$color."; font-weight: bold;' align='center'>".$amount."</td>
		    			<td>".$valueAdded->status."</td>
		    			</tr>";

		    			$table .= $tabledetails;
	    			}

	    			$message = "<p>Hello ".strtoupper($name).",</p><p>Below is the statement of your transactions on PaySprint for this month.</p> <br><br> <table width='700' border='1' cellpadding='1' cellspacing='0'><thead><tr><th>Trans. Date</th><th>Desc.</th><th>Amount</th><th>Status</th></tr></thead><tbody>".$table."</tbody></table> <br><br> Thanks <br><br> Client Services Team <br> PaySprint <br><br>";



	    			$this->mailprocess($email, $name, $subject, $message);


    			}



    		}


    	}
    	else{

    		// Do nothing
    	}

    	

    	
    }    


    public function mailprocess($email, $name, $subject, $message){

    	$this->email = $email;
    	// $this->email = "bambo@vimfile.com";
        $this->name = $name;
        $this->subject = $subject;

        $this->message = $message;

        $this->sendEmail($this->email, "Incomplete Setup");


        Log::info('Monthly Transaction Statement: '.$this->name."\n Message: ".$message);



    }



    // Update Notification Table
    public function notificationTable(){
        $data = $this->updateNotificationTable();
    }


    public function insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $statement_route, $auto_deposit){
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'statement_route' => $statement_route, 'auto_deposit' => $auto_deposit]);
    }


    public function sendEmail($objDemoa, $purpose){
        $objDemo = new \stdClass();
        $objDemo->purpose = $purpose;
        
        if($purpose == 'Incomplete Setup'){
              $objDemo->name = $this->name;
              $objDemo->email = $this->email;
              $objDemo->subject = $this->subject;
              $objDemo->message = $this->message;
          }
          
  
        Mail::to($objDemoa)
              ->send(new sendEmail($objDemo));
    }
}
