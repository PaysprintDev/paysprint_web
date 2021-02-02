<?php

namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Session;

use App\User as User;

use App\CreateEvent as CreateEvent;

use App\ImportExcel as ImportExcel;

use App\SetupBilling as SetupBilling;

use App\InvoicePayment as InvoicePayment;

use App\ClientInfo as ClientInfo;

use App\OrganizationPay as OrganizationPay;

use App\Contactus as Contactus;

use App\Bronchure as Bronchure;

use App\ServiceType as ServiceType;

use App\Statement as Statement;

use App\MaintenanceRequest as MaintenanceRequest;

use App\Consultant as Consultant;

use App\Workorder as Workorder;

use App\RentalQuote as RentalQuote;

use App\Building as Building;


trait RpmApp{

    public function getFacility(){
        $allfacility = Building::orderBy('created_at', 'DESC')->get();

        return $allfacility;
    }
    


}

