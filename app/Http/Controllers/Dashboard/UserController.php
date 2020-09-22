<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\Upload;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventAttendRequest;
use App\Models\ServiceProviderExperience;
use App\Models\UserDocuments;
use App\Models\UserPaymentInfo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\JobTitle;
use App\Models\ServiceProviderJobs;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = \App\Models\User::with('image', 'city')
            ->orderBy('created_at', 'desc')
            ->where('role_id', 2)
            ->get();
        return view('dashboard.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = \App\Models\User::with('serviceProviderJobs')->find($id);
        $events = Event::with('serviceProvider')->where('sp_id', $id)->get();
        $total_user_events = Event::with('serviceProvider')->where('sp_id', $id)->count();
        $sp_experience = ServiceProviderExperience::where('user_id', $id)->get();
        $sp_doc = UserDocuments::with('identityImage')->where('user_id', $id)->first();
        $requests = EventAttendRequest::where('user_id', $id)->count();
        $user_payment = UserPaymentInfo::where('user_id', $id)->firstOrFail();
        return view('dashboard.user.show', compact('user', 'events', 'total_user_events', 'sp_experience', 'sp_doc', 'requests', 'user_payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $allJobs = JobTitle::get();


        $user = \App\Models\User::with('image')->findOrFail($id);
        $total_user_events = Event::with('serviceProvider')->where('sp_id', $id)->count();
        $requests = EventAttendRequest::where('user_id', $id)->count();
        $sp_doc = UserDocuments::with('identityImage')->where('user_id', $id)->first();
        $sp_job = ServiceProviderJobs::where('user_id', $id)->first();
        $user_payment = UserPaymentInfo::where('user_id', $id)->firstOrFail();

        return view('dashboard.user.edit', compact('user', 'requests', 'total_user_events', 'sp_doc', 'user_payment','allJobs','sp_job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = \App\Models\User::with('image')->findOrFail($id);
        $request->validate([
            'name'              =>  'required',
            'phone'             =>  'required',
            'passport_no'       =>  'required',
            'ipan_no'           =>  'required',
            'bank'              =>  'required',
            'profile_image'     =>  'mimes:svg,png,jpeg,jpg,gif',
            'id_image'          =>  'mimes:svg,png,jpeg,jpg,gif',
        ], [] , [
            'name'              =>  'Name',
            'phone'             =>  'Phone',
            'IPan'              =>  'Ipan',
            'bank'              =>  'Bank',
            'passport_no'       =>  'Passport No',
            'profile_image'     =>  'Profile Image',
            'id_image'          =>  'ID Image',
        ]);

        //Upload Slide Image
        if ($uploadedFile = $request->file('profile_image'))
        {
            $profile_image = Upload::singleUpload($request,'profile_image','uploads/user/','profile_image','image|mimes:jpeg,jpg,png','App\Models\Image');
            $user->image_id = $profile_image->id;
        }

        //Upload Slide Image
        if ($uploadedFile = $request->file('id_image'))
        {
            $id_image = Upload::singleUpload($request,'id_image','uploads/user/','id_image','image|mimes:jpeg,jpg,png','App\Models\Image');
        }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->save();

        $documents = UserDocuments::with('identityImage')->where('user_id', $id)->firstOrFail();
        $documents->passport_no = $request->passport_no;
        if ($uploadedFile = $request->file('id_image'))
        {
            $documents->identity_image_id = $id_image->id;
        }
        $documents->save();

        $payment_info = UserPaymentInfo::where('user_id', $user->id)->firstOrFail();
        $payment_info->bank = $request->bank;
        $payment_info->ipan_no = $request->ipan_no;

       $jop_title =  ServiceProviderJobs::where('user_id', $user->id)->firstOrFail();
       $jop_title->job_title_id = $request->job_id;

        DB::beginTransaction();

        $user->save();
        $documents->save();
        $payment_info->save();
        $jop_title->save();

        DB::commit();

        return redirect(adminUrl('user/' . $id));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->back()->with('create', 'تم مسح المستخدم بنجاح');
    }


    public function printPdf($id)
    {
        $user = \App\Models\User::with('serviceProviderJobs')->find($id);
        $events = Event::with('serviceProvider')->where('sp_id', $id)->get();
        $total_user_events = Event::with('serviceProvider')->where('sp_id', $id)->count();
        $sp_experience = ServiceProviderExperience::where('user_id', $id)->get();
        $sp_doc = UserDocuments::with('identityImage')->where('user_id', $id)->first();
        $requests = EventAttendRequest::where('user_id', $id)->count();
        $user_payment = UserPaymentInfo::where('user_id', $id)->firstOrFail();
        return view('printUser', compact('user', 'events', 'total_user_events', 'sp_experience', 'sp_doc', 'requests', 'user_payment'));
    }
    public function printIdPdf($id)
    {
        $user = \App\Models\User::with('serviceProviderJobs')->find($id);
        $events = Event::with('serviceProvider')->where('sp_id', $id)->get();
        $total_user_events = Event::with('serviceProvider')->where('sp_id', $id)->count();
        $sp_experience = ServiceProviderExperience::where('user_id', $id)->get();
        $sp_doc = UserDocuments::with('identityImage')->where('user_id', $id)->first();
        $requests = EventAttendRequest::where('user_id', $id)->count();
        $user_payment = UserPaymentInfo::where('user_id', $id)->firstOrFail();
        return view('printID', compact('user', 'events', 'total_user_events', 'sp_experience', 'sp_doc', 'requests', 'user_payment'));
    }
}
