<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    protected $guarded = [];


    public function path(){
        
        return $this->id;
    }


    protected $table = "consultant";
}
