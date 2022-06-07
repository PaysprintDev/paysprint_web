<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferralClaim extends Model
{
    //
    protected $Fillable=[
        'user_id',
        'points_acquired',
        'points_claimed',
        'points_left',
    ];
}
