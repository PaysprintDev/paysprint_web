<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionCost extends Model
{
    protected $fillable = ['variable', 'fixed', 'created_at', 'updated_at'];

    protected $table = "transaction_cost";
}
