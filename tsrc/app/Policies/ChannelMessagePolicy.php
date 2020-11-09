<?php

namespace App\Policies;

use App\ChannelMessage;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChannelMessagePolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    // for now, only admins can delete messages
    public function destroy(User $user, ChannelMessage $channelMessage)
    {
        return $user->isAdmin();
    }
}
