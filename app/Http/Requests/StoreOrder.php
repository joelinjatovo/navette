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
            
            //'phone.phone_country_code' => 'required|numeric',
            //'phone.phone_number' => 'required|numeric',
            
            'origin.name' => 'required',
            'origin.lat' => 'required',
            'origin.lng' => 'required',
            //'origin.alt' => 'required',
            
            //'retours.name' => 'required',
            //'retours.lat' => 'required',
            //'retours.lng' => 'required',
            //'retours.alt' => 'required',
            
        ];
    }
}
