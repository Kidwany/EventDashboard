<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\ErrorClass;
use App\Classes\UserSetting;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventAttendRequest;
use App\Models\ServiceProviderExperience;
use App\Models\User;
use App\Models\UserDocuments;
use App\Models\UserPaymentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('dashboard.applicants.index', compact('users', 'event'));
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

    public function acceptRequest($event_id, $user_id)
    {
        try
        {
            $eventAttendRequest = EventAttendRequest
                ::where('event_id', $event_id)
                ->where('user_id', $user_id)
                ->firstOrFail() ;
            $eventAttendRequest->status_id  = 5;
            $eventAttendRequest->save();
            DB::commit();

            return redirect()->back()->with('create', 'تم قبول الطلب بنجاح');
        }
        catch (\Exception $exception){
            $error = new ErrorClass();
            return $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
        }
    }

    public function rejectRequest($event_id, $user_id)
    {
        try
        {
            $eventAttendRequest = EventAttendRequest
                ::where('event_id', $event_id)
                ->where('user_id', $user_id)
                ->firstOrFail() ;
            $eventAttendRequest->status_id  = 9;
            $eventAttendRequest->save();
            DB::commit();

            return redirect()->back()->with('create', 'تم رفض الطلب بنجاح');
        }
        catch (\Exception $exception){
            $error = new ErrorClass();
            return $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
        }
    }


}
