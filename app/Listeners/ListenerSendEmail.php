<?php

namespace App\Listeners;

use App\Events\SendEmail;
use App\Mail\addlivreMail;
use App\Mail\SendEmailM;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ListenerSendEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendEmail $event): void
    {
        if($event->nm=='utilisateur'){
             $email=$event->compte->email;
        }else{
            $email=$event->compte['utilisateurs']['email'];
        }

        // dd($event->message);
        Mail::to($email)->send(new SendEmailM($event->compte,$event->object,$event->message,$event->nm));
    }
}
