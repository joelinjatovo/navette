<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrder extends FormRequest
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
            'place' => 'required|numeric|min:0|max:10',
            'preordered' => 'required',
            'privatized' => 'required',
            
            'phone.phone_country_code' => 'required|numeric',
            'phone.phone_number' => 'required|numeric',
            
            'points.a.name' => 'required',
            'points.a.lat' => 'required',
            'points.a.long' => 'required',
            'points.a.alt' => 'required',
            
            'points.b.name' => 'required',
            'points.b.lat' => 'required',
            'points.b.long' => 'required',
            'points.b.alt' => 'required',
            
        ];
    }
}
