<?php


namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\MonerisActivity as MonerisActivity;

use App\BankWithdrawal as BankWithdrawal;

use App\Statement as Statement;

use App\PricingSetup as PricingSetup;

use App\User as User;

use Newsletter;
use Mailchimp;

trait MailChimpNewsLetter
{
    public function mailListCategorize($name, $email, $address, $phone, $tags, $country, $list)
    {
        $username = explode(" ", $name);

        if (isset($username[1])) {
            $result = Newsletter::subscribeOrUpdate($email, ['FNAME' => $username[0], 'LNAME' => $username[1], 'ADDRESS' => $address, 'PHONE' => $phone, 'CATEGORY' => $tags, 'COUNTRY' => $country], $list);
        } else {
            $result = Newsletter::subscribeOrUpdate($email, ['FNAME' => $name, 'LNAME' => "", 'ADDRESS' => $address, 'PHONE' => $phone, 'CATEGORY' => $tags, 'COUNTRY' => $country], $list);
        }



        return $result;
    }

    public function sendCampaign($subject, $html, $category)
    {

        try {

            $listId = env('MAILCHIMP_LIST_ID');

            $mailchimp = new Mailchimp(env('MAILCHIMP_KEY'));



            $campaign = $mailchimp->campaigns->create('regular', [
                'list_id' => $listId,
                'subject' => $subject,
                'category' => $category,
                'from_email' => 'info@exbc.ca',
                'from_name' => 'EXBC Team',

            ], [
                'html' => $html,
                'text' => strip_tags($html)
            ]);


            //Send campaign
            $mailchimp->campaigns->send($campaign['id']);

            return 'Campaign sent successfully.';
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}