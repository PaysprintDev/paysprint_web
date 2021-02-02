<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = ['user_id', 'firstname', 'lastname', 'username', 'password', 'role', 'email', 'created_at', 'updated_at'];

    protected $table = "admin_payca";
}
