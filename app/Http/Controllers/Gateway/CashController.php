<?php

namespace App\Http\Controllers\Gateway;

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
        if (!$request->session()->has('cart')) {
            // redirect to shop order form
            return response()->json([
                'redirect' => route('shop.order'),
                'status' => 'error',
                'title' => 'Erreur',
                'message' => 'Votre panier est vide. Veuillez passer une commande!'
            ]);
        }
        
        $order = $request->session()->get('cart');
        $order->status = Order::STATUS_OK;
        $order->payment_type = Order::PAYMENT_TYPE_CASH;
        $order->payed_at = now();
        $order->save();
        
        //ProcessOrder::dispatchAfterResponse($order);
        
        //$request->session()->forget('cart');

        return response()->json([
            'redirect' => route('shop.order'),
            'status' => 'success',
            'title' => 'Merci',
            'message' => 'Le paiement est bien effectué.'
        ]);
    }
}
