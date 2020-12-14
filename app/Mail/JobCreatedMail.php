<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobCreatedMail extends Mailable{

    use Queueable, SerializesModels;

    public $job;

    public function __construct($job){
        $this->job = $job;
    }

    public function build(){
        return $this->view('mails.jobCreated')
                    ->from('info@fintechjobs.io','Fintechjobs.io')
                    ->subject('Fintechjobs.io | New job created');
    }
}
