<?php

namespace App\Http\Controllers\Api\v1\Gateway;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderItem as OrderItemResource;
use App\Models\Order;
use Illuminate\Http\Request;

class PayPalController extends Controller
{
    /**
     * Pay order per PayPal
     *
     * @param  Request  $type
     * @param  String  $zone
     * @return Response
     */
    public function pay(Request $request)
    {
        $order = Order::findOrFail($request->input('order_id'));
        
        $order->status = Order::STATUS_ON_HOLD;
        $order->payment_type = Order::PAYMENT_TYPE_PAYPAL;
        $order->save();
        
        return new OrderItemResource($order);
    }
    
    /**
     * Handle PayPal webhook
     *
     * @param  Request  $request
     * @return Response
     */
    public function webhook(Request $request){
        $output = [
            'status' => 'success',
            'details' => 'ok'
        ];

        return response()->json($output);
    }
}
