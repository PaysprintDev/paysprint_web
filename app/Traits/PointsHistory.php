<?php


namespace App\Traits;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

use App\Points as Points;
use App\ClaimedPoints as ClaimedPoints;
use App\HistoryReport as HistoryReport;

use App\User;

trait PointsHistory
{

    public function getClaimedHistory($user_id)
    {
        $data = HistoryReport::where('user_id', $user_id)->paginate(10);

        return $data;
    }
}