<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReferralClaim extends Model
{
    use SoftDeletes;
    //

    protected $Fillable=[
        'user_id',
        'points_acquired',
        'points_claimed',
        'points_left',
    ];
}
