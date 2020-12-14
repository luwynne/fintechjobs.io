<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    public function createCourse($user){
        return $user->company->hasCourseCredits() && !$user->company->isPlanExpired();
    }
}
