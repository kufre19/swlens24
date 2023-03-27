<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait AssignLoggedUser {



    public function whoslogged()
    {

        if(Auth::user())
        {
         $user = Auth::user();
        }
        session()->put("logged_user_type","admin");

        if($user->is_admin == 1)
        {
            session()->put("logged_user_type","admin");

        }


        if($user->is_staff == 1)
        {
            session()->put("logged_user_type","staff");
        }

        if($user->is_super_admin == 1)
        {
            session()->put("logged_user_type","super_admin");
        }
    }
}
