<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Traits\SpecialInfo;

class ReferralsController extends Controller
{

    use SpecialInfo;

    public function index(Request $req, $ref_code)
    {
        $data = [
            'referlist' => $this->getListofReferred($ref_code)
        ];

        return view('main.myreferredlist')->with(['pages' => 'My Referred List',  'data' => $data]);
    }

    
}

// class ReferralsController extends Controller
// {

//     use SpecialInfo;

//     public function index(Request $req, $ref_code)
//     {
//         $data = [
//             'claimedhistory' => $this->getClaimedHistory($ref_code)
//         ];

//         return view('main.claimedhistory')->with(['pages' => 'Claimed History',  'data' => $data]);
//     }
// }

