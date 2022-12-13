<?php

namespace App\Traits;

use Illuminate\Http\Request;

use App\User as User;
use App\FxStatement;
use App\ConversionCountry;
use App\AllCountries;
use App\Statement;
use App\Http\Controllers\Controller;



trait AccountReport
{

		public function totalTransaction($country)
		{
			$currency=AllCountries::where('name',$country)->first();
			
			$converter=new Controller();

			$rate=$converter->currencyConvert($currency->currencyCode,1);
			
			$activecountry=AllCountries::where('approval','1')->get();

			$sum = 0;

			$addedAmount = Statement::where('country', $currency->name)->where('report_status', 'Added to wallet')->sum('credit');
			
       		$receivedAmount = Statement::where('country', $currency->name)->where('report_status', 'Money received')->sum('credit');
		
		
        	$debitedAmount = Statement::where('country', $currency->name)->where('report_status', 'Withdraw from wallet')->sum('debit');

       	 	$monthlyAmount = Statement::where('country', $currency->name)->where('report_status', 'Monthly fee')->sum('debit');


        	$sendInvoice = Statement::where('country', $currency->name)->where('action', 'Invoice')->sum('credit');

		
        	$withdrawAmount = Statement::where('country', $currency->name)->where('report_status', 'Withdraw from wallet')->sum('debit');


        	$credits = $addedAmount + $receivedAmount + $sendInvoice + ($debitedAmount - $monthlyAmount - $withdrawAmount);

		
			$sum= $credits;

			
			$fxcredit=FxStatement::where('country',$currency->name)->sum('credit');
			
        	$fxdebit=FxStatement::where('country',$currency->name)->sum('debit');

			$totalsum=$sum;
			
			$totaltransact=$totalsum+$fxcredit-$fxdebit;
			
			$totalmoneydone=$totaltransact;

			return number_format($totalmoneydone,2);
				
		}

		public function TotalCountryVariation($country)
		{
		
        $addedAmount = Statement::where('country', $country)->where('report_status', 'Added to wallet')->sum('credit');
        $receivedAmount = Statement::where('country', $country)->where('report_status', 'Money received')->sum('credit');
        $debitedAmount = Statement::where('country', $country)->where('report_status', 'Withdraw from wallet')->sum('debit');
        $monthlyAmount = Statement::where('country', $country)->where('report_status', 'Monthly fee')->sum('debit');
        $sendInvoice = Statement::where('country', $country)->where('action', 'Invoice')->sum('credit');
        $withdrawAmount = Statement::where('country', $country)->where('report_status', 'Withdraw from wallet')->sum('debit');
         $credits = $addedAmount + $receivedAmount + $sendInvoice + (- $debitedAmount - $monthlyAmount - $withdrawAmount);
         return number_format($credits,2);
		}
 
}