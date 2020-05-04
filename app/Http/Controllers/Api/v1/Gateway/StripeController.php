<?php

namespace App\Http\Controllers\Api\v1\Gateway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\ProcessOrder;
use App\Models\Order;
use App\Models\PaymentToken;

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

        return $this->success(200, "Payment intent created with success", $output);
    }
    
    /**
     * Handle stripe webhook
     *
     * @param  Request  $request
     * @return Response
     */
    public function webhook(Request $request){
        $event = null;

        try {
            // Make sure the event is coming from Stripe by checking the signature header
            $event = \Stripe\Webhook::constructEvent($input, $_SERVER['HTTP_STRIPE_SIGNATURE'], env('STRIPE_WEBHOOK_SECRET'));
        }catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'details' => $e->getMessage()
            ])->statusCode(403);
        }

        $details = null;

        if ($event->type == 'payment_intent.succeeded') {
            // Fulfill any orders, e-mail receipts, etc
            // To cancel the payment you will need to issue a Refund (https://stripe.com/docs/api/refunds)
            $details = '💰 Payment received!';
        }else if ($event->type == 'payment_intent.payment_failed') {
            $details = '❌ Payment failed.';
        }

        $output = [
            'status' => 'success',
            'details' => $details
        ];

        return response()->json($output);
    }
}
