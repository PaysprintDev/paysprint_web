<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use Illuminate\Support\Facades\DB;

use App\User as User;
use App\Statement as Statement;
use App\Notifications as Notifications;

use App\Traits\Xwireless;

class NotificationController extends Controller
{

    use Xwireless;

    public function getNotifications(Request $req)
    {

        $user = User::where('api_token', $req->bearerToken())->first();

        if (isset($user)) {

            $data = Notifications::where('ref_code', $user->ref_code)->orderBy('notify', 'ASC')->orderBy('created_at', 'DESC')->take(200)->get();

            if (count($data) > 0) {

                $status = 200;

                $resData = ['data' => $data, 'message' => 'success', 'status' => $status];
            } else {
                $status = 404;

                $resData = ['data' => [], 'message' => 'No new notification', 'status' => $status];
            }
        } else {
            $status = 400;

            $resData = ['data' => [], 'message' => 'Token mismatch', 'status' => $status];
        }

        return $this->returnJSON($resData, $status);
    }
}