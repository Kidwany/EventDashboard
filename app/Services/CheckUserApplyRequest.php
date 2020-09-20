<?php
/**
 * Created by PhpStorm.
 * User: Kidwany
 * Date: 9/6/2020
 * Time: 11:44 PM
 */

namespace App\Services;


use App\Models\Event;
use App\Models\EventAttendRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CheckUserApplyRequest
{

    /**
     * this function check if user applied for any other events during the new event period
     */
    public function checkUserApplications($event_id)
    {
        $requested_event = Event::find($event_id);
        // Get Events Which Assigned to this Organizer
        $accepted_events_count = Event::where('sp_id', Auth::user()->id)
            ->where('event_date', '>=', Carbon::now())
            ->where('event_start', '<=', $requested_event->event_start)
            ->where('event_end', '>=', $requested_event->event_end)
            ->get();


    }
}
