<?php
/**
 * Created by PhpStorm.
 * User: Kidwany
 * Date: 10/10/2020
 * Time: 2:58 AM
 */

namespace App\Classes;


use App\Models\ProfileViews;
use App\Models\TotalPackageConsumption;
use Illuminate\Support\Facades\Auth;

class CheckPackage
{

    /**
     * @return int
     */
    public static function isUserSubscribed()
    {
        $user = Auth::user();
        if ($user->package_id)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    /**
     * @return TotalPackageConsumption
     */
    public static function checkPackageConsumption()
    {
        $consumption = TotalPackageConsumption::where('organization_id', Auth::user()->id)->first();
        if ($consumption)
        {
            return $consumption;
        }
        else
        {
            $consumption = new TotalPackageConsumption();
            $consumption->organization_id = Auth::user()->id;
            $consumption->total_events = 0;
            $consumption->total_views = 0;
            $consumption->total_views = 0;
            $consumption->save();

            return $consumption;
        }
    }

    /**
     * @param $user_id
     * @return int
     */
    public static function checkProfileView($user_id)
    {
        $view = ProfileViews::where('company_id', Auth::user()->id)->where('sp_id', $user_id)->first();
        if ($view)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

}
