<?php

namespace App\Helpers;

use App\Models\Zone;
use App\Models\Order;

class ShopHelper
{
 
    /**
    * Create order with the zone
    * @params Zone $zone
    * @params array $data
    */
    public function order(Zone $zone, $data) {
        $order = new Order($data);
        $order->calculate($zone);
        return $zone->orders()->save($data);
    }
}
