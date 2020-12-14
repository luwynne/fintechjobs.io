<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobPolicy
{
    use HandlesAuthorization;

    public function createJob($user){
        return $user->company->hasJobCredits() && !$user->company->isPlanExpired();
    }
}
