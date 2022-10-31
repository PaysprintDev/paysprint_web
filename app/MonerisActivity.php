<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MonerisActivity extends Model
{

    use SoftDeletes;

    protected $guarded = [];

    protected $table = "moneris_activity";
}
