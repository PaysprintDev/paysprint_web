<?php

namespace App\Http\Controllers;

use App\ClientInfo;
use App\User;
use App\PayoutAgent;
use Illuminate\Http\Request;

class PayoutAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PayoutAgent  $payoutAgent
     * @return \Illuminate\Http\Response
     */
    public function show(PayoutAgent $payoutAgent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PayoutAgent  $payoutAgent
     * @return \Illuminate\Http\Response
     */
    public function edit(PayoutAgent $payoutAgent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PayoutAgent  $payoutAgent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PayoutAgent $payoutAgent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PayoutAgent  $payoutAgent
     * @return \Illuminate\Http\Response
     */
    public function destroy(PayoutAgent $payoutAgent)
    {
        //
    }


    public function beAnAgent(Request $req, PayoutAgent $payoutAgent)
    {

        try {

            $thisuser = User::where('api_token', $req->bearerToken())->first();
            $thisclientInfo = ClientInfo::where('user_id', $thisuser->ref_code)->first();

            $payoutAgent->updateOrCreate(['user_id' => $req->ref_code], [
                'user_id' => $req->ref_code,
                'businessname' => $thisuser->businessname,
                'address' => $thisclientInfo->address,
                'city' => $thisclientInfo->city,
                'state' => $thisclientInfo->state,
                'country' => $thisclientInfo->country,
                'fee' => '1.50'
            ]);

            $data = $payoutAgent->where('user_id', $req->ref_code)->first();

            $message = 'Successfully registered as a payout agent in '.$thisuser->country;

            $status = 200;

        } catch (\Throwable $th) {
            $data = [];

            $message = $th->getMessage();

            $status = 400;
        }


        $resData = ['data' => $data, 'message' => $message, 'status' => $status];


        return $this->returnJSON($resData, $status);

    }
}
