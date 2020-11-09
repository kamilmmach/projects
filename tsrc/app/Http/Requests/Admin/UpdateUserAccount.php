<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\User;

class UpdateUserAccount extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->route('user');

        return $user && $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->route('user');
        return [
            'name' => [ 'required', 'max:255', rule::unique('users')->ignore($user->id) ],
            'email' => [ 'required', 'email', 'max:255', rule::unique('users')->ignore($user->id) ],
            'password' => 'sometimes|min:6',
			'ts_uid' => 'required|size:28|tsuid_exists',
			'role' => 'required|numeric|exists:roles,id',
        ];
    }
}
