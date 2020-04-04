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
                'status' => $this->status,
                'place' => $this->place,
                'amount' => $this->amount,
                'subtotal' => $this->subtotal,
                'total' => $this->total,
                'vat' => $this->vat,
                'currency' => $this->currency,
                'privatized' => (boolean) $this->privatized,
                'preordered' => (boolean) $this->preordered,
                'payment_type' => $this->payment_type,
                'distance' => $this->distance,
                'delay' => $this->delay,
                'direction' => $this->direction,
                'created_at' => $this->created_at,
            ],
            'user' => $this->club ? new ClubSingle($this->club) : null,
            'club' => $this->club ? new ClubSingle($this->club) : null,
            'car' => $this->car ? new CarSingle($this->car) : null,
            'points' => Point::collection($this->points),
            'phone' => Phone::collection($this->phones),
        ];
    }
}
