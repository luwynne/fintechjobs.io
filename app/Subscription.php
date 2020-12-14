<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use App\Company;
// use App\User;

class Subscription extends Model{

    protected $fillable = [
        'user_id', 'name', 'stripe_id', 'stripe_plan', 'quantity', 'trial_ends_at', 'ends_at'
    ];

}
