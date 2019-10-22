<?php

namespace App\Listeners;

use App\Events\EventInvitation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\InvitationMail;
use Illuminate\Support\Facades\Mail;

class EventInvitationListener
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
     * @param  EventInvitation  $event
     * @return void
     */
    public function handle(EventInvitation $event)
    {
        foreach ($event->event->visitors as $visitor) {
            Mail::to($visitor->user->email)->send(new InvitationMail($event->event));
        }
    }
}
