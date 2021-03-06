<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\CheckPackage;
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

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::with('city', 'category')
            ->where('organization_id', Auth::user()->id)
            ->where('status_id', 1)
            ->orderByDesc('created_at')->get();
        return view('dashboard.event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->package_id != null && CheckPackage::checkPackageConsumption()->total_events > 0)
        {
            $cities = City::all()->where('country_id', 2);
            $categories = Category::all();
            $gates_types = GateType::all();
            $seasons = Season::all();
            return view('dashboard.event.create', compact('cities', 'categories', 'gates_types', 'seasons'));
        }
        return redirect('/')->with('exception', "يجب الإشتراك اولا في احد الباقات كي تتمكن من انشاء فعالية");
    }


    /**
     * @param CreateEventRequest $request
     * @return array
     */
    public function store(Request $request)
    {
        if (Auth::user()->package_id != null && CheckPackage::checkPackageConsumption()->total_events > 0)
        {
            try{
                $v = Validator::make($request->all(), [
                    'title'             => 'required',
                    'description'       => 'required',
                    'budget'            => 'required',
                    'floors'            => 'required|int',
                    'address'           => 'required|max:191',
                    'location'          => 'required',
                    'image'             => 'required',
                    'images.*'          => 'required',
                    'city_id'           => 'required|int',
                    'category_id'       => 'required|int',
                    'start'             => 'required',
                    'start_time'        => 'required',
                    'end'               => 'required',
                    'end_time'          => 'required',
                    'attaches'          => 'required|mimes:zip,rar',
                    'gate_type_ids.*'   => 'required',
                    'gates_names.*'     => 'required',
                ], [], []);

                if ($v->fails())
                {
                    return redirect()->back()->with('errors', $v->errors())->withInput();
                }

                DB::beginTransaction();

                if ($uploadedFile = $request->file('image'))
                {
                    // Save Image
                    $event_main_image = Upload::singleUpload($request,'image','uploads/events/','image','image|mimes:jpeg,jpg,png','App\Models\Image');
                }

                if ($uploadedFile = $request->file('attaches'))
                {
                    // Save Image
                    $event_attaches = Upload::singleUpload($request,'attaches','uploads/events/attaches/','image','mimes:zip,rar','App\Models\File');
                }


                // Save Location
                $location = \App\Models\Location::create(['url' => $request->location]);

                // Save Event
                $event = new Event();
                $event->season_id = $request->season_id;
                $event->title = $request->title;
                $event->budget = $request->budget;
                $event->organization_id = Auth::user()->id;
                $event->slug = $request->title;
                $event->description = $request->description;
                $event->event_date = date('Y-m-d h:i:s', strtotime($request->start . ' ' . $request->start_time));
                $event->event_start = date('Y-m-d h:i:s', strtotime($request->start . ' ' . $request->start_time));
                $event->event_end = date('Y-m-d h:i:s', strtotime($request->end . ' ' . $request->end_time));
                $event->floors = $request->floors;
                $event->status_id = 3;
                $event->country_id = 2;
                $event->city_id = $request->city_id;
                $event->place = $request->address;
                $event->category_id = $request->category_id;
                $event->image_id = $event_main_image->id;
                $event->location_id = $location->id;
                $event->attaches_id = $event_attaches->id;

                if ($event->save())
                {
                    \event(new EventCreatedEvent($event, $request, $event->image_id, $event->location_id));
                }

                Event::where('id',$event->id)->update(['evqrin'=>GenerateQr::generateQrCode(2,"hemmtk-1,".$event->id)]);
                Event::where('id',$event->id)->update(['evqrout'=>GenerateQr::generateQrCode(3,"hemmtk-2,".$event->id)]);

                DB::table('total_package_consumption')
                    ->where('organization_id', Auth::user()->id)
                    ->decrement('total_events', 1);

                DB::commit();

                return redirect(url('event'))->with('create', 'تم اضافة الفعالية بنجاح')->withInput($request->input());
            }
            catch (\Exception $exception){
                $error = new ErrorClass();
                $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
                return redirect()->back()->with('exception', 'خطأ في حفظ البيانات')->withInput($request->input());
            }
        }
        return redirect('/')->with('exception', "يجب الإشتراك اولا في احد الباقات كي تتمكن من انشاء فعالية");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::with('city', 'country', 'image')->findOrFail($id);
        $applications  = EventAttendRequest
            ::with('user')
            ->where('event_id', $id)
            ->where('status_id', 3)
            ->count();
        $organizers  = EventAttendRequest
            ::with('user')
            ->where('event_id', $id)
            ->where('status_id', 5)
            ->count();
        $groups = UserGroup::with('users')->where('event_id', $id)->count();
        $tasks = Task::with('users')->where('event_id', $id)->count();
        return view('dashboard.event.show', compact('event', 'applications', 'groups', 'tasks', 'organizers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seasons = Season::all();
        $event =  Event::with('city')->findOrFail($id);
        $cities = City::all()->where('country_id', 2);
        $categories = Category::all();
        $gates_types = GateType::all();
        return view('dashboard.event.edit', compact('event', 'cities', 'categories', 'gates_types', 'seasons'));
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
        $event =  Event::with('city')->findOrFail($id);
        try{
            $v = Validator::make($request->all(), [
                'title'         => 'required',
                'description'   => 'required',
                'budget'        => 'required',
                'floors'        => 'required|int',
                'address'       => 'required|max:191',
                'location'      => 'required',
                'city_id'       => 'required|int',
                'category_id'   => 'required|int',
                'start'         => 'required',
                'end'           => 'required',
                /*'gate_type_ids.*'     => 'required',
                'gates_names.*'   => 'required',*/
            ], [], []);

            if ($v->fails())
            {
                return redirect()->back()->with('errors', $v->errors())->withInput();
            }

            //return $request->all();

            DB::beginTransaction();

            if ($uploadedFile = $request->file('image'))
            {
                // Save Image
                $event_main_image = Upload::singleUpload($request,'image','uploads/events/','image','image|mimes:jpeg,jpg,png','App\Models\Image');
                $event->image_id = $event_main_image->id;
            }

            // Save Location
            $location = \App\Models\Location::findOrFail($event->location_id);
            $location->url = $request->location;
            $location->save();

            // Save Event
            $event->title = $request->title;
            $event->season_id = $request->season_id;
            $event->organization_id = Auth::user()->id;
            $event->slug = $request->title;
            $event->budget = $request->budget;
            $event->description = $request->description;
            $event->event_date = date('Y-m-d', strtotime($request->start));
            $event->event_start = date('Y-m-d', strtotime($request->start));
            $event->event_end = date('Y-m-d', strtotime($request->end));
            $event->floors = $request->floors;
            $event->country_id = 2;
            $event->city_id = $request->city_id;
            $event->place = $request->address;
            $event->category_id = $request->category_id;
            $event->save();
            //$event->location_id = $location->id;

            // Save Images
            if ($request->images)
            {
                if($uploadedFiles = $request->images)
                {
                    foreach ($uploadedFiles as $uploadedFile):
                        $fileName=time(). $uploadedFile->getClientOriginalName();
                        $uploadedFile->move("uploads/events", $fileName);
                        $filePath = "uploads/events".$fileName;
                        $image = Image::create(['name' => $fileName, 'path' => $filePath,'url'=>assetPath($filePath),'alt' =>"event image"]);
                        $attach = new EventImages();
                        $attach->image_id   = $image->id;
                        $attach->event_id   = $event->id;
                        $attach->save();
                    endforeach;
                }
            }

            $event_finance_totals = DB::table('finance_totals')->where('event_id', $event->id)->count();
            if ($event_finance_totals == 0)
            {
                for ($i = 1; $i<=14; $i++)
                {
                    if ($i <= 10)
                    {
                        DB::table('finance_totals')->insert([
                            'category_id' => $i,
                            'event_id' => $event->id,
                            'total_expected' => 0,
                            'total_real_value' => 0,
                            'type' => 2,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                    else
                    {
                        DB::table('finance_totals')->insert([
                            'category_id' => $i,
                            'event_id' => $event->id,
                            'total_expected' => 0,
                            'total_real_value' => 0,
                            'type' => 1,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                }
            }


            DB::commit();

            return redirect(url('event'))->with('create', 'تم تعديل الفعالية بنجاح')->withInput($request->input());
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
