<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderItem as OrderItemResource;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    

    /**
     * Confirm payment type for an order.
     *
     * @param  Request  $type
     * @param  String  $zone
     * @return Response
     */
    public function confirm(Request $request, Order $order, $type)
    {
        $order->payment_type = $type;
        $order->payed_at = now();
        $order->save();
        
        return new OrderItemResource($order);
    }
}
