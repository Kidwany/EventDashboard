<?php


namespace App\Classes;

use App\User;
use Illuminate\Support\Facades\Auth;

class UserSetting
{

    public static function userLanguage()
    {

        if ($authenticatedUser = Auth::user())
        {
            //return $userLang = User::where('id', $authenticatedUser->id)->first()->lang;
            $userLang = User::where('id', $authenticatedUser->id)->first()->lang;
            if($userLang){
                return $userLang = $authenticatedUser->lang;
            }else{
                return 'ar';
            }

        }

        else
        {
            return 'ar';
        }
    }

}
