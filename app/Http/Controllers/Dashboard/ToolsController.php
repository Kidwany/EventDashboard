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
use App\Models\EventTools;
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

class ToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($event_id)
    {
        $event = Event::with('city')->findOrFail($event_id);
        $tools = EventTools::with('event')->where('event_id', $event_id)->get();
        return view('dashboard.tools.index', compact('event', 'tools'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'event_id'       => 'required',
            'name'           => 'required',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        $tool = new EventTools();
        $tool->code = $request->event_id . time();
        $tool->name = $request->name;
        $tool->event_id = $request->event_id;
        $tool->save();

        $tool->barcode = GenerateQr::generateQrCode(6,"hemmtk-4,".$tool->event_id.",".$tool->id);
        $tool->save();
        //return EventGates::where('id',$tool->id)->update(['barcode'=>GenerateQr::generateQrCode(6,"hemmtk-4,".$tool->event_id.",".$tool->id)]);

        return redirect()->back()->with('create', 'تم اضافة المعدة بنجاح');
    }

    /**
     * @param $event_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $tool = EventTools::findOrFail($id);
        return view('dashboard.tools.edit', compact('tool'));
    }



    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $tool = EventTools::findOrFail($id);
        $v = Validator::make($request->all(), [
            'event_id'       => 'required',
            'name'           => 'required',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        $tool->name = $request->name;
        $tool->save();

        return redirect('tools/' . $tool->event_id)->with('create', 'تم تعديل المعدة بنجاح');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|string
     */
    public function destroy($id)
    {
        $tool = EventTools::findOrFail($id);
        DB::beginTransaction();
        try{
            $tool->delete();

            DB::commit();
            return redirect()->back()->with('create', 'تم مسح المعدة بنجاح');

        }catch (\Exception $exception)
        {
            DB::rollBack();

            $error = new ErrorClass();
            return $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
        }
    }

    public function printQr($id)
    {
        $tool =  EventTools::findOrFail($id);
        return view('printToolQR', compact('tool'));
    }
}
