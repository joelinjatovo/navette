<?php

namespace App\Http\Controllers\Api\v1\Gateway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\PaymentToken;
use App\Events\OrderStatusChanged;

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
        $order = Order::findOrFail($request->input('id'));

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
           'token' => $intent->id,
        ]);
		
		info($intent->id);
		
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

		$payload = @file_get_contents('php://input');
        try {
            // Make sure the event is coming from Stripe by checking the signature header
            $event = \Stripe\Webhook::constructEvent($payload, $_SERVER['HTTP_STRIPE_SIGNATURE'], env('STRIPE_WEBHOOK_SECRET'));
		} catch(\UnexpectedValueException $e) {
            return response()->json(['status' => 'error','details' => 'Invalid payload'])->setStatusCode(403);
		} catch(\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['status' => 'error','details' => 'Invalid signature'])->setStatusCode(403);
		} catch (\Exception $e) {
            return response()->json(['status' => 'error','details' => $e->getMessage()])->setStatusCode(403);
        }

        $details = null;

		info($event->type);
		info($event->data->object);
		
        if ($event->type == 'payment_intent.succeeded') {
            $details = '💰 Payment received!';
			$paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
			$this->handlePaymentIntentSucceeded($paymentIntent);
        }else if ($event->type == 'payment_intent.payment_failed') {
            $details = '❌ Payment failed.';
			$paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
			$this->handlePaymentIntentFailed($paymentIntent);
        }

        $output = [
            'status' => 'success',
            'details' => $details
        ];

        return response()->json($output);
    }
	
	// Then define and call a method to handle the successful payment intent.
	protected function handlePaymentIntentSucceeded($intent){
		$transaction = PaymentToken::where('payment_type', Order::PAYMENT_TYPE_STRIPE)
				->where('token', $intent->id)
				->first();
		if($transaction){
			if($order = $transaction->order){
				$currency = strtoupper($intent->currency);
				if(($order->payment_type == Order::PAYMENT_TYPE_STRIPE) 
				   && ($order->total * 100 = $intent->amount_received)
				   && ($order->currency = strtoupper($intent->currency))
				   && ($order->status == Order::STATUS_ON_HOLD)){
					 // Set as paid
					$order->status = Order::STATUS_OK;
					$order->paidPer(Order::PAYMENT_TYPE_STRIPE);
				}
			}
		}
	}
}
	
	protected function handlePaymentIntentFailed($intent){
		$transaction = PaymentToken::where('payment_type', Order::PAYMENT_TYPE_STRIPE)
				->where('token', $intent->id)
				->first();
		if($transaction){
			if($order = $transaction->order){
				$currency = strtoupper($intent->currency);
				if(($order->payment_type == Order::PAYMENT_TYPE_STRIPE) 
				   && ($order->total * 100 = $intent->amount_received)
				   && ($order->currency = strtoupper($intent->currency))
				   && ($order->status == Order::STATUS_ON_HOLD)){
					 // Set as failed
					$order->payment_status = Order::PAYMENT_STATUS_FAILED;
					$order->save();
				}
			}
		}
	}
}
