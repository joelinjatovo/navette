<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->route('user');
        $roles = Role::all();
        $ids = [];
        foreach($roles as $role){
            $ids[] = $role->getKey();
        }
        return [
            'image' => 'file|mimes:jpeg,png,jpg',
            'name' => 'required|max:255',
            'phone' => 'required|numeric|unique:users,phone' . ($user ? ','.$user->getKey() : ''),
            'email' => 'required|email|unique:users,email' . ($user ? ','.$user->getKey() : ''),
            'roles.*' => ['required', Rule::in($ids)],
        ];
    }
}
