<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceMainStore extends Model
{
    protected $guarded = [];

    protected $table = 'service_main_stores';

    use SoftDeletes;
}