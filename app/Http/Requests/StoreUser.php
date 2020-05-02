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
            'user.name' => 'required|max:255',
            'user.phone' => 'required|numeric|unique:users',
            'user.password' => 'required|max:8',
        ];
    }
}
