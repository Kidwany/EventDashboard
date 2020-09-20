<?php

namespace App\Listeners;

use App\Events\EventCreatedEvent;
use App\Models\EventBackup;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class EventBackupListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * @param EventCreatedEvent $event
     */
    public function handle(EventCreatedEvent $event)
    {

        // Save Event
        $event_backup = new EventBackup();
        $event_backup->title = $event->request->title;
        $event_backup->organization_id = Auth::user()->id;
        $event_backup->slug = $event->request->title;
        $event_backup->description = $event->request->description;
        $event_backup->event_date = date('Y-m-d', strtotime($event->request->start));
        $event_backup->event_start = date('Y-m-d', strtotime($event->request->start));
        $event_backup->event_end = date('Y-m-d', strtotime($event->request->end));
        $event_backup->floors = $event->request->floors;
        $event_backup->floor_no = $event->request->floor_no;
        $event_backup->status_id = 3;
        $event_backup->country_id = $event->request->country_id;
        $event_backup->city_id = $event->request->city_id;
        $event_backup->place = $event->request->address;
        $event_backup->category_id = $event->request->category_id;
        $event_backup->image_id = $event->event_main_image_id;
        $event_backup->location_id = $event->event_location_id;
        $event_backup->save();
    }
}
