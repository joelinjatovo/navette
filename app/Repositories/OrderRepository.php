<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class OrderRepository extends Repository
{

    public function __construct(Model $model = null)
    {
        $this->model = new \App\Models\Order();
    }
    
    /**
     * Calculate the order
     *
     * @params Order $order
     * @params Zone $zone
     */
    public function calculate($order, $zone)
    {
        $order->vat = 0;
        $order->amount = $zone->price;
        $order->currency = $zone->currency;
        $order->subtotal = $order->place * $zone->price;
        $order->total = $order->subtotal + $order->subtotal * $order->vat;
        
        return $order;
    }
}