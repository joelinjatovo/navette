<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClubItem extends JsonResource
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
            'status' => 200,
            'code' => 0,
            'message' => null,
            'errors' => [],
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'point' => $this->point ? new Point($this->point) : null,
                'created_at' => $this->created_at,
                'image' => $this->image ? new Image($this->image) : null,
            ]
        ];
    }
}
