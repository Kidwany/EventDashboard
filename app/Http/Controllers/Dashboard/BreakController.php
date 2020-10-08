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
use App\Models\ServiceProviderExperience;
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

class BreakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($event_id)
    {
        $event = Event::with('city')->findOrFail($event_id);
        $members = DB::table('event_attend_request')
            ->where('event_id', $event_id)
            ->where('status_id', 5)->pluck('user_id')->toArray();
        $users = User::all()->whereIn('id', $members)->where('role_id', 2);
        return view('dashboard.break.index', compact('users', 'event'));
    }


    /**
     * @param $event_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($event_id)
    {
        $event = Event::with('city')->findOrFail($event_id);

        $requests = DB::table('event_attend_request')
            ->where('status_id', 5)
            ->where('event_id', $event_id)
            ->pluck('user_id')->toArray();

        $users = User::with('image', 'city')
            ->orderBy('created_at', 'desc')
            ->where('role_id', 2)
            ->whereIn('id', $requests)
            ->get();

        return view('dashboard.break.create', compact('event', 'users'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Kreait\Firebase\Exception\ApiException
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name'         => 'required',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        DB::beginTransaction();

        try{

            $event = Event::find($request->event_id);

            $guardian_ship = new GuardianShip();
            $guardian_ship->season_id = $event->season_id;
            $guardian_ship->event_id = $event->id;
            $guardian_ship->supervisor_id = Auth::user()->id;
            $guardian_ship->sp_id = \request('member_id');
            $guardian_ship->name = \request('name');
            $guardian_ship->save();


            DB::commit();
            return redirect('break/' . $guardian_ship->event_id)->with('create', 'تم اضافة العهدة بنجاح');

        }catch (\Exception $exception)
        {
            DB::rollBack();
            $error = new ErrorClass();
            return $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
        }


    }

    /**
     * @param $event_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $guardian_ship = GuardianShip::findOrFail($id);
        $event = Event::with('city')->findOrFail($guardian_ship->event_id);

        $requests = DB::table('event_attend_request')
            ->where('status_id', 5)
            ->where('event_id', $event->id)
            ->pluck('user_id')->toArray();

        $users = User::with('image', 'city')
            ->orderBy('created_at', 'desc')
            ->where('role_id', 2)
            ->whereIn('id', $requests)
            ->get();


        return view('dashboard.break.edit', compact( 'event', 'users', 'guardian_ship'));
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Kreait\Firebase\Exception\ApiException
     */
    public function update($id, Request $request)
    {
        $guardian_ship = GuardianShip::findOrFail($id);
        $v = Validator::make($request->all(), [
            'name'         => 'required',
            'member_id'        => 'required|int',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        $guardian_ship->sp_id = \request('member_id');
        $guardian_ship->name = \request('name');
        !empty($request->returned) ? $guardian_ship->returned_at = Carbon::now() : $guardian_ship->returned_at = null;
        $guardian_ship->save();


        return redirect('break/' . $guardian_ship->event_id)->with('create', 'تم تعديل العهدة بنجاح');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|string
     */
    public function destroy($id)
    {
        $guardian_ship = GuardianShip::findOrFail($id);
        DB::beginTransaction();
        try{
            /** Delete Related Members **/
            /** Delete Group **/
            $guardian_ship->delete();

            DB::commit();
            return redirect()->back()->with('create', 'تم مسح العهدة بنجاح');

        }catch (\Exception $exception)
        {
            DB::rollBack();

            $error = new ErrorClass();
            return $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
        }
    }

    public function getBreakPage($id, $user_id)
    {
        $check_member = EventAttendRequest::where('event_id', $id)
            ->where('user_id', $user_id)
            ->where('status_id', 5)
            ->firstOrFail();

        $user = User::with('member')
            ->where('id', $user_id)
            ->firstOrFail();

        $event = Event::findOrFail($check_member->event_id);

        return view('dashboard.break.edit', compact('member', 'event', 'user'));
    }

    public function addBreakToUser(Request $request)
    {
        $v = Validator::make($request->all(), [
            'event_id'          => 'required',
            'user_id'           => 'required',
            'minutes'           => 'required|numeric',
        ], [], []);

        if ($v->fails())
        {
            return response()->json(['errors' => $v->errors()], 200);
        }

        if ($request->minutes >= 60)
        {
            return \response()->json(['error' => 'لا يمكن ان يحصل المنظم على اكثر من 60 دقيقة'], 200);
        }

        $user = User::with('member')
            ->where('id', $request->user_id)
            ->where('role_id', 2)
            ->firstOrFail();

        $rest_times = CalculateTotalBreakTime::calculateTotalByEvent($user->id, $request->event_id);

        if ($rest_times >= 60)
        {
            return \response()->json(['error' => 'تم نفاذ الإستراحة الخاصة بالمنظم'], 200);
        }

        if (($request->minutes + $rest_times) > 60)
        {
            $left = 60 - $rest_times;
            return \response()->json(['error' => ' هذا المنظم يتبقى له ' . $left . ' دقيقة فقط'], 200);
        }

        $rest = new UserRest();
        $rest->user_id = $user->id;
        $rest->event_id = $request->event_id;
        //$rest->zone_id = $group->zone_id;
        $rest->group_id = $request->group_id;
        $rest->rest_start = Carbon::now();
        $rest->rest_end = Carbon::now()->addMinutes($request->minutes);
        $rest->created_by = $user->id;
        if ($rest->save())
        {
            return \response()->json(['success' => 'تم اضافة الاستراحة بنجاح'], 200);
        }

    }
}
