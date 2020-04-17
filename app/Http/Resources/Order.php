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
            'order' => [
                'rid' => $this->id,
                'type' => $this->type,
                'status' => $this->status,
                'distance' => $this->distance,
                'place' => $this->place,
                'amount' => $this->amount,
                'subtotal' => $this->subtotal,
                'total' => $this->total,
                'vat' => $this->vat,
                'currency' => $this->currency,
                'privatized' => (boolean) $this->privatized,
                'preordered' => (boolean) $this->preordered,
                'payment_type' => $this->payment_type,
                'created_at' => $this->created_at,
            ],
            'items' => Item::collection($this->items),
            'user' => new User($this->user),
            'club' => new ClubSingle($this->club),
            'club_point' => $this->club ? new Point($this->club->point) : null,
            'car' => new CarSingle($this->car),
        ];
    }
}
