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
        return false;
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
            'contact_name' => 'max:100',
            'contact_email' => 'email|max:100',
            'phone.phone_country_code' => 'required|numeric|max:10',
            'phone.phone_number' => 'required|numeric|max:20',
            'started_at' => 'required|datetime',
            'start_point.name' => 'required|max:200',
            'start_point.lat' => 'required|float:10,7',
            'start_point.long' => 'required|float:10,7',
            'start_point.alt' => 'required|float:10,7',
            'arrival_point.name' => 'required|max:200',
            'arrival_point.lat' => 'required|float:10,7',
            'arrival_point.long' => 'required|float:10,7',
            'arrival_point.alt' => 'required|float:10,7',
            'return_point.name' => 'required|max:200',
            'return_point.lat' => 'required|float:10,7',
            'return_point.long' => 'required|float:10,7',
            'return_point.alt' => 'required|float:10,7',
        ];
    }
}
