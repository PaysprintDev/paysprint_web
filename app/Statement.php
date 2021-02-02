<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    protected $fillable = ['user_id', 'reference_code', 'activity', 'credit', 'debit', 'balance', 'trans_date', 'created_at', 'updated_at'];

    protected $table = "statement";
}
