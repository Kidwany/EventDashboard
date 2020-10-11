<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\ErrorClass;
use App\Classes\Upload;
use App\Classes\UserSetting;
use App\Http\Controllers\Controller;
use App\Mail\SendContract;
use App\Models\Event;
use App\Models\EventAttendRequest;
use App\Models\ServiceProviderExperience;
use App\Models\User;
use App\Models\UserDocuments;
use App\Models\UserPaymentInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class ApplicantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($event_id)
    {
        $event = Event::with('city')->findOrFail($event_id);
        $requests = DB::table('event_attend_request')
            ->where('status_id', 3)
            ->where('event_id', $event_id)
            ->pluck('user_id');

        $users = User::with('image', 'city')
            ->orderBy('created_at', 'desc')
            ->where('role_id', 2)
            ->whereIn('id', $requests)
            ->get();

        $applicants = EventAttendRequest::with('user')
            ->where('status_id', 3)
            ->where('event_id', $event_id)
            ->whereIn('user_id', $requests)
            ->get();

        return view('dashboard.applicants.index', compact('users', 'event', 'applicants'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($event_id, $id)
    {
        $user = User::with('serviceProviderJobs')->find($id);
        $events = Event::with('serviceProvider')->where('sp_id', $id)->get();
        $total_user_events = Event::with('serviceProvider')->where('sp_id', $id)->count();
        $sp_experience = ServiceProviderExperience::where('user_id', $id)->get();
        $sp_doc = UserDocuments::with('identityImage')->where('user_id', $id)->first();
        $requests = EventAttendRequest::where('user_id', $id)->count();
        $user_payment = UserPaymentInfo::where('user_id', $id)->firstOrFail();
        return view('dashboard.applicants.show', compact('user', 'events', 'total_user_events', 'sp_experience', 'sp_doc', 'requests', 'user_payment'));
    }

    public function acceptRequest($id)
    {
        try
        {
            $eventAttendRequest = EventAttendRequest::findOrFail($id);
            $eventAttendRequest->status_id  = 5;
            $eventAttendRequest->save();
            DB::commit();
            $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/hemmtk-firebase-adminsdk-gufet-035d61ef62.json');
            $firebase = (new Factory)
                ->withServiceAccount($serviceAccount)
                ->withDatabaseUri('https://hemmtk.firebaseio.com')
                ->create();
            $database = $firebase->getDatabase();
            $evenTitle=Event::where('id',$eventAttendRequest->event_id)->select('title')->firstOrFail();
            if(!empty($eventAttendRequest)){

                    $database
                        ->getReference('Notifications/'.$eventAttendRequest->user_id)
                        ->push([
                            'body' => 'تم قبول طلبك للانضمام لفاعليه '.$evenTitle->title ,
                            'createdDate' => Carbon::now(),
                            'icon'=>URL::to('/dashboard/assets/images/icon/applications.f8d0d384.svg'),
                            'is_read'=>'false',
                            'type'=>'application',
                        ]);
                }

            return redirect()->back()->with('create', 'تم قبول الطلب بنجاح');
        }
        catch (\Exception $exception){
            $error = new ErrorClass();
            return $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
        }
    }

    public function acceptRequestFromUserPage(Request $request, $id)
    {
        try
        {

            $eventAttendRequest = EventAttendRequest::findOrFail($id);
            if ($uploadedFile = $request->file('contract'))
            {
                // Save Contract
                $contract = Upload::singleUpload($request,'contract','uploads/applicants/contracts/','image','mimes:pdf,doc,docx,png,jpg,jpeg','App\Models\File');
            }
            $eventAttendRequest->contract_id  = $contract->id;
            $eventAttendRequest->status_id  = 7;
            $eventAttendRequest->verification_no  = $id . '-' . $eventAttendRequest->event_id . '-' . $eventAttendRequest->user_id . '-' . time();
            $eventAttendRequest->save();

            $evenTitle=Event::where('id',$eventAttendRequest->event_id)->select('title')->firstOrFail();
            $user = User::findOrFail($eventAttendRequest->user_id);
            Mail::to($user->email)->send(new SendContract($contract->url, $user, $evenTitle));

            DB::commit();
            $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/hemmtk-firebase-adminsdk-gufet-035d61ef62.json');
            $firebase = (new Factory)
                ->withServiceAccount($serviceAccount)
                ->withDatabaseUri('https://hemmtk.firebaseio.com')
                ->create();
            $database = $firebase->getDatabase();
            //$evenTitle=Event::where('id',$eventAttendRequest->event_id)->select('title')->firstOrFail();
            if(!empty($eventAttendRequest)){

                $database
                    ->getReference('Notifications/'.$eventAttendRequest->user_id)
                    ->push([
                        'body' => 'تم قبول طلبك للانضمام لفاعليه '.$evenTitle->title ,
                        'createdDate' => Carbon::now(),
                        'icon'=>URL::to('/dashboard/assets/images/icon/applications.f8d0d384.svg'),
                        'is_read'=>'false',
                        'type'=>'application',
                    ]);
            }

            return redirect()->back()->with('create', 'تم ارسال العقد للمنظم بنجاح');
        }
        catch (\Exception $exception){
            $error = new ErrorClass();
            return $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
        }
    }

    public function rejectRequest($id)
    {
        try
        {
            $eventAttendRequest = EventAttendRequest::findOrFail($id);
            $eventAttendRequest->delete();
            DB::commit();
            $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/hemmtk-firebase-adminsdk-gufet-035d61ef62.json');
            $firebase = (new Factory)
                ->withServiceAccount($serviceAccount)
                ->withDatabaseUri('https://hemmtk.firebaseio.com')
                ->create();
            $database = $firebase->getDatabase();
            $evenTitle=Event::where('id',$eventAttendRequest->event_id)->select('title')->firstOrFail();
            if(!empty($eventAttendRequest)){

                $database
                    ->getReference('Notifications/'.$eventAttendRequest->user_id)
                    ->push([
                        'body' => 'لقد تم رفض طلبك للانضمام لفاعليه '.$evenTitle->title ,
                        'createdDate' => Carbon::now(),
                        'icon'=>URL::to('/dashboard/assets/images/icon/applications.f8d0d384.svg'),
                        'is_read'=>'false',
                        'type'=>'application',
                    ]);
            }
            return redirect()->back()->with('create', 'تم رفض الطلب بنجاح');
        }
        catch (\Exception $exception){
            $error = new ErrorClass();
            return $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
        }
    }


}
