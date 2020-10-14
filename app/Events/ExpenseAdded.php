<?php

namespace App\Events;

use App\Models\Event;
use App\Models\FinanceExpenses;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

/**
 * Class ExpenseAdded
 * @package App\Events
 */
class ExpenseAdded
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
     * @var FinanceExpenses
     */
    public $financeExpenses;

    /**
     * ExpenseAdded constructor.
     * @param Event $event
     * @param FinanceExpenses $financeExpenses
     * @param Request $request
     */
    public function __construct(Event $event, FinanceExpenses $financeExpenses, Request $request)
    {
        $this->financeExpenses = $financeExpenses;
        $this->event = $event;
        $this->request = $request;
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
