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
			'id' => $this->id,
			'status' => $this->status,
			'available_place' => $this->available_place,
			'current_place' => $this->current_place,
			'max_place' => $this->max_place,
			'distance' => $this->distance,
			'distance_value' => $this->distance_value,
			'duration' => $this->duration,
			'duration_value' => $this->duration_value,
			'direction' => $this->direction,
			'start_at' => $this->start_at,
			'started_at' => $this->started_at,
			'complete_at' => $this->complete_at,
			'completed_at' => $this->completed_at,
			'canceled_at' => $this->canceled_at,
			'created_at' => $this->created_at,
            'driver' => $this->when($this->relationLoaded('driver'), new User($this->driver)),
            'rideitem' => $this->when($this->pivot, new RideItem($this->pivot)),
            'items' => Item::collection($this->whenLoaded('items')),
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
