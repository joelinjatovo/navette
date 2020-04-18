<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Ride extends JsonResource
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
            'ride' => [
                'id' => $this->id,
                'status' => $this->status,
                'distance' => $this->distance,
                'delay' => $this->delay,
                'direction' => $this->direction,
            ],
            'driver' => $this->driver ? new User($this->driver) : null,
            'car' => $this->car ? new CarSingle($this->car) : null,
            'points' => RidePoint::collection($this->points),
            'items' => ItemSingle::collection($this->items),
        ];
    }
}
