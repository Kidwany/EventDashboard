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
use App\Models\Image;
use App\Models\ServiceProviderExperience;
use App\Models\User;
use App\Models\UserDocuments;
use App\Models\UserGroup;
use App\Models\UserPaymentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($event_id)
    {
        $event = Event::with('city')->findOrFail($event_id);
        $groups = UserGroup::with('users')->where('event_id', $event_id)->get();
        return view('dashboard.groups.index', compact('groups', 'event'));
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

        // Get All Groups of this event
        $existed_groups = DB::table('user_groups')->where('event_id', $event_id)->pluck('id');

        // Get Users Who Related to another groups in this event
        $groups_members = DB::table('user_group_members')
            ->whereIn('member_id', $requests)
            ->whereIn('user_group_id', $existed_groups)
            ->pluck('member_id')->toArray();


         $users = User::with('image', 'city')
            ->orderBy('created_at', 'desc')
            ->where('role_id', 2)
            ->whereIn('id', $requests)
            ->whereIn('id', array_diff($requests, $groups_members))
            ->get();

        $colors = Color::all();

        return view('dashboard.groups.create', compact('event', 'users', 'colors'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name'         => 'required',
            'color'          => 'required',
            'users.*'        => 'required|int',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        $group = new UserGroup();
        $group->color_id = $request->color;
        $group->event_id = $request->event_id;
        $group->name = $request->name;
        $group->created_by = Auth::user()->id;
        $group->save();

        $members = array();
        if (!empty(\request("users")))
        {
            foreach (\request("users") as $applicant):
                array_push($members,$applicant);
            endforeach;
        }

        $group->users()->sync($members);

        // Save Images
        if($uploadedFiles = $request->attaches)
        {
            foreach ($uploadedFiles as $uploadedFile):
                $fileName=time(). $uploadedFile->getClientOriginalName();
                $uploadedFile->move("uploads/groups", $fileName);
                $filePath = "uploads/groups/".$fileName;
                $image = File::create(['name' => $uploadedFile->getClientOriginalName(), 'path' => $filePath,'url'=>assetPath($filePath),'alt' =>"group attach", 'title' => $uploadedFile->getClientOriginalName()]);
                $attach = new GroupAttaches();
                $attach->user_group_id   = $group->id;
                $attach->file_id   = $image->id;
                $attach->save();
            endforeach;
        }

        if (!empty($request->manager))
        {
            foreach ($request->manager as $manager)
            {
                DB::table('user_group_members')->where('user_group_id', $group->id)
                    ->where('member_id', $manager)->update(['is_manager' => 1]);
            }
            /*DB::table('user_group_members')->where('user_group_id', $group->id)
                ->where('member_id', $request->manager)->update(['is_manager' => 1]);*/
        }

        return redirect('groups/' . $request->event_id)->with('create', 'تم اضافة المجموعة بنجاح');
    }

    /**
     * @param $event_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($event_id, $group_id)
    {
        $group = UserGroup::findOrFail($group_id);
        $event = Event::with('city')->findOrFail($event_id);
        $requests = DB::table('event_attend_request')
            ->where('status_id', 5)
            ->where('event_id', $event_id)
            ->pluck('user_id')->toArray();

        // Get All Groups of this event
         $existed_groups = DB::table('user_groups')->where('event_id', $event_id)->pluck('id');

        // Get Users Who Related to another groups in this event
        $event_groups_members = DB::table('user_group_members')
            ->whereIn('member_id', $requests)
            ->whereIn('user_group_id', $existed_groups)
            ->pluck('member_id')
            ->toArray();

        // Available Users who can be added to group
        $available_users = array_diff($requests, $event_groups_members);

        // Group Members
        $group_members = DB::table('user_group_members')
            ->where('user_group_id', $group_id)
            ->pluck('member_id')
            ->toArray();


        $users = User::with('image', 'city')
            ->orderBy('created_at', 'desc')
            ->where('role_id', 2)
            ->whereIn('id', $requests)
            ->whereIn('id', array_merge($available_users, $group_members))
            ->get();

        $managers = DB::table('user_group_members')
            ->whereIn('user_group_id', $existed_groups)
            ->where('is_manager', 1)
            ->pluck('member_id')
            ->first();

        $colors = Color::all();

        return view('dashboard.groups.edit', compact('event', 'users', 'colors', 'group', 'group_members', 'managers'));
    }



    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $group = UserGroup::where('id',$id)->firstOrFail();
        $v = Validator::make($request->all(), [
            'name'         => 'required',
            'color'          => 'required',
            'users.*'        => 'required|int',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        $group->color_id = $request->color;
        $group->name = $request->name;
        $group->created_by = Auth::user()->id;
        $group->save();

        $members = array();
        if (!empty(\request("users")))
        {
            foreach (\request("users") as $applicant):
                array_push($members,$applicant);
            endforeach;
        }

        $group->users()->sync($members);

        // Save Images
        if($uploadedFiles = $request->attaches)
        {
            foreach ($uploadedFiles as $uploadedFile):
                $fileName=time(). $uploadedFile->getClientOriginalName();
                $uploadedFile->move("uploads/groups", $fileName);
                $filePath = "uploads/groups/".$fileName;
                $image = File::create(['name' => $uploadedFile->getClientOriginalName(), 'path' => $filePath,'url'=>assetPath($filePath),'alt' =>"group attach", 'title' => $uploadedFile->getClientOriginalName()]);
                $attach = new GroupAttaches();
                $attach->user_group_id   = $group->id;
                $attach->file_id   = $image->id;
                $attach->save();
            endforeach;
        }

        if (!empty($request->manager))
        {
            foreach ($request->manager as $manager)
            {
                DB::table('user_group_members')->where('user_group_id', $group->id)
                    ->where('member_id', $manager)->update(['is_manager' => 1]);
            }
            /*DB::table('user_group_members')->where('user_group_id', $group->id)
                ->where('member_id', $request->manager)->update(['is_manager' => 1]);*/
        }

        return redirect('groups/' . $request->event_id)->with('create', 'تم اضافة المجموعة بنجاح');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|string
     */
    public function destroy($id)
    {
        $group = UserGroup::where('id',$id)->first();
        DB::beginTransaction();
        try{
            /** Delete Related Members **/
            DB::table('user_group_members')->where('user_group_id', $id)->delete();
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
