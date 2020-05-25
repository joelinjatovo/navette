<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ProfileRequest extends FormRequest
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
        return [
            'profile.image' => 'file|mimes:jpeg,png,jpg',
            'profile.name' => 'required|max:255',
            'profile.phone' => 'required|numeric|unique:users,phone,' . auth()->user()->id,
            'profile.email' => 'required|email|unique:users,email,' . auth()->user()->id,
            'old_password' => [
				'required_with:new_password',
				function ($attribute, $value, $fail) {
					if (!Hash::check($value, Auth::user()->password)) {
						$fail(trans('Old Password didn\'t match'));
					}
				}
			],
            'new_password' => 'required_with:old_password|min:8|confirmed',
        ];
    }
}
