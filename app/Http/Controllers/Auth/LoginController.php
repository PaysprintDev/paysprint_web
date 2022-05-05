<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


use App\User as User;

class LoginController extends Controller
{



    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */


    // protected $redirectTo = '/verification';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->redirectTo = url()->previous();
        $this->middleware('guest')->except('logout');
    }


    public function redirectTo()
    {
        if (env('APP_ENV') == 'local') {
            return '/';
        } else {
            return '/verification';
        }
    }




    public function logout(Request $request)
    {

        if (Auth::check() == true && Auth::user()->accountType == "Individual") {
            $home = '/';
        } else {
            $home = '/AdminLogin';
        }

        Auth::logout();
        Session::flush();
        return redirect($home);
    }
}