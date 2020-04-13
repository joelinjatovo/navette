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
        switch($type){
            case Order::PAYMENT_TYPE_CASH:
                $order->status = Order::STATUS_OK;
                $order->payment_type = $type;
                $order->payed_at = now();
                $order->save();
            break;
            case Order::PAYMENT_TYPE_STRIPE:
            case Order::PAYMENT_TYPE_PAYPAL:
            case Order::PAYMENT_TYPE_APPLE_CASH:
            default:
                $order->status = Order::STATUS_PROCESSING;
                $order->payment_type = $type;
                $order->save();
            break;
        }
        
        return new OrderItemResource($order);
    }
}
