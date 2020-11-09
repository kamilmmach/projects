<?php

namespace App\Policies;

use App\Channel;
use App\Http\Requests\ChannelRequest;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChannelPolicy
{
    use HandlesAuthorization;

     /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    public function indexAdmin(User $user, $ability)
    {
        return $user->isAdmin();
    }

    public function addMessage(User $user, Channel $channel)
    {
        return $user->owns($channel);
    }

    public function show(User $user, Channel $channel)
    {
        return $user->owns($channel);
    }

    public function edit(User $user, Channel $channel)
    {
        return $user->owns($channel) &&
        $channel->isPending();
    }

    public function editAdmin(User $user, Channel $channel)
    {
        return $user->isAdmin();
    }

    public function update(User $user, Channel $channel)
    {
        return $user->owns($channel) &&
        $channel->isPending();
    }

    public function destroy(User $user, Channel $channel)
    {
        return $user->owns($channel) &&
        $channel->isPending();
    }

    public function respond(User $user, Channel $channel)
    {
        return $user->isAdmin();
    }
}
