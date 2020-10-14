<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\CalculateTotalBreakTime;
use App\Classes\ErrorClass;
use App\Classes\UserSetting;
use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Event;
use App\Models\EventAttendRequest;
use App\Models\EventImages;
use App\Models\File;
use App\Models\GroupAttaches;
use App\Models\GuardianShip;
use App\Models\Image;
use App\Models\Package;
use App\Models\ServiceProviderExperience;
use App\Models\TotalPackageConsumption;
use App\Models\User;
use App\Models\UserDocuments;
use App\Models\UserGroup;
use App\Models\UserPaymentInfo;
use App\Models\UserRest;
use App\Models\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::all()->where('is_active', 1);
        return view('dashboard.package.index', compact('packages'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|string
     */
    public function subscribe(Request $request)
    {
        $package = Package::findOrFail(\request('package_id'));

        try{

            DB::beginTransaction();

            $total_package_consumption = TotalPackageConsumption
                ::where('organization_id', Auth::user()->id)
                ->first();

            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['package_id' => \request('package_id')]);

            if ($total_package_consumption)
            {
                DB::table('total_package_consumption')
                    ->where('organization_id', Auth::user()->id)
                    ->increment('total_events', $package->events_no);

                DB::table('total_package_consumption')
                    ->where('organization_id', Auth::user()->id)
                    ->increment('total_views', $package->views_no);

                DB::table('total_package_consumption')
                    ->where('organization_id', Auth::user()->id)
                    ->increment('total_accounts', $package->users_no);
            }
            else
            {
                DB::table('total_package_consumption')->insertGetId([
                    'organization_id' => Auth::user()->id,
                    'package_id' => \request('package_id'),
                    'total_events' => $package->events_no,
                    'total_views' => $package->views_no,
                    'total_accounts' => $package->users_no,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            DB::table('organization_subscriptions')->insert([
                'organization_id' => Auth::user()->id,
                'package_id' => \request('package_id'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            DB::commit();

            return redirect()->back()->with('create', 'تم الإشتراك في الباقة بنجاح');

        }catch (\Exception $exception)
        {
            DB::rollBack();
            $error = new ErrorClass();
            return $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show()
    {
        $user = Auth::user();
        if ($user->package_id != null)
        {
            $package = Package::where('id', $user->package_id)->firstOrFail();
            $total_consumption = TotalPackageConsumption::where('organization_id', $user->id)->firstOrFail();
            $packages = Package::all()->where('is_active', 1)->where('is_main_package', null);
            return view('dashboard.package.show', compact('package', 'total_consumption', 'packages'));
        }
        else
        {
            return redirect('/')->with('exception', 'عفوا انت لست مشترك في اي من الباقات');
        }
    }

}
