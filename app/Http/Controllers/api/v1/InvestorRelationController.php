<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\InvestorRelation as InvestorRelation;

class InvestorRelationController extends Controller
{
    public function investorDetails(Request $req)
    {
        try {

            $validator = Validator::make($req->all(), [
                'name' => 'required|string',
                'email' => 'required|string',
                'phoneNumber' => 'required|string',
                'country' => 'required|string',
                'state' => 'required|string',
                'city' => 'required|string',
            ]);

            if ($validator->passes()) {
                // Update or Insert Investors record
                $doUpdate = InvestorRelation::updateOrInsert([
                    'email' => $req->email
                ], $req->all());

                // Get Data
                $data = InvestorRelation::where('email', $req->email)->first();
                $message = 'Success';
                $status = 200;
            } else {
                $error = implode(", ", $validator->messages()->all());

                $data = [];
                $status = 400;
                $message = $error;
            }
        } catch (\Throwable $th) {
            $data = [];
            $message = $th->getMessage();
            $status = 400;
        }

        $resData = ['data' => $data, 'message' => $message, 'status' => $status];

        return $this->returnJSON($resData, $status);
    }
}