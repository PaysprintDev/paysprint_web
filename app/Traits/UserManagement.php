<?php

namespace App\Traits;


use Carbon\Carbon;
use App\UpgradePlan;


trait UserManagement
{



    public function getPaidUsersList()
    {
        $data = UpgradePlan::where('expire_date', '>=', $this->todaysNewDate())->where('amount', '>', 0)->where('plan', 'classic')->groupBy('userId')->get();

        return $data;
    }


    public function getFreeUsersList()
    {
        $data = UpgradePlan::where('amount', 0)->groupBy('userId')->get();

        return $data;
    }


    public function getPaidUsersCount()
    {
        $data = count($this->getPaidUsersList());

        return $data;
    }


    public function getFreeUsersCount()
    {
        $data = count($this->getFreeUsersList());

        return $data;
    }


    public function todaysNewDate()
    {
        $data = Carbon::now()->toDateTimeString();

        return $data;
    }

}
