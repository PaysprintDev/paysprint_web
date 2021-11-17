<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Session;
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        // $this->updateToken();

    }

    // Update Token
    // public function updateToken(){

    //     $email = request()->input('email');

    //     User::where()->update(['api_token' => uniqid().time().md5($email)]);

    // }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }
}