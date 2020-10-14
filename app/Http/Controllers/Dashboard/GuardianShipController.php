<?php

namespace App\Http\Controllers\Dashboard;

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
use App\Models\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class GuardianShipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($event_id)
    {
        $event = Event::with('city')->findOrFail($event_id);
        $guardian_ships = GuardianShip::with('organizer')->where('event_id', $event_id)->get();
        return view('dashboard.guardianShip.index', compact('guardian_ships', 'event'));
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

        return view('dashboard.guardianShip.create', compact('event', 'users'));
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
            return redirect('guardian-ship/' . $guardian_ship->event_id)->with('create', 'تم اضافة العهدة بنجاح');

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


        return view('dashboard.guardianShip.edit', compact( 'event', 'users', 'guardian_ship'));
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


        return redirect('guardian-ship/' . $guardian_ship->event_id)->with('create', 'تم تعديل العهدة بنجاح');
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
}
