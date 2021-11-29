<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;

class Verification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $user = \App\VerificationCode::where('user_id', Auth::id())->first();

        if (isset($user)) {
            return redirect()->route('verification page');
        }



        return $next($request);
    }
}