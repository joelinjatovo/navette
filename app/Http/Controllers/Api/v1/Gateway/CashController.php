<?php

namespace App\Http\Controllers\Api\v1\Gateway;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderItem as OrderItemResource;
use App\Jobs\ProcessOrder;
use App\Models\Order;
use Illuminate\Http\Request;

class CashController extends Controller
{
    /**
     * Pay order per cash
     *
     * @param  Request  $type
     * @param  String  $zone
     * @return Response
     */
    public function pay(Request $request)
    {
        $order = Order::findOrFail($request->input('order_id'));
        
        $order->status = Order::STATUS_OK;
        $order->payment_type = Order::PAYMENT_TYPE_CASH;
        $order->payed_at = now();
        $order->save();
        
        ProcessOrder::dispatchAfterResponse($order);
        
        return new OrderItemResource($order);
    }
}