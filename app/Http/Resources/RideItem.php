<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RideItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
		/** 
		* Ceci vient d'un objet du Point recus du relations points du Ride
		*/
        return [
			'rid' => $this->when($this->pivot, $this->pivot->id),
			'type' => $this->when($this->pivot, $this->pivot->type),
			'status' => $this->when($this->pivot, $this->pivot->status),
			'order' => $this->when($this->pivot, $this->pivot->order),
			'duration' => $this->when($this->pivot, $this->pivot->duration),
			'distance' => $this->when($this->pivot, $this->pivot->distance),
			'direction' => $this->when($this->pivot, $this->pivot->direction),
			'duration_value' => $this->when($this->pivot, $this->pivot->duration_value),
			'distance_value' => $this->when($this->pivot, $this->pivot->distance_value),
			'actived_at' => $this->when($this->pivot, $this->pivot->actived_at),
			'arrived_at' => $this->when($this->pivot, $this->pivot->arrived_at),
			'start_at' => $this->when($this->pivot, $this->pivot->start_at),
			'started_at' => $this->when($this->pivot, $this->pivot->started_at),
			'completed_at' => $this->when($this->pivot, $this->pivot->completed_at),
			'canceled_at' => $this->when($this->pivot, $this->pivot->canceled_at),
            'point' => [
                'id' => $this->id,
                'name' => $this->name,
                'lat' => $this->lat,
                'lng' => $this->lng,
                'alt' => $this->alt,
                'created_at' => $this->created_at,
            ],
            'user' => $this->when($this->pivot, new User($this->pivot->user)),
        ];
    }
}
