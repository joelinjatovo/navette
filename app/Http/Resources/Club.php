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
            'point' => $this->point ? new Point($this->point) : null,
            'created_at' => $this->created_at,
            'image' => $this->image ? new Image($this->image) : null,
        ];
    }
}
