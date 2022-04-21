<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    protected $guarded = [];
    protected $table = "verification_code";
}