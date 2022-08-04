<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlatformPaymentGateway extends Model
{
    protected $guarded = [];

    protected $table = 'payment_gateways';
}
