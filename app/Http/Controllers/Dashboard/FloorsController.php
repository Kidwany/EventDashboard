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
            'event_id'       => 'required',
            'gate_type_id'   => 'required',
            'gate_name'      => 'required',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        $gate = new EventGates();
        $gate->type_id = $request->gate_type_id;
        $gate->name = $request->gate_name;
        $gate->event_id = $request->event_id;
        $gate->save();

        EventGates::where('id',$gate->id)->update(['barcode'=>GenerateQr::generateQrCode(4,"hemmtk-4,".$gate->event_id.",".$gate->id)]);

        return redirect()->back()->with('create', 'تم اضافة البوابة بنجاح');
    }

    /**
     * @param $event_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $event_gate = EventGates::findOrFail($id);
        $gates_types = GateType::all();
        return view('dashboard.gates.edit', compact('event_gate', 'gates_types'));
    }



    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $gate = EventGates::findOrFail($id);
        $v = Validator::make($request->all(), [
            'event_id'       => 'required',
            'gate_type_id'   => 'required',
            'gate_name'      => 'required',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        $gate->type_id = $request->gate_type_id;
        $gate->name = $request->gate_name;
        $gate->event_id = $request->event_id;
        $gate->save();

        return redirect('gates/' . $gate->event_id)->with('create', 'تم تعديل البوابة بنجاح');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|string
     */
    public function destroy($id)
    {
        $gate = EventGates::findOrFail($id);
        DB::beginTransaction();
        try{
            $gate->delete();

            DB::commit();
            return redirect()->back()->with('create', 'تم مسح البوابة بنجاح');

        }catch (\Exception $exception)
        {
            DB::rollBack();

            $error = new ErrorClass();
            return $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
        }
    }
}
