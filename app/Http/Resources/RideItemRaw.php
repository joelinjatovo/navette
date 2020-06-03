<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RideItemRaw extends JsonResource
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
		* Ceci vient d'un objet du pivot RidePoint
		*/
        return [
			'rid' => $this->id,
			'type' => $this->type,
			'status' => $this->status,
			'order' => $this->order,
			'duration' => $this->duration,
			'duration_value' => $this->duration_value,
			'distance' => $this->distance,
			'distance_value' => $this->distance_value,
			'direction' => $this->direction,
			'actived_at' => $this->actived_at,
			'arrived_at' => $this->arrived_at,
			'start_at' => $this->start_at,
			'started_at' => $this->started_at,
			'completed_at' => $this->completed_at,
			'canceled_at' => $this->canceled_at,
        ];
    }
}
