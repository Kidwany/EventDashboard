<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\ErrorClass;
use App\Classes\GenerateQr;
use App\Classes\UserSetting;
use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Company;
use App\Models\CompanyCategories;
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

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($event_id)
    {
        $event = Event::with('city')->findOrFail($event_id);
        $companies = Company::all()->where('event_id', $event_id);
        return view('dashboard.company.index', compact('companies', 'event'));
    }

    /**
     * @param $event_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($event_id)
    {
        $event = Event::with('city')->findOrFail($event_id);
        $categories = CompanyCategories::all()->where('type', 'com')->where('is_active', 1);
        return view('dashboard.company.create', compact('event', 'categories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'event_id'              => 'required',
            'name'                  => 'required',
            'phone'                 => 'required',
            'description'           => 'required',
            'category_id'           => 'required',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        DB::beginTransaction();
        try{

            $company = new Company();
            $company->code = '#' . \request('event_id') . \request('category_id') . Auth::user()->id;
            $company->name = \request('name');
            $company->email = \request('email');
            $company->phone = \request('phone');
            $company->description = \request('description');
            $company->category_id = \request('category_id');
            $company->event_id = \request('event_id');
            $company->is_active = 1;
            $company->created_by = Auth::user()->id;
            $company->save();

            if (\request('category_id') == 4)
            {
                $user = new User();
                $user->email = $company->email;
                $user->company_id = $company->id;
                $user->category_id = $company->category_id;
                $user->code_number  = 'USP' . date('dmy-his');
                $user->name = $company->name;
                $user->phone = $company->phone;
                $user->role_id = 4;
                $user->created_by = Auth::user()->id;
                $user->save();
            }

            DB::commit();
            return redirect('company/' . $company->event_id)->with('create', 'تم اضافة الشركة بنجاح');


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
        $company = Company::with('event')->findOrFail($id);
        $event = Event::with('city')->findOrFail($company->event_id);
        $categories = CompanyCategories::all()->where('type', 'com')->where('is_active', 1);
        return view('dashboard.company.edit', compact('event', 'company', 'categories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $company = Company::with('event')->findOrFail($id);
        $v = Validator::make($request->all(), [
            'event_id'              => 'required',
            'name'                  => 'required',
            'phone'                 => 'required',
            'description'           => 'required',
            'category_id'           => 'required',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        $company->name = \request('name');
        $company->phone = \request('phone');
        $company->description = \request('description');
        $company->category_id = \request('category_id');
        $company->save();

        return redirect('company/' . $company->event_id)->with('create', 'تم تعديل الشركة بنجاح');
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
