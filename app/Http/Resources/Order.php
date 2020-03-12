<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
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
            'status' => "success",
            'message' => null,
            'error_code' => 0,
            'errors' => [],
            'data' => [
                'id' => $this->id,
                'place' => $this->place,
                'amount' => $this->amount,
                'subtotal' => $this->subtotal,
                'total' => $this->total,
                'vat' => $this->vat,
                'currency' => $this->currency,
                'privatized' => $this->privatized,
                'preordered' => $this->preordered,
                'created_at' => $this->created_at,
                'points' => Point::collection($this->points),
                'phone' => Phone::collection($this->phones),
            ]
        ];
    }
}
