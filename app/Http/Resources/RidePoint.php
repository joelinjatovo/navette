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
            'ride_point' => [
                'rid' => $this->when($this->pivot, $this->pivot->id),
                'type' => $this->when($this->pivot, $this->pivot->type),
                'status' => $this->when($this->pivot, $this->pivot->status),
                'order' => $this->when($this->pivot, $this->pivot->order),
                'duration' => $this->when($this->pivot, $this->pivot->duration),
                'distance' => $this->when($this->pivot, $this->pivot->distance),
                'direction' => $this->when($this->pivot, $this->pivot->direction),
            ],
            'point' => [
                'id' => $this->id,
                'name' => $this->name,
                'lat' => $this->lat,
                'lng' => $this->lng,
                'alt' => $this->alt,
                'created_at' => $this->created_at,
            ],
            'user' => $this->when($this->pivot, new User($this->pivot->user())),
        ];
    }
}
