<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RideSingle extends JsonResource
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
			'distance' => $this->distance,
			'distance_value' => $this->distance_value,
			'duration' => $this->duration,
			'duration_value' => $this->duration_value,
			'direction' => $this->direction,
			'start_at' => $this->start_at,
			'started_at' => $this->started_at,
			'completed_at' => $this->completed_at,
			'canceled_at' => $this->canceled_at,
			'created_at' => $this->created_at,
        ];
    }
}
