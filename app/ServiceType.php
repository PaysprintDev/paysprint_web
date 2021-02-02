<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    protected $fillable = ['name', 'created_at', 'updated_at'];


    protected $table = "service_type";
}
