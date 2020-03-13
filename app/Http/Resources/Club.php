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
            'status' => 200,
            'code' => 0,
            'message' => null,
            'errors' => [],
            'data' => [
                'id' => $this->id,
                'created_at' => $this->created_at,
            ]
        ];
    }
}
