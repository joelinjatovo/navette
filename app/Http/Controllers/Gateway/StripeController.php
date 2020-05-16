<?php

namespace App\Http\Controllers\Gateway;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessOrder;
use App\Models\Order;
use App\Models\PaymentToken;
use Illuminate\Http\Request;

class StripeController extends Controller
{
    
    /**
     * Pay order per Stripe
     *
     * @param  Request  $request
     * @param  Order $order
     * @return Response
     */
    public function pay(Request $request)
    {
        $order = Order::findOrFail($request->input('order_id'));

        // Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey(env('STRIPE_KEY_SECRET'));

        $intent = \Stripe\PaymentIntent::create([
          'amount' => $order->total * 100,
          'currency' => $order->currency,
        ]);
        
        $order->status = Order::STATUS_ON_HOLD;
        $order->payment_type = Order::PAYMENT_TYPE_STRIPE;
        $order->save();
        
        PaymentToken::create([
           'payment_type' => Order::PAYMENT_TYPE_STRIPE,
           'amount' => $order->total * 100,
           'currency' => $order->currency,
           'order_id' => $order->getKey(),
           'token' => md5($intent->client_secret),
        ]);

        $output = [
            'publishable_key' => env('STRIPE_KEY_PUBLIC'),
            'client_secret' => $intent->client_secret,
        ];

        return response()->json($output);
    }
}
