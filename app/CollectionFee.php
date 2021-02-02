<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectionFee extends Model
{
    protected $fillable = ['collection_id', 'remittance_date', 'client_name', 'client_email', 'total_amount', 'total_remittance', 'total_fee', 'start_date', 'end_date', 'platform', 'created_at', 'updated_at'];

    protected $table = "collection_fee";
}
