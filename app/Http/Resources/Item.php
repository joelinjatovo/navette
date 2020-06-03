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
			
			// The item point
            'point' => new Point($this->point),
			
			// The item order
            'order' => new OrderSingle($this->order),
			
			// The ride assigned to this item
            'ride' => new RideSingle($this->ride),
			
			// And his driver
            'driver' => new User($this->driver),
			
			// The related ride points
            'ridepoints' => RidePointSingle::collection($this->ridepoints),
        ];
    }
}
