<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTax extends Model
{
    protected $guarded = [];
    protected $table = "product_tax";

    use SoftDeletes;
}