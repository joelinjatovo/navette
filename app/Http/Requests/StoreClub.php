<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClub extends FormRequest
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
            'max_car_place' => 'nullable|min:1|max:100',
            'point.name' => 'nullable',
            'point.lat' => 'required',
            'point.lng' => 'required',
        ];
    }
}
