<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Club extends JsonResource
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
			'name' => $this->name,
			'created_at' => $this->created_at,
			'image_url' => $this->image ? $this->image->url : null,
            'point' => $this->point ? new Point($this->point) : null,
            //'cars' => Car::collection($this->cars),
        ];
    }
}
