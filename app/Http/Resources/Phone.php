<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Phone extends JsonResource
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
            'id' => $this->id,
            'type' => $this->type,
            'phone' => $this->phone,
            'created_at' => $this->created_at,
        ];
    }
}
