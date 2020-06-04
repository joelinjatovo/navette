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
			'rid' => $this->id,
			'type' => $this->type,
			'status' => $this->status,
			'suggestion_count' => $this->suggestion_count,
			'distance_value' => $this->distance_value,
			'distance' => $this->distance,
			'duration_value' => $this->duration_value,
			'duration' => $this->duration,
			'direction' => $this->direction,
			'ride_at' => $this->ride_at,
			'start_at' => $this->start_at,
			'actived_at' => $this->actived_at,
			'arrived_at' => $this->arrived_at,
			'started_at' => $this->started_at,
			'canceled_at' => $this->canceled_at,
			'completed_at' => $this->completed_at,
			'created_at' => $this->created_at,
            'point' => $this->when($this->relationLoaded('point'), new Point($this->point)),
            'order' => $this->when($this->relationLoaded('order'), new Order($this->order)),
            'rideitem' => $this->when($this->pivot, new RideItem($this->pivot)),
			'rides' => Ride::collection($this->whenLoaded('rides')),
			'suggestions' => [],
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
			"errors": [],
        ];
    }
}
