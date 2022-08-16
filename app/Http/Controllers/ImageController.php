<?php

namespace App\Http\Controllers;

use App\Image as AppImage;
use Illuminate\Http\Request;
use App\Models\Image;
use App\User as User;

class ImageController extends Controller
{



    public function imageUploadPost(Request $request)
    {


        try {

            $userController = new api\v1\UserController();


        switch ($request->docType) {
            case 'avatar':
                $userController->uploadDocument($request->user_id, $request->file('image'), 'profilepic/avatar', 'avatar');
                break;

            default:
                $userController->uploadDocument($request->user_id, $request->file('image'), 'document/'.$request->docType, $request->docType);
                break;
        }


        $data = ['res' => 'success', 'message' => 'Successfully uploaded'];
        $status = 200;


        } catch (\Throwable $th) {
            //throw $th;
            $data = ['res' => 'fail', 'message' => $th->getMessage()];
        $status = 400;
        }



        return $this->returnJSON($data, $status);

    }
}
