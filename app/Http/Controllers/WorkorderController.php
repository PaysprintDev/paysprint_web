<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;

use App\Mail\sendEmail;

use App\Consultant as Consultant;

use App\MaintenanceRequest as MaintenanceRequest;

use App\RentalMessage as RentalMessage;

use App\Workorder as Workorder;

use App\ImportExcel as ImportExcel;

use App\ClientInfo as ClientInfo;

class WorkorderController extends Controller
{
    public function controlInvoice(Request $req){

        $data = ClientInfo::all();



        if (count($data) > 0) {
            try {
                foreach($data as $value => $key){
                    ImportExcel::where('uploaded_by', $key->user_id)->update(['merchantName' => $key->business_name]);
                }
                echo "Updated !!";
            } catch (\Throwable $th) {
                echo "Errror => ".$th;
            }
        }
        else{
            echo "No record";
        }
    }
}
