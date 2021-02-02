<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientInfo extends Model
{
    protected $fillable = ['user_id', 'business_name', 'address', 'corporate_type', 'firstname', 'lastname', 'email', 'country', 'state', 'city', 'zip_code', 'card_balance', 'created_at', 'updated_at'];

    protected $table = "client_info";
}

