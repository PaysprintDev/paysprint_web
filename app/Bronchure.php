<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bronchure extends Model
{
    protected $fillable = ['name', 'email', 'status', 'created_at', 'updated_at'];

    protected $table = "bronchure";
}
