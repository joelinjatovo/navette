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
        $club = null;
        if($this->car && $this->car->club){
            $club = $this->car->club;
            $club = [
                'club' => [
                    'id' => $club->id,
                    'name' => $club->name,
                    'created_at' => $club->created_at,
                    'image_url' => $club->image ? $club->image->url : null,
                ],
                'point' => $club->point ? new Point($club->point) : null,
            ];
        }
        
        return [
            'ride' => [
                'id' => $this->id,
                'status' => $this->status,
                'distance' => $this->distance,
                'delay' => $this->delay,
                'direction' => $this->direction,
            ],
            'club' => $club,
            'driver' => $this->driver ? new User($this->driver) : null,
            'car' => $this->car ? new CarSingle($this->car) : null,
            'points' => RidePoint::collection($this->points),
            'items' => ItemSingle::collection($this->items),
        ];
    }
}
