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



        if ($request->file('image')) {
            //Get filename with extension
            $filenameWithExt = $request->file('image')->getClientOriginalName();

            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $request->file('image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = route('home') . "/idvdoc/" . rand() . '_' . time() . '.' . $extension;
            //Upload Image
            // $path = $request->file('image')->storeAs('public/idvdoc', $fileNameToStore);

            // $path = $request->file('image')->move(public_path('/idvdoc/'), $fileNameToStore);

            $path = $request->file('image')->move(public_path('../../idvdoc/'), $fileNameToStore);
        } else {
            $fileNameToStore = 'noImage.png';
        }

        // Perform database operation

        User::where('id', $request->user_id)->update(['idvdoc' => $fileNameToStore]);

        return redirect()->back()->with('success', 'Successfully uploaded!');
    }
}