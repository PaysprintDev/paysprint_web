<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreMainShop extends Model
{
    
    protected $guarded = [];

    protected $table = "estore_main_shop";

    use SoftDeletes;
}