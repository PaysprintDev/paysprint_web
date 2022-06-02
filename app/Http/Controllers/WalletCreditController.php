<?php

namespace App\Http\Controllers;
use App\SurveyExcel;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SurveyImport;


use Illuminate\Http\Request;

class WalletCreditController extends Controller
{
    public function Excelpage(Request $req){
        return view('walletcredit.promopage');
    }

    public function uploadExcel(Request $req){
        $validation=$req->validate([
            'excel_document' => 'required'
        ]);

        $query = $req->all();


        $data=Excel::import(new SurveyImport($query), $req->file('excel_document'));


        return back()->with("msg", "<div>uploaded Successfully</div>");
    }
}
