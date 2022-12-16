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

		public function accountReport($country)
		{
			$currency=AllCountries::where('name',$country)->first();
			
			$converter=new Controller();

			$rate=$converter->currencyConvert($currency->currencyCode,1);
			
			$activecountry=AllCountries::where('approval','1')->get();

			$result=[];

			foreach( $activecountry as $allcountry){
				$added=$this->addedToWallet($country);
			}
				
		}

		public function addedToWallet($country)
		{
        $addedAmount = Statement::where('country', $country)->where('report_status', 'Added to wallet')->sum('credit');

         return number_format($addedAmount,2);
		}

		public function moneyReceived($country)
		{
			$receivedAmount = Statement::where('country', $country)->where('report_status', 'Money received')->sum('credit');

			return number_format($receivedAmount,2);
		}

		public function withdrawFromWallet($country)
		{
			$debitedAmount = Statement::where('country', $country)->where('report_status', 'Withdraw from wallet')->sum('debit');

			return number_format($debitedAmount,2);
		}

		public function monthlyFee($country)
		{
			$monthlyAmount = Statement::where('country', $country)->where('report_status', 'Monthly fee')->sum('debit');

			return number_format($monthlyAmount,2);
		}

		public function invoice($country)
		{
			 $monthlyAmount = Statement::where('country', $country)->where('report_status', 'Monthly fee')->sum('debit');

			 return number_format($monthlyAmount,2);
		}

 
}