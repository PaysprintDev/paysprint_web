<?php

namespace App\Http\Middleware;

use Closure;

class MerchantKey
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

            $merchant = \App\ClientInfo::where('api_secrete_key', $token)->first();


            if(!$merchant){
                return response()->json(['message' => 'Invalid Authorization Key'], 401);
            }

        }
        else{
            return response()->json(['message' => 'Please provide Authorization Key'], 401);
        }


        return $next($request);
    }
}
