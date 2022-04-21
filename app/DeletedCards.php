<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeletedCards extends Model
{
    protected $guarded = [];

    protected $table = "deleted_cards";
}
