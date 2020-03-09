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
        return [
            'code' => 200,
            'status' => "success",
            'message' => null,
            'errors' => [],
            'data' => [
                'token' => $this->scopes,
                'expires' => strtotime($this->expires_at),
                'refresh_token' => $this->refreshToken ? $this->refreshToken->scope : null,
                'refresh_token_expires' => $this->refreshToken ? strtotime($this->refreshToken->expires_at) : null,
            ]
        ];
    }
}
