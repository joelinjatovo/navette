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
        $roles = [];
        foreach($this->roles as $role){
            $roles[] = $role->name;
        }
        
        return [
            'id' => $this->getKey(),
            'facebook_id' => $this->facebook_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'locale' => $this->locale,
            'verified' => $this->hasVerifiedPhone(),
            'image_url' => $this->image ? $this->image->url : null,
            'roles' => $roles
        ];
    }
}
