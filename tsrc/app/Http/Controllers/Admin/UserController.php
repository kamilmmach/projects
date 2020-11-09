<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\User;
use App\Role;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserAccount;
use App\Http\Requests\Admin\CreateUserAccount;

class UserController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = [
            'title' => trans('admin.users'),
            'description' => trans('admin.users_description'),
        ];
        $users = User::all();

        return view('admin.users.index', compact('page', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = [
            'title' => trans('admin.users'),
            'description' => trans('admin.create_user'),
        ];
        $role_names = Role::pluck('name', 'id');
        return view('admin.users.create', compact('page', 'role_names'));
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserAccount $request)
    {
        $request['role_id'] = $request['role'];
        $request['password'] = bcrypt($request['password']);
        
        $user = new User($request->all());
        $user->save();

        flash(trans('admin.create_user_success'), 'success');

        return redirect(route('admin.users.index'));    
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $page = [
            'title' => trans('admin.show_user'),
        ];

        return view('admin.users.show', compact('page', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $page = [
            'title' => trans('admin.edit_user'),
        ];

        $role_names = Role::pluck('name', 'id');

        $role_names = $role_names->map(function($name) {
          return trans('user.role_' . $name);
        });

        return view('admin.users.edit', compact('page', 'user', 'role_names'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  UpdateUserAccount  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserAccount $request, User $user)
	{
		$user->ts_uid = $request->get('ts_uid');
		$user->role_id = $request->role;

		if ($request->has('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        $user->save();

        flash(trans('flash.data_updated_success'), 'success');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $uname = $user->name;
        $user->delete();

        flash(trans('admin.user_delete_success', ['name' => $uname]), 'success');

        return back();
    }
}
