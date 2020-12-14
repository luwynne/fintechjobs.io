<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Job;
use App\User;

class Application extends Model
{
    protected $fillable = [
        'job_id', 'name', 'email', 'phone', 'linkedin', 'cover_letter', 'file', 'user_id'
    ];

    public function job(){
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
