<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\NotificationClass;
use App\Http\Controllers\Controller;
use App\Models\UserToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications =  \App\Models\Notification::orderBy('created_at', 'desc')->get();
        return view('dashboard.notification.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.notification.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'receivers'     =>  'required|int',
            'title'         =>  'required|min:5',
            'desc'          =>  'required|min:5',
        ], [] , [
            'receivers'     =>  'Type Of  receivers',
            'title'         =>  'Title',
            'desc'          =>  'Description Of Notification',
        ]);

        $typeOfReceivers = $request->receivers;

        // Save Notification
        $sentNotification = new \App\Models\Notification();
        $sentNotification->type = 'New Notification';
        $sentNotification->notifiable_type = 'user';
        $sentNotification->title = $request->title;
        $sentNotification->sent_from = Auth::id();
        $sentNotification->data = $request->desc;
        $sentNotification->save();


        // User want to send notification to logged in users before
        if ($typeOfReceivers == 1)
        {
            $userTokens = UserToken::where('user_id', '!=', null)->get();

            $tokens = [];
            foreach ($userTokens as $userToken)
            {
                array_push($tokens, $userToken->token);
            }
            // Send Notification
            NotificationClass::multiplePushNotification($request->title, $request->desc, array_values(array_unique($tokens)));
            return redirect(adminUrl('notification'))->with('create', 'تم ارسال الإشعار للمستخدمين بنجاح');
        }
        // Send Notification to Not Logged in Users
        elseif ($typeOfReceivers == 2)
        {
            $userTokens = UserToken::where('user_id', null)->get();
            $tokens = [];
            foreach ($userTokens as $userToken)
            {
                array_push($tokens, $userToken->token);
            }
            // Send Notification
            NotificationClass::multiplePushNotification($request->title, $request->desc, array_values(array_unique($tokens)));
            return redirect(adminUrl('notification'))->with('create', 'تم ارسال الإشعار للمستخدمين بنجاح');
        }

        elseif ($typeOfReceivers == 3)
        {
            $userTokens = UserToken::all();
            $tokens = [];
            foreach ($userTokens as $userToken)
            {
                array_push($tokens, $userToken->token);
            }
            // Send Notification
            NotificationClass::multiplePushNotification($request->title, $request->desc, array_values(array_unique($tokens)));
            return redirect(adminUrl('notification'))->with('create', 'تم ارسال الإشعار للمستخدمين بنجاح');
        }
    }

}
