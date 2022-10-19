<?php

namespace App\Traits;

use Illuminate\Http\Request;

use App\User as User;

trait AccountCheck
{

  public function checkingProfilePicture($id)
  {
		$details = User::where('id',$id)->first();
			$profilepicture =$details->avatar;
			return $profilepicture;

  }

   public function checkingIdentityCard($id)
  {
		$details = User::where('id',$id)->first();
			$nin=$details->nin_front;
			return $nin;

  }

   public function checkingInternationalPassport($id)
  {
		$details = User::where('id',$id)->first();
			$passport=$details->international_passport_front;
			return $passport;

  }

  public function checkingDrivingLicense($id)
  {
		$details = User::where('id',$id)->first();
			$license=$details->drivers_license_front;
			return $license;

  }
   public function checkingUtilityBill($id)
  {
		$details = User::where('id',$id)->first();
			$bill=$details->idvdoc;
			return $bill;

  }

   public function checkingBvn($id)
  {
		$details = User::where('id',$id)->first();
			$bvn=$details->bvn_number;
			return $bvn;

  }
}