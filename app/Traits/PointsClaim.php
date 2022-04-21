<?php


namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

use App\Points as Points;
use App\ClaimedPoints as ClaimedPoints;
use App\User;

trait PointsClaim
{
    public function updateReward($user_id, $activity)
    {
        $pointAcquired = ClaimedPoints::where('user_id', $user_id)->first();

        if (isset($pointAcquired)) {
            $myAcquiredPoint = $pointAcquired->points_acquired;
        }
    }


    public function getClaimedPoints()
    {
        $data = ClaimedPoints::where('status', 'pending')->get();

        return $data;
    }

    
}