<?php

namespace App\Http\Controllers\Api\v1\Gateway;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order as OrderResource;
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
        $order = Order::findOrFail($request->input('id'));
        
        $order->status = Order::STATUS_ON_HOLD;
        $order->payment_type = Order::PAYMENT_TYPE_PAYPAL;
        $order->save();
        
        return new OrderResource($order);
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
