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
            'id' => $this->getKey(),
            'stripe_id' => $this->stripe_id,
            'payment_method_id' => $this->payment_method_id,
            'facebook_id' => $this->facebook_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birthday' => $this->birthday,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'postal_code' => $this->postal_code,
            'locale' => $this->locale,
            'verified' => $this->hasVerifiedPhone(),
            'image_url' => $this->image ? url($this->image->url) : null,
            'roles' => Role::collection($this->whenLoaded('roles')),
            'rating' => $this->rating(),
            'reviews' => $this->reviews(),
            'car' => new Car($this->car),
            'license_recto' => $this->licenseRecto ? url($this->licenseRecto->url) : null,
            'license_verso' => $this->licenseVerso ? url($this->licenseVerso->url) : null,
            'vtc_recto' => $this->vtcRecto ? url($this->vtcRecto->url) : null,
            'vtc_verso' => $this->vtcVerso ? url($this->vtcVerso->url) : null,
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'http_status' => 200,
            'status_code' => 0,
            'message' => null,
			"errors" => [],
        ];
    }
}
