<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Role;

class UserController extends Controller
{
    /**
     * Show the form for editing the user.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('edit', $user);

        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    protected function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $this->validate($request, [
            'password' => 'sometimes|min:6|confirmed',
            'ts_uid' => 'required|size:28|tsuid_exists'
        ]);

        $user->ts_uid = $request->get('ts_uid');

        if ($request->has('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        $user->save();

        flash(trans('flash.data_updated_success'), 'success');

        return back();
    }
}
