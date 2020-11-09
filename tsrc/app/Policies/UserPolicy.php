<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function index(User $user, $something)
    {
        return true;
    }
    // for now, only admins can delete messages
    public function edit(User $user, User $user_target)
    {
        return $user->id == $user_target->id;
    }

    public function update(User $user, User $user_target)
    {
        return $user->id == $user_target->id;
    }
}
