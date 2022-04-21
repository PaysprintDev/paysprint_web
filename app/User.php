<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];


    public function usercard()
    {
        return $this->hasOne('App\AddCard', 'user_id');
    }

    public function userAccount()
    {
        return $this->hasOne('App\LinkAccount', 'user_id');
    }

    public function forexAccount(){
        return $this->hasMany('App\EscrowAccount', 'user_id');
    }

    protected $table = "users";
    
}