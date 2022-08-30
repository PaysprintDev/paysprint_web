<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class TriggerController extends Controller
{
    public function triggerDate(Request $req)
    {
        $userid = $req->user_id;


        $date = date('Y-m-d');

        $newdate = date('Y-m-d', strtotime($date . ' + 7 days'));

        user::where('id', $userid)->update([
            'subscription_trigger' => $newdate,
        ]);
    }
}
