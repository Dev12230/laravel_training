<?php

namespace App\Providers;

use App\Events\RegisterUserAdded;
use App\Listeners\SendWelcomeEmail;
use App\Events\EventInvitation;
use App\Listeners\EventInvitationListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RegisterUserAdded::class => [
            SendWelcomeEmail::class,
        ],
        EventInvitation::class => [
            EventInvitationListener::class,
        ],
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
