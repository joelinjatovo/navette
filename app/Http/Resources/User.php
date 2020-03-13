<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status' => 200,
            'code' => 0,
            'message' => null,
            'errors' => [],
            'data' => [
                'id' => $this->getKey(),
                'facebook_id' => $this->facebook_id,
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'locale' => $this->locale,
                'verified' => $this->hasVerifiedPhone(),
                'is_admin' => $this->isAdmin(),
                'is_driver' => $this->isDriver(),
                'is_customer' => $this->isCustomer(),
            ]
        ];
    }
}
