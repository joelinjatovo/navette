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
        $ridepoints = [];
        if($this->point){
            foreach($this->point->ridepoints as $ridepoint){
                $ridepoints[] = [
                    'rid' => $ridepoint->id,
                    'type' => $ridepoint->type,
                    'status' => $ridepoint->status,
                    'order' => $ridepoint->order,
                    'duration' => $ridepoint->duration,
                    'distance' => $ridepoint->distance,
                    'direction' => $ridepoint->direction,
                    'duration_value' => $ridepoint->duration_value,
                    'distance_value' => $ridepoint->distance_value,
                ];
            }
        }
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
            'ridepoints' => $ridepoints,
            'ride' => new RideSingle($this->ride),
            'driver' => new User($this->driver),
            //'order' => new Order($this->order),
        ];
    }
}
