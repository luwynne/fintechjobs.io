<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class ApplicationCreatedMail extends Mailable{

    use Queueable, SerializesModels;

    public $job_id;
    public $name;
    public $email;
    public $phone;
    public $linkedin;
    public $cover_letter;
    public $job_applied;
    public $newsletter = false;
    public $file;

    public function __construct($application, $data, $file){
        $this->job_id = $data['job_id'] ;
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->phone = $data['phone'];
        $this->linkedin = $data['linkedin'];
        $this->cover_letter = $data['cover_letter'];
        $this->job_applied = $data['job_applied'];
        $this->file = $file;
    }

    public function build(){
        return $this->view('mails.jobapplication')
                    ->from('info@fintechjobs.io','Fintechjobs.io')
                    ->subject('Job Application | Fintechjobs.io')
                    ->attach($this->file, [
                        'as' => Carbon::now()->format('Y-m-d').'_'.$this->job_id.'_'.str_replace(' ', '_', $this->name).'.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
