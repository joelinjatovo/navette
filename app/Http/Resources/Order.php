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
			'rid' => $this->id,
			'type' => $this->type,
			'status' => $this->status,
			'distance' => $this->distance,
			'place' => $this->place,
			'coefficient' => $this->coefficient,
			'amount' => $this->amount,
			'subtotal' => $this->subtotal,
			'total' => $this->total,
			'vat' => $this->vat,
			'currency' => $this->currency,
			'privatized' => (boolean) $this->privatized,
			'preordered' => (boolean) $this->preordered,
			'payment_type' => $this->payment_type,
			'payment_status' => $this->payment_status,
			'paid_at' => $this->paid_at,
			'refunded_at' => $this->refunded_at,
			'canceled_at' => $this->canceled_at,
			'completed_at' => $this->completed_at,
			'created_at' => $this->created_at,
            'user' => $this->when($this->relationLoaded('user'), new User($this->user)),
            'club' => $this->when($this->relationLoaded('club'), new Club($this->club)),
            'items' => Item::collection($this->whenLoaded('items')),
        ];
    }
}
