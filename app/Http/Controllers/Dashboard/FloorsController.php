<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\ErrorClass;
use App\Classes\GenerateQr;
use App\Classes\UserSetting;
use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Event;
use App\Models\EventAttendRequest;
use App\Models\EventFloors;
use App\Models\EventGates;
use App\Models\GateType;
use App\Models\ServiceProviderExperience;
use App\Models\User;
use App\Models\UserDocuments;
use App\Models\UserGroup;
use App\Models\UserPaymentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FloorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($event_id)
    {
        $event = Event::with('city')->findOrFail($event_id);
        $floors = EventFloors::all()->where('event_id', $event_id);
        return view('dashboard.floors.index', compact('floors', 'event'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'no'       => 'required|numeric',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        $floor = new EventFloors();
        $floor->floor_no = $request->no;
        $floor->event_id = $request->event_id;
        $floor->save();

        EventFloors::where('id',$floor->id)->update(['barcode'=>GenerateQr::generateQrCode(3,"hemmtk-4,".$floor->event_id.",".$floor->id)]);

        return redirect()->back()->with('create', 'تم اضافة الطابق بنجاح');
    }

    /**
     * @param $event_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $floor = EventFloors::findOrFail($id);
        return view('dashboard.floors.edit', compact('floor'));
    }



    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $floor = EventFloors::findOrFail($id);
        $v = Validator::make($request->all(), [
            'no'       => 'required|numeric',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        $floor->floor_no = $request->no;
        $floor->save();

        EventFloors::where('id',$floor->id)->update(['barcode'=>GenerateQr::generateQrCode(3,"hemmtk-4,".$floor->event_id.",".$floor->id)]);

        return redirect('floors/' . $floor->event_id)->with('create', 'تم تعديل الطابق بنجاح');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|string
     */
    public function destroy($id)
    {
        $floor = EventFloors::findOrFail($id);
        DB::beginTransaction();
        try{
            $floor->delete();

            DB::commit();
            return redirect()->back()->with('create', 'تم مسح الطابق بنجاح');

        }catch (\Exception $exception)
        {
            DB::rollBack();

            $error = new ErrorClass();
            return $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
        }
    }
}
