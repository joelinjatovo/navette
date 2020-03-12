<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Success extends JsonResource
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
            'code' => 200,
            'status' => 0,
            'message' => null,
            'errors' => [],
            'data' => null
        ];
    }
}
