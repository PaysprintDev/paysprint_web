<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contactus extends Model
{
    protected $fillable = ['name', 'email', 'subject', 'website', 'message', 'created_at', 'updated_at'];

    protected $table = "contactus";
}
