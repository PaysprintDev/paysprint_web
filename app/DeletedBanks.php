<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeletedBanks extends Model
{
    protected $guarded = [];

    protected $table = "deleted_banks";
}
