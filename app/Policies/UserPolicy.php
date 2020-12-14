<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class UserPolicy
{
    use HandlesAuthorization;

    public function inviteNewUser($user, $new_mail_user){
        $company_users = User::where('company_id', $user->company->id)->get();
        $emails_users_collection = collect($company_users->pluck('email'));
        return $company_users->count() < 3 && !$emails_users_collection->contains($new_mail_user);
    }

    public function touchUser($user){
        return $user->role == 'admin';
    }

}
