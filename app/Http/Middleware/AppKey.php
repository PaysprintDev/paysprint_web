<?php

namespace App\Http\Middleware;

use Closure;

class AppKey
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
        $token = $request->bearerToken();

        if(isset($token) == true){


            if($token != env('APP_KEY')){
                
                return response()->json(['message' => 'Invalid Authorization Key'], 401);
            }

        }
        else{
            return response()->json(['message' => 'Please provide Authorization Key'], 401);
        }


        return $next($request);
    }
}
