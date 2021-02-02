<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    protected $fillable = ['transactionid', 'name', 'email', 'amount', 'invoice_no', 'service', 'mystatus', 'client_id', 'opening_balance', 'remaining_balance', 'withdraws', 'created_at', 'updated_at'];

    protected $table = "invoice_payment";
}


