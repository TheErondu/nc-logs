<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use App\Events\EngineerAssignedEvent;
use App\Events\TicketCreatedEvent;
use App\Events\TicketUpdatedEvent;
use App\Listeners\EngineerAssignedEventListener;
use App\Listeners\TicketCreatedListener;
use App\Listeners\TicketUpdatedListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TicketCreatedEvent::class => [
            TicketCreatedListener::class,
        ],
        TicketUpdatedEvent::class => [
            TicketUpdatedListener::class,
        ],

        EngineerAssignedEvent::class => [
            EngineerAssignedEventListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
