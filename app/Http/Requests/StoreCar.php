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
            'car.image' => 'file|mimes:jpeg,png,jpg',
            'car.name' => 'required|max:255',
            'car.year' => 'required|numeric',
            'car.place' => 'required|numeric',
            'car.model' => 'required|exists:car_models,id',
            'car.driver' => 'required|exists:users,id',
            'car.club' => 'required|exists:clubs,id',
        ];
    }
}
