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
			'id' => $this->id,
			'status' => $this->status,
			'name' => $this->name,
			'type' => $this->type,
			'place' => $this->place,
			'description' => $this->description,
			'created_at' => $this->created_at,
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
