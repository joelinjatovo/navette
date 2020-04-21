<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Item extends JsonResource
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
            'item' => [
                'rid' => $this->id,
                'type' => $this->type,
                'status' => $this->status,
                'distance_value' => $this->distance_value,
                'distance' => $this->distance,
                'duration_value' => $this->duration_value,
                'duration' => $this->duration,
                'direction' => $this->direction,
                'ride_at' => $this->ride_at,
                'completed_at' => $this->completed_at,
                'created_at' => $this->created_at,
            ],
            'point' => new Point($this->point),
            'ride' => new RideSingle($this->ride),
            'driver' => new User($this->driver),
            //'order' => new Order($this->order),
        ];
    }
}
