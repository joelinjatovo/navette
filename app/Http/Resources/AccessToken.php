<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccessToken extends JsonResource
{
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [];
        if( null != $this->user ) {
            $data = [
                'id' => $this->user->getKey(),
                'stripe_id' => $this->user->stripe_id,
                'payment_method_id' => $this->user->payment_method_id,
                'facebook_id' => $this->user->facebook_id,
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'birthday' => $this->user->birthday,
                'name' => $this->user->name,
                'email' => $this->user->email,
                'phone' => $this->user->phone,
                'address' => $this->user->address,
                'address' => $this->user->address,
                'postal_code' => $this->user->postal_code,
                'locale' => $this->user->locale,
                'verified' => $this->user->hasVerifiedPhone(),
                'image_url' => $this->user->image ? $this->user->image->url : null,
                'roles' => Role::collection($this->user->roles),
            ];
        }
        
        return [
            'status' => 200,
            'code' => 0,
            'message' => null,
            'errors' => [],
            'data' => array_merge(
                $data, [
                    'token' => $this->scopes,
                    'token_expires' => strtotime($this->expires_at),
                    'refresh_token' => $this->refreshToken ? $this->refreshToken->scopes : null,
                    'refresh_token_expires' => $this->refreshToken ? strtotime($this->refreshToken->expires_at) : null,
                ]
            ),
        ];
    }
}
