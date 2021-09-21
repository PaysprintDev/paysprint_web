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
use App\SpecialInformation as SpecialInformation;


use App\Traits\ExpressPayment;
use App\Traits\AccountNotify;
use App\Traits\Xwireless;
use App\Traits\PaymentGateway;
use App\Traits\MailChimpNewsLetter;

class CheckSetupController extends Controller
{

    public $name;
    public $email;
    public $subject;
    public $message;

    use ExpressPayment, AccountNotify, Xwireless, PaymentGateway, MailChimpNewsLetter;
    // Check user quick wallet setup

    public function updateQuickSetup()
    {
        // Get User
        $user = User::where('disableAccount', 'off')->inRandomOrder()->get();

        try {



            foreach ($user as $key => $value) {

                $info = $this->accountInfo($value->id);

                if ($value->approval == 0) {
                    $approval = "<li>Upload a copy of Government Issued Photo ID</li>";
                } else {
                    $approval = "";
                }


                if ($value->transaction_pin == null) {
                    $transaction = "<li>Set Up Transaction Pin-You will need the PIN to Send Money, Pay Invoice/Bill or Withdraw Money from Your PaySprint Account</li>";
                } else {
                    $transaction = "";
                }
                if ($value->securityQuestion == null) {
                    $security = "<li>Set up Security Question and Answer-You will need this to reset your PIN code or Login Password</li>";
                } else {
                    $security = "";
                }
                if ($value->country == "Nigeria" && $value->bvn_verification == null) {
                    $bankVerify = "<li>Verify your account with your bank verification number</li>";
                } else {
                    $bankVerify = "";
                }
                if ($info == 0) {
                    $card = "<li>Add Credit Card/Prepaid Card/Bank Account-You need this to add money to your PaySprint Wallet.</li>";
                } else {
                    $card = "";
                }

                // Send Mail

                if ($value->approval == 0 || $value->transaction_pin == null || $value->securityQuestion == null || $info == 0) {

                    $this->name = $value->name;
                    $this->email = $value->email;
                    $this->subject = "You have some incomplete information on your PaySprint account";

                    $this->message = '<p>We noticed you are yet to properly complete the set-up your PaySprint Account. You need to provide the outstanding information and complete the quick set up in order to enjoy the full benefits of a PaySprint Account.</p><p><ul>' . $approval . '' . $transaction . '' . $security . '' . $bankVerify . '' . $card . '</ul></p><p>Kindly complete these important steps in your profile. <a href=' . route('profile') . ' class="text-primary" style="text-decoration: underline">Click here to login to your account</a></p>';


                    $this->mailListCategorize($this->name, $this->email, $value->address, $value->telephone, 'Quick Setup', $value->country, 'Subscription');

                    // $this->sendEmail($this->email, "Incomplete Setup");
                    // $this->sendCampaign($this->subject, $this->message, $this->email, $this->name);

                    // Log::info('Quick wallet set up cron sent to '.$this->name);

                    // $this->slack('Quick wallet set up cron sent to ' . $this->name, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));


                    echo "Sent to " . $this->name . "<hr>";
                }
            }
        } catch (\Throwable $th) {
            // Log::critical('Cannot send quick setup mail '.$th->getMessage());

            $this->slack('Cannot send quick setup mail ' . $th->getMessage(), $room = "error-logs", $icon = ":longbox:", env('LOG_SLACK_WEBHOOK_URL'));
        }
    }

    public function accountInfo($id)
    {

        $getCard = AddCard::where('user_id', $id)->first();

        if (isset($getCard) == false) {
            // Check Bank
            $getBank = AddBank::where('user_id', $id)->first();

            if (isset($getBank) == false) {
                $data = 0;
            } else {
                // Do nothing
                $data = 1;
            }
        } else {
            // Do nothing
            $data = 1;
        }


        return $data;
    }



    // Move account to archive

    public function userAccountArchive()
    {
        $getUsers = User::all();
        $sum = 0;

        foreach ($getUsers as $allusers) {

            $getNIN = $this->accountChecker($allusers->id, 'nin_front');
            $getDriverLicence = $this->accountChecker($allusers->id, 'drivers_license_front');
            $getPassport = $this->accountChecker($allusers->id, 'international_passport_front');
            $BVN = $this->accountChecker($allusers->id, 'bvn_verification');



            $sum = $getNIN + $getDriverLicence + $getPassport + $BVN;

            if ($sum == 4) {
                User::where('id', $allusers->id)->update(['archive' => 1]);

                $value = User::where('id', $allusers->id)->first();

                if ($value->accountType == "Individual") {
                    $category = "Archived Consumers";
                } else {
                    $category = "Archived Merchants";
                }

                $this->mailListCategorize($value->name, $value->email, $value->address, $value->telephone, $category, $value->country, 'Subscription');
            } else {
                User::where('id', $allusers->id)->update(['archive' => 0]);
            }
        }
    }


    public function accountChecker($id, $fieldName)
    {

        if ($fieldName != 'bvn_verification') {
            $result = User::where('id', $id)->where($fieldName, NULL)->first();
        } else {
            $result = User::where('id', $id)->where($fieldName, 0)->first();
        }


        if (isset($result)) {
            $data = 1;
        } else {
            $data = 0;
        }
        return $data;
    }


    public function autoDepositOff()
    {
        $user = User::where('auto_deposit', 'off')->where('disableAccount', 'off')->inRandomOrder()->get();

        if (count($user) > 0) {
            // Send mail
            foreach ($user as $key => $value) {
                $this->name = $value->name;
                $this->email = $value->email;
                $this->subject = "Your Auto Deposit status is OFF on PaySprint.";

                $this->message = '<p>The Auto Deposit feature on PaySprint is turned OFF. You will need to manually accept all transfers made to your PaySprint wallet. If you want to enjoy a stress-free transaction deposit, you may have visit your profile on PaySprint Account to turn ON the feature. <br><br> Thanks, PaySprint Team</p>';

                $this->sendEmail($this->email, "Incomplete Setup");

                // Log::info('Auto Deposit Status cron sent to '.$this->name);

                $this->slack('Auto Deposit Status cron sent to ' . $this->name, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                echo "Sent to " . $this->name . "<hr>";
            }
        } else {
            // Do nothing
        }
    }


    public function checkAccountAcvtivity()
    {
        $user = User::where('lastLogin', '!=', null)->where('disableAccount', 'off')->inRandomOrder()->get();

        if (count($user) > 0) {

            $date2 = date('Y-m-d');

            foreach ($user as $key => $value) {
                $lastLogin = date('Y-m-d', strtotime($value->lastLogin));

                $date1 = $lastLogin;

                $ts1 = strtotime($date1);
                $ts2 = strtotime($date2);

                $year1 = date('Y', $ts1);
                $year2 = date('Y', $ts2);

                $month1 = date('m', $ts1);
                $month2 = date('m', $ts2);

                $diff = (($year2 - $year1) * 12) + ($month2 - $month1);


                if ($diff == 1) {

                    $this->name = $value->name;
                    $this->email = $value->email;
                    $this->subject = "We missed you on PaySprint!";

                    $this->message = '<p>You have been away for a while on PaySprint. Your last activity was recorded on <b>' . date($value->lastLogin) . '</b>. <br><br> We hope to see you soon. <br><br> Thanks, PaySprint Team</p>';


                    // Log::info('We missed you on PaySprint: '.$this->name.'. Been away for '.$diff.' Last login was '.date($value->lastLogin));

                    $this->slack('We missed you on PaySprint: ' . $this->name . '. Been away for ' . $diff . ' Last login was ' . date($value->lastLogin), $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                    $this->sendEmail($this->email, "Incomplete Setup");
                } elseif ($diff == 2) {
                    $this->name = $value->name;
                    $this->email = $value->email;
                    $this->subject = "We missed you on PaySprint!";

                    $this->message = '<p>We noticed you have been away for about ' . $diff . ' months. Your last activity was recorded on <b>' . $value->lastLogin . '</b>. <br><br> Your PaySprint Account would be disabled if there are no activity in the next days. The qualifying activities include, Add and send money, Pay invoice or withdraw money from your PaySprint Account. <br><br> We hope to see you soon. <br><br> Thanks, PaySprint Team</p>';


                    // Log::info('We missed you on PaySprint: '.$this->name.'. Been away for '.$diff.' Last login was '.$value->lastLogin);

                    $this->slack('We missed you on PaySprint: ' . $this->name . '. Been away for ' . $diff . ' Last login was ' . $value->lastLogin, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                    $this->sendEmail($this->email, "Incomplete Setup");
                } elseif ($diff == 3) {

                    User::where('email', $value->email)->update(['disableAccount' => 'on']);

                    $this->name = $value->name;
                    $this->email = $value->email;
                    $this->subject = "Your account has been inactive on PaySprint for " . $diff . " months!";

                    $this->message = '<p>Your last activity was recorded on <b>' . $value->lastLogin . '</b>. <br><br> Your account is now suspended due to inactive use. Kindly contact the admin using contact us form, providing Account number and your name for your account to be activated. <br><br> Thanks, PaySprint Team</p>';

                    // Log::info('We missed you on PaySprint: '.$this->name.'. Been away for '.$diff.' Last login was '.$value->lastLogin.' and account is disabled');

                    $this->slack('We missed you on PaySprint: ' . $this->name . '. Been away for ' . $diff . ' Last login was ' . $value->lastLogin . ' and account is disabled', $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                    $this->sendEmail($this->email, "Incomplete Setup");
                } else {
                    // Do nothing
                }
            }

            echo "Mail Sent";
        } else {
            // Do nothing
        }
    }


    public function statementCountry()
    {
        $query = User::where('disableAccount', 'off')->orderBy('created_at', 'DESC')->get();

        if (count($query) > 0) {
            foreach ($query as $value => $key) {
                $country = $key->country;
                $email = $key->email;

                // Update Statememt country
                Statement::where('user_id', $email)->update(['country' => $country]);
            }
        } else {
            // Do nothing
        }
    }


    // Update charge fee
    public function chargeFee()
    {
        $query = FeeTransaction::orderBy('created_at', 'DESC')->get();

        if (count($query) > 0) {
            foreach ($query as $value => $key) {
                $transaction_id = $key->transaction_id;
                $fee = $key->fee;

                // Update Statememt chargefee
                Statement::where('reference_code', $transaction_id)->update(['chargefee' => $fee]);

                // Log::info("Update charge fee: ".$fee);
            }
        } else {
            // Do nothing
        }
    }


    public function updateMonthlyFee(Request $req)
    {

        $getUser = User::where('created_at', '<=', '2021-04-30')->where('disableAccount', 'off')->inRandomOrder()->get();

        foreach ($getUser as $key => $value) {


            if ($value->accountType == "Individual") {
                $subType = "Consumer Monthly Subscription";
            } else {
                $subType = "Merchant Monthly Subscription";
            }


            $getTranscost = TransactionCost::where('structure', $subType)->where('country', $value->country)->first();

            if (isset($getTranscost)) {


                $walletBalance = $value->wallet_balance - $getTranscost->fixed;

                // Send Mail
                $transaction_id = "wallet-" . date('dmY') . time();

                $activity = "Monthly Subscription of CAD5.00 for April/2021 was deducted from Wallet";
                $credit = 0;
                $debit = number_format($getTranscost->fixed, 2);
                $reference_code = $transaction_id;
                $balance = 0;
                $trans_date = date('Y-m-d');
                $status = "Delivered";
                $action = "Wallet debit";
                $regards = $value->ref_code;
                $statement_route = "wallet";


                $sendMsg = 'Hello ' . strtoupper($value->name) . ', ' . $activity . '. You now have ' . $value->currencyCode . ' ' . number_format($walletBalance, 2) . ' balance in your account';
                $sendPhone = "+" . $value->code . $value->telephone;


                // Senders statement
                $this->maintinsStatement($value->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, 1, $statement_route);

                $this->createNotification($value->ref_code, "Hello " . strtoupper($value->name) . ", " . $sendMsg);

                $this->name = $value->name;
                $this->email = $value->email;
                $this->subject = $activity;

                $this->message = '<p>' . $activity . '</p><p>You now have <strong>' . $value->currencyCode . ' ' . number_format($walletBalance, 2) . '</strong> balance in your account</p>';


                // Log::info($sendMsg);

                $this->slack($sendMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

                // $this->sendMessage($sendMsg, $sendPhone);

                // $this->sendEmail($this->email, "Fund remittance");

                // $this->monthlyChargeInsert($value->ref_code, $value->country, $getTranscost->fixed, $value->currencyCode);


                echo "Sent to " . $this->name . "<hr>";
            } else {
                // Log::info($value->name." was not charged because they are in ".$value->country." and the fee charge is not yet available");
            }
        }
    }

    public function maintinsStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $statement_route)
    {
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'statement_route' => $statement_route]);
    }


    // update transaction limit
    public function updateTransLimit()
    {

        try {
            $users = User::where('withdrawal_per_transaction', 0)->get();

            foreach ($users as $user) {

                if ($user->accountType == "Individual") {
                    $subType = "Consumer Minimum Withdrawal";
                } else {
                    $subType = "Merchant Minimum Withdrawal";
                }
                $transCost = TransactionCost::where('method', $subType)->where('country', $user->country)->first();

                if (isset($transCost)) {
                    User::where('id', $user->id)->update(['withdrawal_per_transaction' => $transCost->fixed]);

                    echo "Done for: " . $user->name . " " . $user->id . "<hr>";
                } else {
                    echo "Not done for: " . $user->name . " " . $user->id . "<hr>";
                }
            }
            echo "Total is " . count($users);
        } catch (\Throwable $th) {
            print_r($th->getMessage());
        }
    }

    // Update withdrawals
    public function updateNumberofWithdrawal()
    {
        try {
            $users = User::all();
            foreach ($users as $user) {
                User::where('id', $user->id)->update(['number_of_withdrawals' => 0]);

                echo "Done for " . $user->name . " | " . $user->id;
            }
        } catch (\Throwable $th) {
            print_r($th->getMessage());
        }
    }


    // Update Statement Report Satus
    public function reportStatus()
    {

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


    public function insertCountry()
    {
        $country = '[{"name": "Afghanistan", "code": "AF", "gateway": ""},
        {"name": "Åland Islands", "code": "AX", "gateway": ""},
        {"name": "Albania", "code": "AL", "gateway": ""},
        {"name": "Algeria", "code": "DZ", "gateway": ""},
        {"name": "American Samoa", "code": "AS", "gateway": ""},
        {"name": "AndorrA", "code": "AD", "gateway": ""},
        {"name": "Angola", "code": "AO", "gateway": ""},
        {"name": "Anguilla", "code": "AI", "gateway": ""},
        {"name": "Antarctica", "code": "AQ", "gateway": ""},
        {"name": "Antigua and Barbuda", "code": "AG", "gateway": ""},
        {"name": "Argentina", "code": "AR", "gateway": ""},
        {"name": "Armenia", "code": "AM", "gateway": ""},
        {"name": "Aruba", "code": "AW", "gateway": ""},
        {"name": "Australia", "code": "AU", "gateway": "PayPal"},
        {"name": "Austria", "code": "AT", "gateway": "PayPal"},
        {"name": "Azerbaijan", "code": "AZ", "gateway": ""},
        {"name": "Bahamas", "code": "BS", "gateway": ""},
        {"name": "Bahrain", "code": "BH", "gateway": ""},
        {"name": "Bangladesh", "code": "BD", "gateway": ""},
        {"name": "Barbados", "code": "BB", "gateway": ""},
        {"name": "Belarus", "code": "BY", "gateway": ""},
        {"name": "Belgium", "code": "BE", "gateway": "PayPal"},
        {"name": "Belize", "code": "BZ", "gateway": ""},
        {"name": "Benin", "code": "BJ", "gateway": ""},
        {"name": "Bermuda", "code": "BM", "gateway": ""},
        {"name": "Bhutan", "code": "BT", "gateway": ""},
        {"name": "Bolivia", "code": "BO", "gateway": ""},
        {"name": "Bosnia and Herzegovina", "code": "BA", "gateway": ""},
        {"name": "Botswana", "code": "BW", "gateway": ""},
        {"name": "Bouvet Island", "code": "BV", "gateway": ""},
        {"name": "Brazil", "code": "BR", "gateway": ""},
        {"name": "British Indian Ocean Territory", "code": "IO", "gateway": ""},
        {"name": "Brunei Darussalam", "code": "BN", "gateway": ""},
        {"name": "Bulgaria", "code": "BG", "gateway": "Stripe"},
        {"name": "Burkina Faso", "code": "BF", "gateway": ""},
        {"name": "Burundi", "code": "BI", "gateway": ""},
        {"name": "Cambodia", "code": "KH", "gateway": ""},
        {"name": "Cameroon", "code": "CM", "gateway": ""},
        {"name": "Canada", "code": "CA", "gateway": "PayPal"},
        {"name": "Cape Verde", "code": "CV", "gateway": ""},
        {"name": "Cayman Islands", "code": "KY", "gateway": ""},
        {"name": "Central African Republic", "code": "CF", "gateway": ""},
        {"name": "Chad", "code": "TD", "gateway": ""},
        {"name": "Chile", "code": "CL", "gateway": ""},
        {"name": "China", "code": "CN", "gateway": ""},
        {"name": "Christmas Island", "code": "CX", "gateway": ""},
        {"name": "Cocos (Keeling) Islands", "code": "CC", "gateway": ""},
        {"name": "Colombia", "code": "CO", "gateway": ""},
        {"name": "Comoros", "code": "KM", "gateway": ""},
        {"name": "Congo", "code": "CG", "gateway": ""},
        {"name": "Congo, The Democratic Republic of the", "code": "CD", "gateway": ""},
        {"name": "Cook Islands", "code": "CK", "gateway": ""},
        {"name": "Costa Rica", "code": "CR", "gateway": ""},
        {"name": "Cote D\'Ivoire", "code": "CI", "gateway": ""},
        {"name": "Croatia", "code": "HR", "gateway": ""},
        {"name": "Cuba", "code": "CU", "gateway": ""},
        {"name": "Cyprus", "code": "CY", "gateway": "Stripe"},
        {"name": "Czech Republic", "code": "CZ", "gateway": "PayPal"},
        {"name": "Denmark", "code": "DK", "gateway": "PayPal"},
        {"name": "Djibouti", "code": "DJ", "gateway": ""},
        {"name": "Dominica", "code": "DM", "gateway": ""},
        {"name": "Dominican Republic", "code": "DO", "gateway": ""},
        {"name": "Ecuador", "code": "EC", "gateway": ""},
        {"name": "Egypt", "code": "EG", "gateway": ""},
        {"name": "El Salvador", "code": "SV", "gateway": ""},
        {"name": "Equatorial Guinea", "code": "GQ", "gateway": ""},
        {"name": "Eritrea", "code": "ER", "gateway": ""},
        {"name": "Estonia", "code": "EE", "gateway": "Stripe"},
        {"name": "Ethiopia", "code": "ET", "gateway": ""},
        {"name": "Falkland Islands (Malvinas)", "code": "FK", "gateway": ""},
        {"name": "Faroe Islands", "code": "FO", "gateway": ""},
        {"name": "Fiji", "code": "FJ", "gateway": ""},
        {"name": "Finland", "code": "FI", "gateway": "Stripe"},
        {"name": "France", "code": "FR", "gateway": "PayPal"},
        {"name": "French Guiana", "code": "GF", "gateway": ""},
        {"name": "French Polynesia", "code": "PF", "gateway": ""},
        {"name": "French Southern Territories", "code": "TF", "gateway": ""},
        {"name": "Gabon", "code": "GA", "gateway": ""},
        {"name": "Gambia", "code": "GM", "gateway": ""},
        {"name": "Georgia", "code": "GE", "gateway": ""},
        {"name": "Germany", "code": "DE", "gateway": "PayPal"},
        {"name": "Ghana", "code": "GH", "gateway": "PayStack"},
        {"name": "Gibraltar", "code": "GI", "gateway": ""},
        {"name": "Greece", "code": "GR", "gateway": "Stripe"},
        {"name": "Greenland", "code": "GL", "gateway": ""},
        {"name": "Grenada", "code": "GD", "gateway": ""},
        {"name": "Guadeloupe", "code": "GP", "gateway": ""},
        {"name": "Guam", "code": "GU", "gateway": ""},
        {"name": "Guatemala", "code": "GT", "gateway": ""},
        {"name": "Guernsey", "code": "GG", "gateway": ""},
        {"name": "Guinea", "code": "GN", "gateway": ""},
        {"name": "Guinea-Bissau", "code": "GW", "gateway": ""},
        {"name": "Guyana", "code": "GY", "gateway": ""},
        {"name": "Haiti", "code": "HT", "gateway": ""},
        {"name": "Heard Island and Mcdonald Islands", "code": "HM", "gateway": ""},
        {"name": "Holy See (Vatican City State)", "code": "VA", "gateway": ""},
        {"name": "Honduras", "code": "HN", "gateway": ""},
        {"name": "Hong Kong", "code": "HK", "gateway": "PayPal"},
        {"name": "Hungary", "code": "HU", "gateway": "PayPal"},
        {"name": "Iceland", "code": "IS", "gateway": ""},
        {"name": "India", "code": "IN", "gateway": "Stripe"},
        {"name": "Indonesia", "code": "ID", "gateway": ""},
        {"name": "Iran, Islamic Republic Of", "code": "IR", "gateway": ""},
        {"name": "Iraq", "code": "IQ", "gateway": ""},
        {"name": "Ireland", "code": "IE", "gateway": "Stripe"},
        {"name": "Isle of Man", "code": "IM", "gateway": ""},
        {"name": "Israel", "code": "IL", "gateway": "PayPal"},
        {"name": "Italy", "code": "IT", "gateway": "PayPal"},
        {"name": "Jamaica", "code": "JM", "gateway": ""},
        {"name": "Japan", "code": "JP", "gateway": "PayPal"},
        {"name": "Jersey", "code": "JE", "gateway": ""},
        {"name": "Jordan", "code": "JO", "gateway": ""},
        {"name": "Kazakhstan", "code": "KZ", "gateway": ""},
        {"name": "Kenya", "code": "KE", "gateway": ""},
        {"name": "Kiribati", "code": "KI", "gateway": ""},
        {"name": "Korea, Democratic People\'S Republic of", "code": "KP", "gateway": ""},
        {"name": "Korea, Republic of", "code": "KR", "gateway": ""},
        {"name": "Kuwait", "code": "KW", "gateway": ""},
        {"name": "Kyrgyzstan", "code": "KG", "gateway": ""},
        {"name": "Lao People\'S Democratic Republic", "code": "LA", "gateway": ""},
        {"name": "Latvia", "code": "LV", "gateway": "Stripe"},
        {"name": "Lebanon", "code": "LB", "gateway": ""},
        {"name": "Lesotho", "code": "LS", "gateway": ""},
        {"name": "Liberia", "code": "LR", "gateway": ""},
        {"name": "Libyan Arab Jamahiriya", "code": "LY", "gateway": ""},
        {"name": "Liechtenstein", "code": "LI", "gateway": ""},
        {"name": "Lithuania", "code": "LT", "gateway": "Stripe"},
        {"name": "Luxembourg", "code": "LU", "gateway": "Stripe"},
        {"name": "Macao", "code": "MO", "gateway": ""},
        {"name": "Macedonia, The Former Yugoslav Republic of", "code": "MK", "gateway": ""},
        {"name": "Madagascar", "code": "MG", "gateway": ""},
        {"name": "Malawi", "code": "MW", "gateway": ""},
        {"name": "Malaysia", "code": "MY", "gateway": "Stripe"},
        {"name": "Maldives", "code": "MV", "gateway": ""},
        {"name": "Mali", "code": "ML", "gateway": ""},
        {"name": "Malta", "code": "MT", "gateway": "Stripe"},
        {"name": "Marshall Islands", "code": "MH", "gateway": ""},
        {"name": "Martinique", "code": "MQ", "gateway": ""},
        {"name": "Mauritania", "code": "MR", "gateway": ""},
        {"name": "Mauritius", "code": "MU", "gateway": ""},
        {"name": "Mayotte", "code": "YT", "gateway": ""},
        {"name": "Mexico", "code": "MX", "gateway": "PayPal"},
        {"name": "Micronesia, Federated States of", "code": "FM", "gateway": ""},
        {"name": "Moldova, Republic of", "code": "MD", "gateway": ""},
        {"name": "Monaco", "code": "MC", "gateway": ""},
        {"name": "Mongolia", "code": "MN", "gateway": ""},
        {"name": "Montserrat", "code": "MS", "gateway": ""},
        {"name": "Morocco", "code": "MA", "gateway": ""},
        {"name": "Mozambique", "code": "MZ", "gateway": ""},
        {"name": "Myanmar", "code": "MM", "gateway": ""},
        {"name": "Namibia", "code": "NA", "gateway": ""},
        {"name": "Nauru", "code": "NR", "gateway": ""},
        {"name": "Nepal", "code": "NP", "gateway": ""},
        {"name": "Netherlands", "code": "NL", "gateway": "PayPal"},
        {"name": "Netherlands Antilles", "code": "AN", "gateway": ""},
        {"name": "New Caledonia", "code": "NC", "gateway": ""},
        {"name": "New Zealand", "code": "NZ", "gateway": "PayPal"},
        {"name": "Nicaragua", "code": "NI", "gateway": ""},
        {"name": "Niger", "code": "NE", "gateway": ""},
        {"name": "Nigeria", "code": "NG", "gateway": "PayStack"},
        {"name": "Niue", "code": "NU", "gateway": ""},
        {"name": "Norfolk Island", "code": "NF", "gateway": ""},
        {"name": "Northern Mariana Islands", "code": "MP", "gateway": ""},
        {"name": "Norway", "code": "NO", "gateway": "PayPal"},
        {"name": "Oman", "code": "OM", "gateway": ""},
        {"name": "Pakistan", "code": "PK", "gateway": ""},
        {"name": "Palau", "code": "PW", "gateway": ""},
        {"name": "Palestinian Territory, Occupied", "code": "PS", "gateway": ""},
        {"name": "Panama", "code": "PA", "gateway": ""},
        {"name": "Papua New Guinea", "code": "PG", "gateway": ""},
        {"name": "Paraguay", "code": "PY", "gateway": ""},
        {"name": "Peru", "code": "PE", "gateway": ""},
        {"name": "Philippines", "code": "PH", "gateway": "PayPal"},
        {"name": "Pitcairn", "code": "PN", "gateway": ""},
        {"name": "Poland", "code": "PL", "gateway": "PayPal"},
        {"name": "Portugal", "code": "PT", "gateway": "PayPal"},
        {"name": "Puerto Rico", "code": "PR", "gateway": ""},
        {"name": "Qatar", "code": "QA", "gateway": ""},
        {"name": "Reunion", "code": "RE", "gateway": ""},
        {"name": "Romania", "code": "RO", "gateway": "Stripe"},
        {"name": "Russian Federation", "code": "RU", "gateway": "PayPal"},
        {"name": "RWANDA", "code": "RW", "gateway": ""},
        {"name": "Saint Helena", "code": "SH", "gateway": ""},
        {"name": "Saint Kitts and Nevis", "code": "KN", "gateway": ""},
        {"name": "Saint Lucia", "code": "LC", "gateway": ""},
        {"name": "Saint Pierre and Miquelon", "code": "PM", "gateway": ""},
        {"name": "Saint Vincent and the Grenadines", "code": "VC", "gateway": ""},
        {"name": "Samoa", "code": "WS", "gateway": ""},
        {"name": "San Marino", "code": "SM", "gateway": ""},
        {"name": "Sao Tome and Principe", "code": "ST", "gateway": ""},
        {"name": "Saudi Arabia", "code": "SA", "gateway": ""},
        {"name": "Senegal", "code": "SN", "gateway": ""},
        {"name": "Serbia and Montenegro", "code": "CS", "gateway": ""},
        {"name": "Seychelles", "code": "SC", "gateway": ""},
        {"name": "Sierra Leone", "code": "SL", "gateway": ""},
        {"name": "Singapore", "code": "SG", "gateway": "PayPal"},
        {"name": "Slovakia", "code": "SK", "gateway": "Stripe"},
        {"name": "Slovenia", "code": "SI", "gateway": "Stripe"},
        {"name": "Solomon Islands", "code": "SB", "gateway": ""},
        {"name": "Somalia", "code": "SO", "gateway": ""},
        {"name": "South Africa", "code": "ZA", "gateway": "PayStack"},
        {"name": "South Georgia and the South Sandwich Islands", "code": "GS", "gateway": ""},
        {"name": "Spain", "code": "ES", "gateway": "PayPal"},
        {"name": "Sri Lanka", "code": "LK", "gateway": ""},
        {"name": "Sudan", "code": "SD", "gateway": ""},
        {"name": "Suriname", "code": "SR", "gateway": ""},
        {"name": "Svalbard and Jan Mayen", "code": "SJ", "gateway": ""},
        {"name": "Swaziland", "code": "SZ", "gateway": ""},
        {"name": "Sweden", "code": "SE", "gateway": "PayPal"},
        {"name": "Switzerland", "code": "CH", "gateway": "PayPal"},
        {"name": "Syrian Arab Republic", "code": "SY", "gateway": ""},
        {"name": "Taiwan, Province of China", "code": "TW", "gateway": "PayPal"},
        {"name": "Tajikistan", "code": "TJ", "gateway": ""},
        {"name": "Tanzania, United Republic of", "code": "TZ", "gateway": ""},
        {"name": "Thailand", "code": "TH", "gateway": "PayPal"},
        {"name": "Timor-Leste", "code": "TL", "gateway": ""},
        {"name": "Togo", "code": "TG", "gateway": ""},
        {"name": "Tokelau", "code": "TK", "gateway": ""},
        {"name": "Tonga", "code": "TO", "gateway": ""},
        {"name": "Trinidad and Tobago", "code": "TT", "gateway": ""},
        {"name": "Tunisia", "code": "TN", "gateway": ""},
        {"name": "Turkey", "code": "TR", "gateway": ""},
        {"name": "Turkmenistan", "code": "TM", "gateway": ""},
        {"name": "Turks and Caicos Islands", "code": "TC", "gateway": ""},
        {"name": "Tuvalu", "code": "TV", "gateway": ""},
        {"name": "Uganda", "code": "UG", "gateway": ""},
        {"name": "Ukraine", "code": "UA", "gateway": ""},
        {"name": "United Arab Emirates", "code": "AE", "gateway": "Stripe"},
        {"name": "United Kingdom", "code": "GB", "gateway": "PayPal"},
        {"name": "United States", "code": "US", "gateway": "PayPal"},
        {"name": "United States Minor Outlying Islands", "code": "UM", "gateway": ""},
        {"name": "Uruguay", "code": "UY", "gateway": ""},
        {"name": "Uzbekistan", "code": "UZ", "gateway": ""},
        {"name": "Vanuatu", "code": "VU", "gateway": ""},
        {"name": "Venezuela", "code": "VE", "gateway": ""},
        {"name": "Viet Nam", "code": "VN", "gateway": ""},
        {"name": "Virgin Islands, British", "code": "VG", "gateway": ""},
        {"name": "Virgin Islands, U.S.", "code": "VI", "gateway": ""},
        {"name": "Wallis and Futuna", "code": "WF", "gateway": ""},
        {"name": "Western Sahara", "code": "EH", "gateway": ""},
        {"name": "Yemen", "code": "YE", "gateway": ""},
        {"name": "Zambia", "code": "ZM", "gateway": ""},
        {"name": "Zimbabwe", "code": "ZW", "gateway": ""}]';

        $json = json_decode($country, true);

        // dd($json);

        foreach ($json as $countries) {


            AllCountries::updateOrCreate(['name' => $countries['name']], ['name' => $countries['name'], 'code' => $countries['code'], 'gateway' => $countries['gateway']]);
        }
    }

    public function updateExbcAccount()
    {
        // Create Statement And Credit EXBC account holder
        // $exbcMerchant = User::where('email', 'prepaidcard@exbc.ca')->first();
        $exbcMerchant = User::where('email', 'adenugaadebambo41@gmail.com')->first();

        if (isset($exbcMerchant)) {


            // $transaction_id = "wallet-".date('dmY').time();
            $transaction_id = "ostu94qyby";

            // $activity = "Added ".$exbcMerchant->currencyCode.''.number_format(20, 2)." to your Wallet to load EXBC Prepaid Card";
            $activity = "Added " . $exbcMerchant->currencyCode . '' . number_format(1967, 2) . " to Wallet including a fee charge of " . $exbcMerchant->currencyCode . '' . number_format(33, 2) . " was deducted from your Debit Card";
            $credit = 1967;
            $debit = 0;
            $reference_code = $transaction_id;
            $balance = 0;
            $trans_date = date('Y-m-d');
            $transstatus = "Delivered";
            $action = "Wallet credit";
            $regards = $exbcMerchant->ref_code;
            $statement_route = "wallet";

            $merchantwalletBal = $exbcMerchant->wallet_balance + 1967;

            User::where('email', 'adenugaadebambo41@gmail.com')->update([
                'wallet_balance' => $merchantwalletBal
            ]);



            // Senders statement
            $this->insStatement($exbcMerchant->email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $transstatus, $action, $regards, 1, $statement_route, $exbcMerchant->country);

            $this->getfeeTransaction($reference_code, $exbcMerchant->ref_code, 2000, 33, 1967);

            // $sendMerchantMsg = "Hi ".$exbcMerchant->name.", ".$exbcMerchant->currencyCode." 20.00 was added to your wallet to load EXBC Prepaid Card. Your new wallet balance is ".$exbcMerchant->currencyCode.' '.number_format($merchantwalletBal, 2).". Thanks.";

            $sendMerchantMsg = 'You have added ' . $exbcMerchant->currencyCode . ' ' . number_format(1967, 2) . ' (Gross Amount of ' . $exbcMerchant->currencyCode . ' ' . number_format(2000, 2) . ' less transaction fee ' . $exbcMerchant->currencyCode . ' ' . number_format(33, 2) . ') to your wallet with PaySprint. You now have ' . $exbcMerchant->currencyCode . ' ' . number_format($merchantwalletBal, 2) . ' balance in your account';

            $this->createNotification($exbcMerchant->ref_code, $sendMerchantMsg);

            $getGateway = AllCountries::where('name', $exbcMerchant->country)->first();

            $gateway = ucfirst($getGateway->gateway);


            $message = 'You have successfully added ' . $exbcMerchant->currencyCode . ' ' . number_format(1967, 2) . ' to your wallet';

            $this->keepRecord($reference_code, $message, "Success", $gateway, $exbcMerchant->country);

            $userPhone = User::where('email', $exbcMerchant->email)->where('telephone', 'LIKE', '%+%')->first();

            if (isset($userPhone)) {

                $sendPhone = $exbcMerchant->telephone;
            } else {
                $sendPhone = "+" . $exbcMerchant->code . $exbcMerchant->telephone;
            }

            if ($exbcMerchant->country == "Nigeria") {

                $correctPhone = preg_replace("/[^0-9]/", "", $sendPhone);
                $this->sendSms($sendMerchantMsg, $correctPhone);
            } else {
                $this->sendMessage($sendMerchantMsg, $sendPhone);
            }


            // Log::info($sendMerchantMsg);

            $this->slack($sendMerchantMsg, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));

            echo $sendMerchantMsg;
        } else {
            // Do nothing
        }
    }


    public function refundbyCountry()
    {
        $user = User::all();


        try {
            if (count($user) > 0) {

                foreach ($user as $key => $value) {
                    // Update user info
                    RequestRefund::where('user_id', $value->id)->update(['country' => $value->country]);
                }
            } else {
                // 
            }
        } catch (\Throwable $th) {
            // Log::error($th->getMessage());

            $this->slack($th->getMessage(), $room = "error-logs", $icon = ":longbox:", env('LOG_SLACK_WEBHOOK_URL'));
        }
    }

    // Updated Added Bank Country
    public function addedBanksCountry()
    {
        $getBanks = AddBank::all();

        foreach ($getBanks as $value) {
            $users = User::where('id', $value->user_id)->first();

            if (isset($users)) {
                AddBank::where('user_id', $users->id)->update(['country' => $users->country]);

                echo "Done for: " . $users->name . "<hr>";
            }
        }
    }


    // Work on Archives USers
    public function publishArchiveUsers()
    {
        try {
            $users = User::where('archive', 1)->inRandomOrder()->get();

            foreach ($users as $user) {
                if ($user->accountType == "Individual") {
                    $category = "Archived Consumers";
                } else {
                    $category = "Archived Merchants";
                }
                // Move to Mailchimp
                $this->mailListCategorize($user->name, $user->email, $user->address, $user->telephone, $category, $user->country, 'Subscription');


                echo "Done for :" . $user->name . " | " . $user->accountType;
            }
        } catch (\Throwable $th) {
            print_r($th->getMessage());
        }
    }


    // Work on Existing Customers and CLients
    public function publishExistingUsers()
    {
        $users = User::where('accountType', '!=', NULL)->where('archive', 0)->where('created_at', '<', date('Y-m-d', strtotime('-30 days')))->get();


        foreach ($users as $value) {
            if ($value->accountType == "Individual") {
                $category = "Exisiting Consumers";
            } else {
                $category = "Exisiting Merchants";
            }

            // Move to Mailchimp
            $this->mailListCategorize($value->name, $value->email, $value->address, $value->telephone, $category, $value->country, 'Subscription');

            echo "Done for :" . $value->name . " | " . $value->accountType . "<hr>";
        }
    }

    public function setupFeeStructure()
    {
        // $countries = AllCountries::where('approval', 1)->where('gateway', 'PayPal')->where('name', '!=', 'United States')->get();
        $countries = AllCountries::where('gateway', 'Stripe')->get();

        if (count($countries) > 0) {

            $query = [];
            $countries;

            foreach ($countries as $key => $value) {


                $countryName = $value->name;

                $availCountries[] = $countryName;
                // Get TRansaction
                $getSpecific = TransactionCost::where('country', "United States")->get();

                for ($i = 0; $i < count($getSpecific); $i++) {
                    $query[] = [
                        '_token' => $getSpecific[$i]->_token,
                        'variable' => $getSpecific[$i]->variable,
                        'fixed' => $getSpecific[$i]->fixed,
                        'structure' => $getSpecific[$i]->structure,
                        'method' => $getSpecific[$i]->method,
                        'country' => $countryName
                    ];
                }
            }



            foreach ($query as $queries) {

                TransactionCost::insert($queries);

                echo "Done";
                echo "<hr>";
            }
        }
    }


    public function checkTelephone()
    {
        $user = User::all();

        foreach ($user as $users) {
            $phone = $users->telephone;

            $correctPhone = preg_replace("/[^0-9]/", "", $phone);

            User::where('id', $users->id)->update(['telephone' => $correctPhone]);
        }

        echo "Done";
    }


    // EXBC PREPAID CARD CHECK
    public function checkExbcCardRequest()
    {

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


        if (count($result->data)) {
            foreach ($result->data as $key => $value) {
                $userDetail = User::where('ref_code', '!=', $value->ref_code)->update(['cardRequest' => 0]);
            }
        }
    }


    public function passwordReminder()
    {
        $getUsers = User::where('pass_date', '!=', null)->where('disableAccount', '!=', 'on')->where('countryapproval', 1)->get();

        $today = date('Y-m-d');
        foreach ($getUsers as $users) {
            $passDate = date('Y-m-d', strtotime($users->pass_date));
            $nextTwoWeeks = date('Y-m-d', strtotime($passDate . ' + 14 days'));
            $passChecker = $users->pass_checker + 1;

            if ($users->pass_date != null) {
                if ($today > $passDate) {
                    // Update Passdate
                    User::where('id', $users->id)->update(['pass_date' => $nextTwoWeeks, 'pass_checker' => $passChecker]);
                    // Send Mail

                    $this->name = $users->name;
                    $this->email = $users->email;
                    // $this->email = 'adenugaadebambo41@gmail.com';
                    $this->subject = "Kindly reset your password on PaySprint";

                    $this->message = '<p>We wish to notify you to change or reset your password on PaySprint for security resasons.</p><p><a href=' . route('password.request') . ' class="text-primary" style="text-decoration: underline">Click here to reset your password</a></p>';

                    $this->sendEmail($this->email, "Incomplete Setup");

                    // Log::info('Reset Password Mail Sent to '.$this->name);

                    $this->slack('Reset Password Mail Sent to ' . $this->name, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
                } else {
                }
            } else {
                // DO nothing
            }
        }
    }


    // Update EPS Vendor
    // public function updateEPSVendor(){
    //     $data = $this->getVendors();
    // }


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


    public function getPathAddress()
    {

        try {
            $query = User::all();

            foreach ($query as $data) {
                $avatar = $data->avatar;
                if ($avatar != null) {
                    $pattern = "/paysprint.net/";
                    $replacements = "paysprint.ca";

                    $this->replaceUrl($pattern, $replacements, $avatar, $data->id, "avatar");
                }
                $nin_front = $data->nin_front;

                if ($nin_front != null) {
                    $pattern = "/paysprint.net/";
                    $replacements = "paysprint.ca";

                    $this->replaceUrl($pattern, $replacements, $nin_front, $data->id, "nin_front");
                }
                $drivers_license_front = $data->drivers_license_front;
                if ($drivers_license_front != null) {
                    $pattern = "/paysprint.net/";
                    $replacements = "paysprint.ca";

                    $this->replaceUrl($pattern, $replacements, $drivers_license_front, $data->id, "drivers_license_front");
                }
                $drivers_license_back = $data->drivers_license_back;
                if ($drivers_license_back != null) {
                    $pattern = "/paysprint.net/";
                    $replacements = "paysprint.ca";

                    $this->replaceUrl($pattern, $replacements, $drivers_license_back, $data->id, "drivers_license_back");
                }
                $international_passport_front = $data->international_passport_front;
                if ($international_passport_front != null) {
                    $pattern = "/paysprint.net/";
                    $replacements = "paysprint.ca";

                    $this->replaceUrl($pattern, $replacements, $international_passport_front, $data->id, "international_passport_front");
                }
                $nin_back = $data->nin_back;
                if ($nin_back != null) {
                    $pattern = "/paysprint.net/";
                    $replacements = "paysprint.ca";

                    $this->replaceUrl($pattern, $replacements, $nin_back, $data->id, "nin_back");
                }
                $international_passport_back = $data->international_passport_back;
                if ($international_passport_back != null) {
                    $pattern = "/paysprint.net/";
                    $replacements = "paysprint.ca";

                    $this->replaceUrl($pattern, $replacements, $international_passport_back, $data->id, "international_passport_back");
                }
                $incorporation_doc_front = $data->incorporation_doc_front;
                if ($incorporation_doc_front != null) {
                    $pattern = "/paysprint.net/";
                    $replacements = "paysprint.ca";

                    $this->replaceUrl($pattern, $replacements, $incorporation_doc_front, $data->id, "incorporation_doc_front");
                }
                $incorporation_doc_back = $data->incorporation_doc_back;
                if ($incorporation_doc_back != null) {
                    $pattern = "/paysprint.net/";
                    $replacements = "paysprint.ca";

                    $this->replaceUrl($pattern, $replacements, $incorporation_doc_back, $data->id, "incorporation_doc_back");
                }
                $directors_document = $data->directors_document;
                if ($directors_document != null) {
                    $pattern = "/paysprint.net/";
                    $replacements = "paysprint.ca";

                    $this->replaceUrl($pattern, $replacements, $directors_document, $data->id, "directors_document");
                }
                $shareholders_document = $data->shareholders_document;
                if ($shareholders_document != null) {
                    $pattern = "/paysprint.net/";
                    $replacements = "paysprint.ca";

                    $this->replaceUrl($pattern, $replacements, $shareholders_document, $data->id, "shareholders_document");
                }
                $proof_of_identity_1 = $data->proof_of_identity_1;
                if ($proof_of_identity_1 != null) {
                    $pattern = "/paysprint.net/";
                    $replacements = "paysprint.ca";

                    $this->replaceUrl($pattern, $replacements, $proof_of_identity_1, $data->id, "proof_of_identity_1");
                }
                $proof_of_identity_2 = $data->proof_of_identity_2;
                if ($proof_of_identity_2 != null) {
                    $pattern = "/paysprint.net/";
                    $replacements = "paysprint.ca";

                    $this->replaceUrl($pattern, $replacements, $proof_of_identity_2, $data->id, "proof_of_identity_2");
                }
                $aml_policy = $data->aml_policy;
                if ($aml_policy != null) {
                    $pattern = "/paysprint.net/";
                    $replacements = "paysprint.ca";

                    $this->replaceUrl($pattern, $replacements, $aml_policy, $data->id, "aml_policy");
                }
                $compliance_audit_report = $data->compliance_audit_report;
                if ($compliance_audit_report != null) {
                    $pattern = "/paysprint.net/";
                    $replacements = "paysprint.ca";

                    $this->replaceUrl($pattern, $replacements, $compliance_audit_report, $data->id, "compliance_audit_report");
                }
                $organizational_chart = $data->organizational_chart;
                if ($organizational_chart != null) {
                    $pattern = "/paysprint.net/";
                    $replacements = "paysprint.ca";

                    $this->replaceUrl($pattern, $replacements, $organizational_chart, $data->id, "organizational_chart");
                }
                $financial_license = $data->financial_license;
                if ($financial_license != null) {
                    $pattern = "/paysprint.net/";
                    $replacements = "paysprint.ca";

                    $this->replaceUrl($pattern, $replacements, $financial_license, $data->id, "financial_license");
                }



                echo "Done for: " . $data->name . ". With ID: " . $data->id . "<hr>";
            }
        } catch (\Throwable $th) {
            echo "Error: " . $th->getMessage();
        }
    }


    public function replaceUrl($patterns, $replacements, $string, $id, $queryString)
    {
        if ($patterns != null) {
            $replace = preg_replace($patterns, $replacements, $string);

            User::where('id', $id)->update([$queryString => $replace]);


            return $replace;
        }
    }


    public function monthlyTransactionHistory()
    {

        // Get Statement Information
        $getusers = User::inRandomOrder()->orderBy('created_at', 'DESC')->get();


        if (count($getusers) > 0) {
            $from = date('Y-m-01');
            $nextDay = date('Y-m-d');

            foreach ($getusers as $key => $value) {

                $email = $value->email;




                $myStatement = Statement::where('user_id', $email)->whereBetween('trans_date', [$from, $nextDay])->orderBy('created_at', 'DESC')->get();

                if (count($myStatement) > 0) {
                    // Send Mail

                    $walletBalance = $value->wallet_balance;
                    $currencyCode = $value->currencyCode;

                    $name = $value->name;
                    $subject = "Your monthly statement on PaySprint";

                    $tabledetails = "";
                    $table = "";

                    foreach ($myStatement as $key => $valueAdded) {


                        if ($valueAdded->credit != 0) {
                            $color = "green";
                            $amount = "+" . $currencyCode . number_format($valueAdded->credit, 2);
                        } elseif ($valueAdded->debit != 0) {
                            $color = "red";
                            $amount = "-" . $currencyCode . number_format($valueAdded->debit, 2);
                        }

                        $tabledetails = "<tr>
		    			<td>" . date('d/F/Y', strtotime($valueAdded->trans_date)) . "</td>
		    			<td>" . $valueAdded->activity . "</td>
		    			<td style='color:" . $color . "; font-weight: bold;' align='center'>" . $amount . "</td>
		    			<td>" . $valueAdded->status . "</td>
		    			</tr>";

                        $table .= $tabledetails;
                    }


                    $message = "<p>Below is the statement of your transactions on PaySprint for this month.</p> <br> <table width='700' border='1' cellpadding='1' cellspacing='0'><thead><tr><th>Trans. Date</th><th>Desc.</th><th>Amount</th><th>Status</th></tr></thead><tbody>" . $table . "</tbody></table> <br><br> Thanks <br><br> Client Services Team <br> PaySprint <br><br>";



                    $this->mailprocess($email, $name, $subject, $message);
                }
            }
        } else {

            // Do nothing
        }
    }


    public function migrateUsersToLevelOne()
    {

        $user = User::where('accountLevel', 0)->get();


        foreach ($user as $users) {
            // Check Country Approval
            $checkCountry = AllCountries::where('name', $users->country)->where('approval', 1)->first();


            if (isset($checkCountry) == true) {
                // Update User
                User::where('id', $users->id)->update(['accountLevel' => 2, 'countryApproval' => 1]);
            }
        }

        echo "Done migration";
    }


    // Copy special information details
    public function insertspecialinfoActivity()
    {

        $country = AllCountries::all();

        $getInfo = SpecialInformation::where('country', "United States")->first();

        foreach ($country as $countries) {
            SpecialInformation::updateOrCreate(['country' => $countries->name], [
                'country' => $countries->name,
                'information' => $getInfo->information
            ]);
        }

        echo "Done Insertion";
    }


    public function existingAccounts()
    {
        $getUsers = User::where('created_at', '<', date('Y-m-d', strtotime('-30 days')))->get();

        foreach ($getUsers as $users) {
            if ($users->accountType == "Individual") {
                $category = "Existing Consumers";
            } else {
                $category = "Existing Merchants";
            }

            $this->mailListCategorize($users->name, $users->email, $users->address, $users->telephone, $category, $users->country, 'Subscription');
        }
    }



    public function mailprocess($email, $name, $subject, $message)
    {

        $this->email = $email;
        // $this->email = "bambo@vimfile.com";
        $this->name = $name;
        $this->subject = $subject;

        $this->message = $message;

        $this->sendEmail($this->email, "Incomplete Setup");


        // Log::info('Monthly Transaction Statement: '.$this->name."\n Message: ".$message);

        $this->slack('Monthly Transaction Statement: ' . $this->name . "\n Message: " . $message, $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
    }


    // Update Transaction Limit
    public function dailyLimit()
    {
        $getUsers = User::all();

        foreach ($getUsers as $getUser) {
            User::where('id', $getUser->id)->update(['withdrawal_per_day' => 0]);
        }

        $this->slack('Daily Transaction Limit Executed: ' . date('d/m/Y'), $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
    }

    public function weeklyLimit()
    {
        $getUsers = User::all();

        foreach ($getUsers as $getUser) {
            User::where('id', $getUser->id)->update(['withdrawal_per_week' => 0]);
        }

        $this->slack('Weekly Transaction Limit Executed: ' . date('D'), $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
    }

    public function monthlyLimit()
    {
        $getUsers = User::all();

        foreach ($getUsers as $getUser) {
            User::where('id', $getUser->id)->update(['withdrawal_per_month' => 0]);
        }

        $this->slack('Monthly Transaction Limit Executed: ' . date('F/Y'), $room = "success-logs", $icon = ":longbox:", env('LOG_SLACK_SUCCESS_URL'));
    }



    // Update Notification Table
    public function notificationTable()
    {
        $data = $this->updateNotificationTable();
    }

    public function notificationPeriod()
    {
        $data = $this->updateNotificationPeriod();
    }


    public function insStatement($email, $reference_code, $activity, $credit, $debit, $balance, $trans_date, $status, $action, $regards, $state, $statement_route, $auto_deposit)
    {
        Statement::insert(['user_id' => $email, 'reference_code' => $reference_code, 'activity' => $activity, 'credit' => $credit, 'debit' => $debit, 'balance' => $balance, 'trans_date' => $trans_date, 'status' => $status, 'action' => $action, 'regards' => $regards, 'state' => $state, 'statement_route' => $statement_route, 'auto_deposit' => $auto_deposit]);
    }


    public function sendEmail($objDemoa, $purpose)
    {
        $objDemo = new \stdClass();
        $objDemo->purpose = $purpose;

        if ($purpose == 'Incomplete Setup') {
            $objDemo->name = $this->name;
            $objDemo->email = $this->email;
            $objDemo->subject = $this->subject;
            $objDemo->message = $this->message;
        }


        Mail::to($objDemoa)
            ->send(new sendEmail($objDemo));
    }
}
