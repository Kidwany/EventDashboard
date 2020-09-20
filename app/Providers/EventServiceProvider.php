<?php

namespace App\Providers;

use App\Events\EventCreatedEvent;
use App\Events\EventUpdatedEvent;
use App\Listeners\AddEventInfoListener;
use App\Listeners\EventBackupListener;
use App\Listeners\UpdateEventInfoListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        EventCreatedEvent::class => [
            AddEventInfoListener::class,
            EventBackupListener::class
        ],
        EventUpdatedEvent::class => [
            UpdateEventInfoListener::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
