<?php

namespace App\Listeners;


use App\Events\RegisterUserAdded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
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
     * @param  RegisterUserAdded  $event
     * @return void
     */
    public function handle(RegisterUserAdded $event)
    {
        Mail::to($event->user->email)->send(new WelcomeMail($event->user));

    }
}
