<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\ErrorClass;
use App\Classes\GenerateQr;
use App\Classes\Upload;
use App\Events\EventCreatedEvent;
use App\Events\EventUpdatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Event\CreateEventRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Event;
use App\Models\EventAttendRequest;
use App\Models\EventGates;
use App\Models\EventImages;
use App\Models\GateType;
use App\Models\Image;
use App\Models\Season;
use App\Models\ServiceProviderExperience;
use App\Models\ServiceProviderTask;
use App\Models\Task;
use App\Models\UserDocuments;
use App\Models\UserGroup;
use App\Models\UserPaymentInfo;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seasons = Season::where('manager_id', Auth::user()->id)
            ->orderByDesc('created_at')->get();
        return view('dashboard.season.index', compact('seasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all()->where('country_id', 2);
        return view('dashboard.season.create', compact('cities'));
    }


    /**
     * @param CreateEventRequest $request
     * @return array
     */
    public function store(Request $request)
    {
        try{
            $v = Validator::make($request->all(), [
                'title'             => 'required',
                'description'       => 'required',
                'city_id'           => 'required|int',
                'start'             => 'required',
                'end'               => 'required',
            ], [], []);

            if ($v->fails())
            {
                return redirect()->back()->with('errors', $v->errors())->withInput();
            }

            DB::beginTransaction();

            $season = new Season();
            $season->name = $request->title;
            $season->description = $request->description;
            $season->city_id = $request->city_id;
            $season->country_id = 2;
            $season->manager_id = Auth::user()->id;
            $season->start = date('Y-m-d', strtotime($request->start));
            $season->end = date('Y-m-d', strtotime($request->end));
            $season->save();

            DB::commit();

            return redirect(url('season'))->with('create', 'تم اضافة الموسم بنجاح')->withInput($request->input());
        }
        catch (\Exception $exception){
            $error = new ErrorClass();
            $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
            return redirect()->back()->with('exception', 'خطأ في حفظ البيانات')->withInput($request->input());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $events = Event::with('city', 'category')
            ->where('organization_id', Auth::user()->id)
            ->where('season_id', $id)
            ->where('status_id', 1)
            ->orderByDesc('created_at')->get();
        return view('dashboard.event.index', compact('events'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $season =  Season::with('city')->findOrFail($id);
        $cities = City::all()->where('country_id', 2);
        return view('dashboard.season.edit', compact('season', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $season =  Season::with('city')->findOrFail($id);
        try{
            $v = Validator::make($request->all(), [
                'title'         => 'required',
                'description'   => 'required',
                'city_id'       => 'required|int',
                'start'         => 'required',
                'end'           => 'required',

            ], [], []);

            if ($v->fails())
            {
                return redirect()->back()->with('errors', $v->errors())->withInput();
            }

            //return $request->all();

            DB::beginTransaction();

            $season->name = $request->title;
            $season->description = $request->description;
            $season->city_id = $request->city_id;
            $season->country_id = 2;
            $season->manager_id = Auth::user()->id;
            $season->start = date('Y-m-d', strtotime($request->start));
            $season->end = date('Y-m-d', strtotime($request->end));
            $season->save();


            DB::commit();

            return redirect(url('season'))->with('create', 'تم تعديل الموسم بنجاح')->withInput($request->input());
        }
        catch (\Exception $exception){
            $error = new ErrorClass();
            $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
            return redirect()->back()->with('exception', 'خطأ في حفظ البيانات')->withInput($request->input());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->back()->with('create', 'تم مسح المستخدم بنجاح');
    }


    public function printPdf($id)
    {
        $user = \App\Models\User::with('serviceProviderJobs')->find($id);
        $events = Event::with('serviceProvider')->where('sp_id', $id)->get();
        $total_user_events = Event::with('serviceProvider')->where('sp_id', $id)->count();
        $sp_experience = ServiceProviderExperience::where('user_id', $id)->get();
        $sp_doc = UserDocuments::with('identityImage')->where('user_id', $id)->first();
        $requests = EventAttendRequest::where('user_id', $id)->count();
        $user_payment = UserPaymentInfo::where('user_id', $id)->firstOrFail();
        return view('printUser', compact('user', 'events', 'total_user_events', 'sp_experience', 'sp_doc', 'requests', 'user_payment'));
    }


    public function printQr($id)
    {
        $event =  Event::with('city')->findOrFail($id);
        return view('printEventQR', compact('event'));
    }
}
