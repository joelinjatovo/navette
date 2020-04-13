<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class StripeController extends Controller
{
    
    /**
     * Create stripe payment intent
     *
     * @param  Request  $request
     * @param  Order $order
     * @return Response
     */
    public function paymentIntent(Request $request)
    {
        $order = Order::findOrFail($request->input('order'));

        // Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey(env('STRIPE_KEY_SECRET'));

        $intent = \Stripe\PaymentIntent::create([
          'amount' => $order->total * 100,
          'currency' => $order->currency,
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
    public function webhook(Request $request)
    {
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
