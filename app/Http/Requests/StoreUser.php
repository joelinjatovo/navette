<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;

        /*
        
        $comment = Comment::find($this->route('comment'));
        
        return $comment && $this->user()->can('update', $comment);
        
        */
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'phone' => 'required|numeric|unique:users',
            'password' => 'required|max:8',
            'email' => 'required|email|unique:users',

           /* 'name' => 'max:255',
            'phone' => 'unique:users',
            'password' => 'max:8',*/
        ];
    }
    
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Your name is required',
            'phone.required'  => 'Your phone number is required',
            'password.required'  => 'A password is required',
            'email.required' => 'An email address is required',
        ];
    }
}
