<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Points;
use App\Traits\StatementMail;

class StatementMailController extends Controller
{

    use StatementMail;

    public function useStatement()
    {
        //    $id=Auth::id();
        $users=User::get();
    
        if( count($users) > 0){
            foreach ($users as $user) {
                    $userrecord=User::where('id', $user->id)->first();
                    $email=$userrecord->email;
                    $name=$userrecord->name;
                $point= Points::where('user_id', $user->id)->first();
                $pointacquired = $point->points_acquired;
                $this->statement($email,$pointacquired,$name);
            }
        }
       


        

        

      
    }

    
}