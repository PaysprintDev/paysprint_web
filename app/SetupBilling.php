<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SetupBilling extends Model
{
    protected $fillable = ['name', 'email', 'ref_code', 'service', 'invoice_no', 'date', 'description', 'amount', 'created_at', 'updated_at'];

    protected $table = "billing_setup";
}
