<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPosition extends JsonResource
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
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'lat' => $this->lat,
                'long' => $this->long,
                'alt' => $this->alt,
                'created_at' => $this->created_at,
            ]
        ];
    }
}
