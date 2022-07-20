<?php

namespace App\Traits;

use App\AllCountries;
use App\ReferralGenerate;
use App\ReferredUsers;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

use App\ClientInfo as ClientInfo;
use App\ProductTax;
use App\SuperAdmin as SuperAdmin;
use App\User;
use App\ServiceMainStore;
use App\ServiceStoreTestimony;

trait ServiceStoreShop
{

    public function uploadItems($file, $fileroute, $width = null, $height = null)
    {

        try {
            //Get filename with extension
            $filenameWithExt = $file->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $file->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = rand() . '_' . time() . '.' . $extension;

            $img = Image::make($file)->fit($width, $height);

            $img->save('servicestore/' . $fileroute . '/' . $fileNameToStore);

            // $file->move(public_path('../../servicestore/' . $fileroute . '/'), $fileNameToStore);


            $docPath = route('home') . "/servicestore/" . $fileroute . "/" . $fileNameToStore;
        } catch (\Throwable $th) {
            //Get filename with extension
            $filenameWithExt = $file->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just extension
            $extension = $file->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = rand() . '_' . time() . '.' . $extension;


            $path = $file->move(public_path('../../servicestore/' . $fileroute . '/'), $fileNameToStore);


            $docPath = route('home') . "/servicestore/" . $fileroute . "/" . $fileNameToStore;
        }


        return $docPath;
    }

    public function getServiceStore($id)
    {
        $data = ServiceMainStore::where('merchantId', $id)->first();

        return $data;
    }

    public function getServiceTestimony($id)
    {
        $data = ServiceStoreTestimony::where('merchantId', $id)->orderBy('created_at', 'DESC')->get();

        return $data;
    }

    public function getMyServiceStore($id)
    {

        $data = ServiceMainStore::where('merchantId', $id)->where('publish', true)->where('status', 'active')->first();

        return $data;
    }
}
