<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RidePoint extends JsonResource
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
            'type' => $this->when($this->pivot, $this->pivot->type),
            'status' => $this->when($this->pivot, $this->pivot->status),
            'order' => $this->when($this->pivot, $this->pivot->order),
            'name' => $this->name,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'alt' => $this->alt,
            'created_at' => $this->created_at,
        ];
    }
}
