<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApplePayController extends Controller
{
    public function ajaxcharges(Request $req)
    {
        dd($req->all());
    }
}
