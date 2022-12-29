<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\VtPass;

class VTPassController extends Controller
{
    use VtPass;

    public function vtPassBalance()
    {

        $data = $this->getBalance();

        return $data;
    }

    public function getServices()
    {

        $data = $this->getServiceCategories();

        return $data;
    }

    public function getServiceId($identifier)
    {
        $data = $this->getByServiceId($identifier);

        return $data;
    }

    public function getVariationCodes($serviceId)
    {
        $data = $this->getVariationCodeByServiceId($serviceId);

        return $data;
    }

    public function getProductOption($serviceId, $name)
    {
        $data = $this->productOption($serviceId, $name);

        return $data;
    }

    public function purchaseProduct($bodyData)
    {
        $data = $this->productPurcahse($bodyData);

        return $data;
    }
}
