<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Epaywithdraw extends Model
{
	protected $fillable = ['withdraw_id', 'client_id', 'client_name', 'card_method', 'client_email', 'amount_to_withdraw', 'amount_paid', 'remittance', 'created_at', 'updated_at'];

    protected $table = "epaywithdraw";
}



