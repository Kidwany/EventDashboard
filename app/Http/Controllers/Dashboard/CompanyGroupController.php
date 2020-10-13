<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\ErrorClass;
use App\Classes\GenerateQr;
use App\Classes\Upload;
use App\Classes\UserSetting;
use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Company;
use App\Models\CompanyCategories;
use App\Models\CompanyGroup;
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

class CompanyGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $company = Company::with('event')->findOrFail($id);
        $event = Event::with('city')->findOrFail($company->event_id);
        $groups = CompanyGroup::where('company_id', $company->id)->get();
        $users = User::all()->where('company_id', $id)->where('role_id', 5);
        return view('dashboard.companyGroup.index', compact('company', 'users', 'event', 'groups'));
    }

    /**
     * @param $event_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($id)
    {
        $company = Company::with('event')->findOrFail($id);
        $event = $company->event_id;
        $categories = CompanyCategories::all()->where('type', 'indiv')->where('is_active', 1);
        //Get Company Users
        $company_users = DB::table('users')
            ->where('role_id', 5)
            ->where('company_id', $id)
            ->pluck('id')
            ->toArray();
        // Get All Groups of this event
        $existed_groups = DB::table('company_groups')
            ->where('company_id', $company->id)
            ->pluck('id')
            ->toArray();
        // Get Users Who Related to another groups in this event
        $groups_members = DB::table('company_group_members')
            ->whereIn('member_id', $company_users)
            ->whereIn('group_id', $existed_groups)
            ->pluck('member_id')
            ->toArray();

        $users = User::with('image', 'city')
            ->orderBy('created_at', 'desc')
            ->whereIn('role_id', [2, 5])
            ->whereIn('id', $company_users)
            ->whereIn('id', array_diff($company_users, $groups_members))
            ->get();

        return view('dashboard.companyGroup.create', compact('company', 'categories', 'event', 'users'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name'         => 'required',
            'company_id'          => 'required',
            'users.*'        => 'required|int',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        try{

            DB::beginTransaction();

            $group = new CompanyGroup();
            $group->name = $request->name;
            $group->company_id = $request->company_id;
            $group->save();

            $members = array();
            if (!empty(\request("users")))
            {
                foreach (\request("users") as $applicant):
                    array_push($members,$applicant);
                endforeach;
            }

            $group->users()->sync($members);

            DB::commit();

            return redirect(adminUrl('company-group/' . $group->company_id))->with('create', 'تمت اضافة المجموعة بنجاح');

        }
        catch (\Exception $exception){
            $error = new ErrorClass();
            $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
            return redirect()->back()->with('exception', 'خطأ في حفظ البيانات')->withInput($request->input());
        }
    }

    /**
     * @param $event_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $group = CompanyGroup::findOrFail($id);

        //Get Company Users
        $company_users = DB::table('users')
            ->where('role_id', 5)
            ->where('company_id', $id)
            ->pluck('id')
            ->toArray();
        // Get All Groups of this event
        $existed_groups = DB::table('company_groups')
            ->where('company_id', $group->company_id)
            ->pluck('id')
            ->toArray();
        // Get Users Who Related to another groups in this event
        $company_groups_members = DB::table('company_group_members')
            ->whereIn('member_id', $company_users)
            ->whereIn('group_id', $existed_groups)
            ->pluck('member_id')
            ->toArray();

        // Available Users who can be added to group
        $available_users = array_diff($company_users, $company_groups_members);

        // Group Members
        $group_members = DB::table('company_group_members')
            ->where('group_id', $id)
            ->pluck('member_id')
            ->toArray();

        $users = User::with('image', 'city')
            ->orderBy('created_at', 'desc')
            ->where('role_id', 5)
            ->whereIn('id', $company_users)
            ->whereIn('id', array_merge($available_users, $group_members))
            ->get();

        return view('dashboard.companyGroup.edit', compact('group', 'users'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $v = Validator::make($request->all(), [
            'name'         => 'required',
            'company_id'          => 'required',
            'users.*'        => 'required|int',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        try{

            DB::beginTransaction();

            $group = CompanyGroup::findOrFail($id);
            $group->name = $request->name;
            $group->company_id = $request->company_id;
            $group->save();

            $members = array();
            if (!empty(\request("users")))
            {
                foreach (\request("users") as $applicant):
                    array_push($members,$applicant);
                endforeach;
            }

            $group->users()->sync($members);

            DB::commit();

            return redirect(adminUrl('company-group/' . $group->company_id))->with('create', 'تمت تعديل المجموعة بنجاح');

        }
        catch (\Exception $exception){
            $error = new ErrorClass();
            $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
            return redirect()->back()->with('exception', 'خطأ في حفظ البيانات')->withInput($request->input());
        }
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $company = Company::with('event')->findOrFail($id);
        $event = Event::with('city')->findOrFail($company->event_id);
        $users = User::all()->where('company_id', $id)->where('role_id', 5);
        return view('dashboard.company.users', compact('company', 'users', 'event'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|string
     */
    public function destroy($id)
    {
        $group = CompanyGroup::where('id',$id)->firstOrFail();
        DB::beginTransaction();
        try{
            /** Delete Related Members **/
            DB::table('company_group_members')->where('group_id', $id)->delete();
            /** Delete Group **/
            $group->delete();

            DB::commit();
            return redirect()->back()->with('create', 'تم مسح المجموعة بنجاح');

        }catch (\Exception $exception)
        {
            DB::rollBack();

            $error = new ErrorClass();
            return $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
        }
    }

}
