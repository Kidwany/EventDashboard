<?php


namespace App\Classes;


use App\Models\User;
use Carbon\Carbon;

class Subscription
{
    private $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }


    public function isSubscriptionExist(){
        $user = User::with('userSubscription')->where('id',$this->user_id)->first();
        $userPackage = $user->userSubscription;
        if($userPackage !=null){

        }else{
            return response()->json(
                [
                'status'=>439,'error'=>"you have to subscribe for your suitable Package first",
                'success'=>null,'is_success'=>false
            ]
                ,439);
        }

        //$package = $user->subscribePackage;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @description to check if subscription is ended or not
     */
    public function isEnded(){
        $current_date = Carbon::now();
        $user = User::with('userSubscription')->where('id',$this->user_id)->first();

        /** user in user_subscription table */
        $userPackage = $user->userSubscription;
        /** subscribe_package table itself with user through hasOneThrough relationship */
        $package = $user->subscribePackage;

        /**
         *  The difference between current month and the month
         ** that the user subscribed to this package .
         *** that if we make subscription duration measure by month.
         *
         */
        if ($userPackage){
            $diff_months =  $current_date->diffInMonths($userPackage->created_at);
            if($diff_months > $package->duration)
            {
                return response()->json(['status'=>440,'error'=>"Your Subscription had been Ended Please Renew Your Subscription"],440);
            }
            return true;
        }
        return "not subscribed";


    }

}
