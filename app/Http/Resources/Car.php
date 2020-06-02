<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Car extends JsonResource
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
			'id'   => $this->getKey(),
			'name' => $this->name,
			'year' => $this->year,
			'place' => $this->place,
			'image_url' => $this->image ? $this->image->url : null,
            'model' => $this->model ? new CarModel($this->model) : null,
            'driver' => $this->driver ? new User($this->driver) : null,
        ];
    }
}
