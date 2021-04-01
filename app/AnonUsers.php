<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnonUsers extends Model
{
    protected $guarded = [];

    protected $table = "anonusers";
}
