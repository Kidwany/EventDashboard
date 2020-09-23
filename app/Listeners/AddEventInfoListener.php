<?php

namespace App\Listeners;

use App\Classes\GenerateQr;
use App\Events\EventCreatedEvent;
use App\Models\EventFloors;
use App\Models\EventGates;
use App\Models\EventImages;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class AddEventInfoListener
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
    public function handle(EventCreatedEvent $event)
    {
        // Save Images
        if($uploadedFiles = $event->request->images)
        {
            foreach ($uploadedFiles as $uploadedFile):
                $fileName=time(). $uploadedFile->getClientOriginalName();
                $uploadedFile->move("uploads/events", $fileName);
                $filePath = "uploads/events/".$fileName;
                $image = Image::create(['name' => $fileName, 'path' => $filePath,'url'=>assetPath($filePath),'alt' =>"event image"]);
                $attach = new EventImages();
                $attach->image_id   = $image->id;
                $attach->event_id   = $event->event->id;
                $attach->save();
            endforeach;
        }

        $gates = array_combine($event->request->gate_type_ids, $event->request->gates_names);
        // Save Gates
        foreach ($gates as $key => $value)
        {
            $id = DB::table('event_gates')->insertGetId([
                'event_id' => $event->event->id,
                'name' => $value,
                'type_id' => $key,
                /*'barcode' => $event->event->id . $key . rand(1000, 9999) . time(),*/
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            EventGates::where('id',$id)->update(['barcode'=>GenerateQr::generateQrCode(4,"hemmtk-4,".$event->event->id.",".$id)]);
        }

        // Save Floors
        if (!empty($event->request->floors) && $event->request->floors > 0)
        {
            for ($i = 1;$i <= $event->request->floors; $i++)
            {
                $event_floor = new EventFloors();
                $event_floor->event_id = $event->event->id;
                $event_floor->floor_no = $i;
                $event_floor->barcode = $event->event->id . $i . rand(1000, 9999) . time();
                $event_floor->save();
                EventFloors::where('id',$event_floor->id)->update(['barcode'=>GenerateQr::generateQrCode(4,"hemmtk-3,".$event->event->id.",".$event_floor->id)]);
            }
        }

        for ($i = 1; $i<=14; $i++)
        {
            if ($i <= 10)
            {
                DB::table('finance_totals')->insert([
                    'category_id' => $i,
                    'event_id' => $event->event->id,
                    'total_expected' => 0,
                    'total_real_value' => 0,
                    'type' => 2,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
            else
            {
                DB::table('finance_totals')->insert([
                    'category_id' => $i,
                    'event_id' => $event->event->id,
                    'total_expected' => 0,
                    'total_real_value' => 0,
                    'type' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
