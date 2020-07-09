<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Payment extends JsonResource
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
			'payment_type' => $this->payment_type,
			'payment_id' => $this->payment_id,
			'amount' => $this->amount,
			'currency' => $this->currency,
            'order' => $this->when($this->relationLoaded('order'), new Order($this->order)),
            'user' => $this->when($this->relationLoaded('user'), new User($this->user)),
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
