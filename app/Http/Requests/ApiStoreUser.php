<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiStoreUser extends FormRequest
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
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'birthday' => 'nullable|string|max:100',
            'code' => 'nullable|string|max:100',
            'phone' => 'nullable|numeric|unique:users',
            'password' => 'nullable|string|min:4|max:32',
            'email' => 'nullable|email|unique:users',
        ];
    }
}
