<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventAttendRequest;
use App\Models\JobTitle;
use App\Models\ServiceProviderTask;
use App\Models\UserGroup;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $organization_id = Auth::user()->id;
        $events = Event::all()->where('organization_id', $organization_id)->count();
        $events_ids = DB::table('events')->where('organization_id', $organization_id)->pluck('id');
        $applicants = EventAttendRequest::all()->whereIn('event_id', $events_ids)->count();
        $latest_events = Event::all()->where('organization_id', $organization_id);
        $groups = UserGroup::all()->whereIn('event_id', $events_ids)->count();
        $tasks = ServiceProviderTask::all()->where('organization_id', $organization_id)->count();
        // Get All Groups of this event
        $existed_groups = DB::table('user_groups')->whereIn('event_id', $events_ids)->pluck('id');
        $supervisors = DB::table('user_group_members')
            ->whereIn('user_group_id', $existed_groups)
            ->where('is_manager', 1)->count();

        return view('dashboard.welcome', compact( 'events', 'applicants', 'latest_events', 'groups', 'tasks', 'supervisors'));
    }

    public function logout()
    {
        auth()->logout();
        // redirect to homepage
        return redirect('/login');
    }
}
