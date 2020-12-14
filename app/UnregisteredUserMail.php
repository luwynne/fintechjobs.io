<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnregisteredUserMail extends Model{


    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
