<?php

namespace App\Listeners;

use App\Events\EventCreatedEvent;
use App\Events\EventUpdatedEvent;
use App\Models\EventFloors;
use App\Models\EventImages;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class UpdateEventInfoListener
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
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(EventUpdatedEvent $event)
    {
        // Save Images
        if($uploadedFiles = $event->request->images)
        {
            foreach ($uploadedFiles as $uploadedFile):
                $fileName=time(). $uploadedFile->getClientOriginalName();
                $uploadedFile->move("uploads/events", $fileName);
                $filePath = "uploads/events".$fileName;
                $image = Image::create(['name' => $fileName, 'path' => $filePath,'url'=>assetPath($filePath),'alt' =>"event image"]);
                $attach = new EventImages();
                $attach->image_id   = $image->id;
                $attach->event_id   = $event->event->id;
                $attach->save();
            endforeach;
        }

    }
}
