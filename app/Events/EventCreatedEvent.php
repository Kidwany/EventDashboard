<?php

namespace App\Events;

use App\Models\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class EventCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Event
     */
    public $event;
    /**
     * @var Request
     */
    public $request;

    /**
     * @var
     */
    public $event_main_image_id;
    /**
     * @var
     */
    public $event_location_id;


    /**
     * EventCreatedEvent constructor.
     * @param Event $event
     * @param Request $request
     * @param null $event_main_image_id
     * @param null $event_location_id
     */
    public function __construct(Event $event, Request $request, $event_main_image_id = null, $event_location_id = null)
    {
        $this->event = $event;
        $this->request = $request;
        $this->event_main_image_id = $event_main_image_id;
        $this->event_location_id = $event_location_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
