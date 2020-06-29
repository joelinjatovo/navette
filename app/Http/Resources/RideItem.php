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
			'rid' => $this->id,
			'type' => $this->type,
			'place' => $this->place,
			'status' => $this->status,
			'order' => $this->order,
			'duration' => $this->duration,
			'duration_value' => $this->duration_value,
			'distance' => $this->distance,
			'distance_value' => $this->distance_value,
			'direction' => $this->direction,
			'arrived_at' => $this->arrived_at,
			'start_at' => $this->start_at,
			'started_at' => $this->started_at,
			'complete_at' => $this->complete_at,
			'completed_at' => $this->completed_at,
			'canceled_at' => $this->canceled_at,
            'item' => $this->when($this->relationLoaded('item'), new Item($this->item)),
            'ride' => $this->when($this->relationLoaded('ride'), new Ride($this->ride)),
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
