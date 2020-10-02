<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\ErrorClass;
use App\Classes\GenerateQr;
use App\Classes\UserSetting;
use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Event;
use App\Models\EventAttendRequest;
use App\Models\EventGates;
use App\Models\File;
use App\Models\GateType;
use App\Models\ServiceProviderExperience;
use App\Models\User;
use App\Models\UserDocuments;
use App\Models\UserGroup;
use App\Models\UserPaymentInfo;
use App\Models\Zone;
use App\Models\ZoneInstructions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($event_id)
    {
        $event = Event::with('city')->findOrFail($event_id);
        $zones = Zone::with('event')->where('event_id', $event_id)->where('is_active', 1)->get();
        return view('dashboard.zones.index', compact('zones', 'event'));
    }

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

        return view('dashboard.zones.create', compact('event', 'users'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'event_id'          => 'required',
            'name'              => 'required',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        DB::beginTransaction();
        try{

            $zone = new Zone();
            $zone->code         = "#Z".date("ymd-his");
            $zone->event_id     = \request('event_id');
            $zone->name         = \request('name');
            $zone->description  = \request('description');
            $zone->save();

            if (!empty(\request('managers')))
            {
                foreach (\request('managers') as $manager)
                {
                    DB::table('event_zone_supervisors')->insert([
                        'zone_id' => $zone->id,
                        'supervisor_id' => $manager,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }

            if($uploadedFiles = $request->attaches)
            {
                foreach ($uploadedFiles as $uploadedFile):
                    $fileName=time(). $uploadedFile->getClientOriginalName();
                    $uploadedFile->move("uploads/zones", $fileName);
                    $filePath = "uploads/zones/".$fileName;
                    $image = File::create(['name' => $uploadedFile->getClientOriginalName(), 'path' => $filePath,'url'=>assetPath($filePath),'alt' =>"group attach", 'title' => $uploadedFile->getClientOriginalName()]);
                    $attach = new ZoneInstructions();
                    $attach->zone_id   = $zone->id;
                    $attach->file_id   = $image->id;
                    $attach->save();
                endforeach;
            }

            DB::commit();
            return redirect('zones/' . $zone->event_id)->with('create', 'تم اضافة البوابة بنجاح');


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
        $zone = Zone::with('event')->findOrFail($id);
        $event = Event::with('city')->findOrFail($zone->event_id);

        $requests = DB::table('event_attend_request')
            ->where('status_id', 5)
            ->where('event_id', $zone->event_id)
            ->pluck('user_id')->toArray();

        $users = User::with('image', 'city')
            ->orderBy('created_at', 'desc')
            ->where('role_id', 2)
            ->whereIn('id', $requests)
            ->get();

        $managers = DB::table('event_zone_supervisors')
            ->where('zone_id', $id)
            ->pluck('supervisor_id')
            ->toArray();

        return view('dashboard.zones.edit', compact('event', 'users', 'managers', 'zone'));
    }



    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $zone = Zone::with('event')->findOrFail($id);
        $v = Validator::make($request->all(), [
            'event_id'       => 'required',
            'name'           => 'required',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        $zone->event_id     = \request('event_id');
        $zone->name         = \request('name');
        $zone->description  = \request('description');
        $zone->save();

        if($uploadedFiles = $request->attaches)
        {
            foreach ($uploadedFiles as $uploadedFile):
                $fileName=time(). $uploadedFile->getClientOriginalName();
                $uploadedFile->move("uploads/zones", $fileName);
                $filePath = "uploads/zones/".$fileName;
                $image = File::create(['name' => $uploadedFile->getClientOriginalName(), 'path' => $filePath,'url'=>assetPath($filePath),'alt' =>"group attach", 'title' => $uploadedFile->getClientOriginalName()]);
                $attach = new ZoneInstructions();
                $attach->zone_id   = $zone->id;
                $attach->file_id   = $image->id;
                $attach->save();
            endforeach;
        }

        $managers = array();
        if (!empty(\request('managers')) && count(\request('managers')) > 0)
        {
            foreach (\request('managers') as $manager)
            {
                array_push($managers, $manager);
            }
            $zone->supervisors()->sync($managers);
        }

        return redirect('zones/' . $zone->event_id)->with('create', 'تم تعديل المنطقة بنجاح');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|string
     */
    public function destroy($id)
    {
        $zone = Zone::with('event')->findOrFail($id);
        DB::beginTransaction();
        try{

            $zone->is_active = 0;
            $zone->save();

            DB::commit();
            return redirect()->back()->with('create', 'تم مسح المنطقة بنجاح');

        }catch (\Exception $exception)
        {
            DB::rollBack();

            $error = new ErrorClass();
            return $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
        }
    }

}
