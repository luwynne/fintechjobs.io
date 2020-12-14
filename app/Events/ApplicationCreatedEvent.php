<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Application;
use Mail;
use App\Mail\ApplicationCreatedMail;

class ApplicationCreatedEvent{
    
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public function __construct(Application $application, $data, $file, $recruiter_email, $recruiter_name){
        Mail::to($recruiter_email, $recruiter_name)->send(new ApplicationCreatedMail($application, $data, $file));
    }
}
