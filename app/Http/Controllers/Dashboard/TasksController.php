<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\ErrorClass;
use App\Classes\UserSetting;
use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Event;
use App\Models\EventAttendRequest;
use App\Models\ServiceProviderExperience;
use App\Models\Task;
use App\Models\User;
use App\Models\UserDocuments;
use App\Models\UserGroup;
use App\Models\UserPaymentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($event_id)
    {
        $event = Event::with('city')->findOrFail($event_id);
        $tasks = Task::where('event_id', $event_id)->get();
        return view('dashboard.tasks.index', compact('tasks', 'event'));
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
            ->pluck('user_id')
            ->toArray();

         $users = User::with('image', 'city')
            ->orderBy('created_at', 'desc')
            ->where('role_id', 2)
            ->whereIn('id', $requests)
            ->get();

        return view('dashboard.tasks.create', compact('event', 'users'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $event = Event::with('city')->findOrFail($request->event_id);
        $v = Validator::make($request->all(), [
            'name'         => 'required',
            'users.*'        => 'required|int',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        $task = new Task();
        $task->event_id = $request->event_id;
        $task->task_title = $request->name;
        $task->organization_id = $event->organization_id;
        $task->status = 3;
        $task->created_by = Auth::user()->id;
        $task->save();

        $members = array();
        if (!empty(\request("users")))
        {
            foreach (\request("users") as $applicant):
                array_push($members,$applicant);
            endforeach;
        }

        $task->members()->sync($members);

        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/hemmtk-firebase-adminsdk-gufet-035d61ef62.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://hemmtk.firebaseio.com')
            ->create();
        $database = $firebase->getDatabase();
        if(!empty($members)){
        foreach ($members as $member){
             $database
                ->getReference('Notifications/'.$member)
                ->push([
                    'body' => 'لديك مهمه جديده من فاعليه '.$event->title ,
                    'createdDate' => time().now(+20),
                    'icon'=>URL::to('/dashboard/assets/images/icon/tasks.bd1b6b37.svg'),
                    'is_read'=>'false',
                    'type'=>'task',
                ]);
        }
        }

        return redirect('tasks/' . $request->event_id)->with('create', 'تم اضافة المهمة بنجاح');
    }

    /**
     * @param $event_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($event_id, $group_id)
    {
        $task = Task::findOrFail($group_id);
        $event = Event::with('city')->findOrFail($event_id);
        $requests = DB::table('event_attend_request')
            ->where('status_id', 5)
            ->where('event_id', $event_id)
            ->pluck('user_id')
            ->toArray();

        $users = User::with('image', 'city')
            ->orderBy('created_at', 'desc')
            //->where('role_id', 2)
            ->whereIn('id', $requests)
            ->get();

        return view('dashboard.tasks.edit', compact('event', 'users',  'task'));
    }



    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $task = Task::findOrFail($id);
        $v = Validator::make($request->all(), [
            'name'         => 'required',
            'users.*'        => 'required|int',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        $task->task_title = $request->name;
        $task->created_by = Auth::user()->id;
        $task->save();

        $members = array();
        if (!empty(\request("users")))
        {
            foreach (\request("users") as $applicant):
                array_push($members,$applicant);
            endforeach;
            $task->members()->sync($members);
        }



        return redirect('tasks/' . $request->event_id)->with('create', 'تم تعديل المهمة بنجاح');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|string
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        DB::beginTransaction();
        try{
            /** Delete Related Members **/
            DB::table('service_provider_tasks')->where('task_id', $id)->delete();
            /** Delete Group **/
            $task->delete();

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
