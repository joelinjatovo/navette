<?php

namespace App\Http\Controllers\Api\v1\Gateway;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order as OrderResource;
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
        $order = Order::findOrFail($request->input('id'));
        
        $order->status = Order::STATUS_OK;
        $order->payment_type = Order::PAYMENT_TYPE_CASH;
        $order->save();
        
        return new OrderResource($order);
    }
	
    /**
     * Confirm order per cash
     *
     * @param  Request  $type
     * @param  String  $zone
     * @return Response
     */
    public function confirm(Request $request)
    {
        $order = Order::findOrFail($request->input('id'));
    	
        $order->paidPer(Order::PAYMENT_TYPE_CASH);
        
        return new OrderResource($order);
    }
}
