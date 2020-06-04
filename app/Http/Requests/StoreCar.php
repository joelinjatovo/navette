<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCar extends FormRequest
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
            'image' => 'file|mimes:jpeg,png,jpg',
            'name' => 'required|max:255',
            'place' => 'required|numeric',
            'driver' => 'required|exists:users,id',
            'club' => 'required|exists:clubs,id',
        ];
    }
}
