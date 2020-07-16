<?php

namespace App\Http\Controllers\Api\v1\Gateway;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
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

        $intent = \Stripe\PaymentIntent::create([
          'amount' => $order->total * 100,
          'currency' => $order->currency,
        ]);
        
        $order->status = Order::STATUS_ON_HOLD;
        $order->payment_type = Order::PAYMENT_TYPE_STRIPE;
        $order->save();
        
        Payment::create([
           'payment_type' => Order::PAYMENT_TYPE_STRIPE,
           'amount' => $order->total * 100,
           'currency' => $order->currency,
           'order_id' => $order->getKey(),
           'payment_id' => $intent->id,
        ]);
		
        $output = [
            'publishable_key' => config('stripe.public'),
            'client_secret' => $intent->client_secret,
        ];

        return $this->success(200, trans('messages.payment.intent.created'), $output);
    }

    /**
     * Rate driver
     *
     * @param Request $request
     * 
     * @return Response
     */
    public function setupIntent(Request $request)
    {
        $user = $request->user();
        
        if(empty($user->stripe_id)){
            $customer = \Stripe\Customer::create([
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ]);
            if($customer){
                $user->stripe_id = $customer->id;
                $user->save();
            }
        }
        
        $setup_intent = \Stripe\SetupIntent::create([
            'customer' => $user->stripe_id
        ]);
        
        return $this->success(200, 'ok', [
            'publishable_key' => config('stripe.public'),
			'client_secret' => $setup_intent->client_secret
		]);
    }

    /**
     * Rate driver
     *
     * @param Request $request
     * 
     * @return Response
     */
    public function paymentMethods(Request $request)
    {
        $user = $request->user();
        if(empty($user->stripe_id)){
            $customer = \Stripe\Customer::create([
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ]);
            if($customer){
                $user->stripe_id = $customer->id;
                $user->save();
            }
        }
        
        $list = \Stripe\PaymentMethod::all([
            'customer' => $user->stripe_id,
            'type' => 'card',
        ]);
		
		$list = $list->toArray();
        $output = [
			'http_status' => 200,
			'status_code' => 0, 
			'message'=>'ok', 
			'errors' => [],
			'data' => isset($list['data']) ? $list['data'] : [],
		];
        return response()->json($output);
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
            $event = \Stripe\Webhook::constructEvent($payload, $_SERVER['HTTP_STRIPE_SIGNATURE'], config('stripe.webhook.secret'));
		} catch(\UnexpectedValueException $e) {
            return response()->json(['status' => 'error','details' => 'Invalid payload'])->setStatusCode(403);
		} catch(\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['status' => 'error','details' => 'Invalid signature'])->setStatusCode(403);
		} catch (\Exception $e) {
            return response()->json(['status' => 'error','details' => $e->getMessage()])->setStatusCode(403);
        }

        $details = null;
		
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
		$transaction = Payment::where('payment_type', Order::PAYMENT_TYPE_STRIPE)
				->where('payment_id', $intent->id)
				->first();
		if($transaction){
			if($order = $transaction->order){
				$currency = strtoupper($intent->currency);
				if(($order->payment_type == Order::PAYMENT_TYPE_STRIPE) 
				   && ($order->total * 100 == $intent->amount_received)
				   && ($order->currency = strtoupper($intent->currency))
				   && ($order->status == Order::STATUS_ON_HOLD)){
                    $transaction->status = Payment::STATUS_SUCCESS;
                    $transaction->save();
					 // Set as paid
					$order->status = Order::STATUS_OK;
					$order->paidPer(Order::PAYMENT_TYPE_STRIPE);
				}
			}
		}
	}
}
