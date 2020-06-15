<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrder as StoreOrderRequest;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\OrderCollection;
use App\Models\Car;
use App\Models\Club;
use App\Models\Order;
use App\Models\Item;
use App\Models\PaymentToken;
use App\Models\Phone;
use App\Models\Point;
use App\Models\Zone;
use App\Services\GoogleApiService;
use App\Repositories\OrderRepository;
use App\Repositories\ZoneRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $google;

    /**
     * Paginate orders
     *
     * @return Response
     */
    public function __construct(GoogleApiService $google){
        $this->google = $google;
    }

    /**
     * Paginate orders
     *
     * @return Response
     */
    public function index(Request $request){
		$models = $request->user()->orders()
			->with(['club', 'club.point'])
			->with(['items', 'items.point', 'items.rides'])
			->orderBy('created_at', 'desc')
			->paginate();
        return new OrderCollection($models);
    }

    /**
     * Show order
     *
     * @return Response
     */
    public function show(Request $request, Order $order){
        return new OrderResource($order);
    }

    /**
     * Get cart info
     *
     * @param  Request $request
     * @return Response
     */
    public function cart(Request $request)
    {
        $club = Club::findOrFail($request->input('club_id'));
        if( null === $club->point ) {
            return $this->error(400, 2000, trans('messages.club.no.point'));
        }
        
        $order = new Order($request->all());
        $order->status = Order::STATUS_PING;
        $order->setVat(0);
        
		$item_count = 0;
        $distance = 0;
        $values = $request->input('items');
        foreach($values as $value){
			$item = new Item($value);
			$distance += (int) $item->distance_value;
			$item_count++;
        }
        
        if($distance == 0){
            return $this->error(400, 2001, trans('messages.no.route.found'));
        }
        
        $distance = ($item_count > 0 ? (int) ( $distance / $item_count ) : $distance );
        $zone = Zone::findByDistance($distance);
        if(null == $zone){
            return $this->error(400, 2002, trans('messages.no.zone.found'));
        }
        $order->distance = $distance;
        $order->setZone($zone);

        return new OrderResource($order);
    }

    /**
     * Store a new order.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
		$user = $request->user();
		
        $club = Club::findOrFail($request->input('club_id'));
        
        if( null === $club->point ) {
            return $this->error(400, 2000, trans('messages.club.no.point'));
        }
        
        $order = new Order($request->all());
        $order->status = Order::STATUS_PING;
        $order->setVat(0);
        $order->club()->associate($club);
        $order->save();
        
        $distance = 0;
        $values = $request->input('items');
        foreach($values as $value){
            if(isset($value['point'])){
                $point = new Point($value['point']);
                $point->save();

                $item = new Item($value);
                $item->point()->associate($point);
                $item->order()->associate($order);
                $item->save();

                $distance += (int) $item->distance_value;
            }
        }
        
        if($distance == 0){
            return $this->error(400, 2001, trans('messages.no.route.found'));
        }
        
        $distance = (int) ( $distance / 2 );
        $zone = Zone::findByDistance($distance);
        if(null == $zone){
            return $this->error(400, 2002, trans('messages.no.zone.found'));
        }
        $order->distance = $distance;
        $order->setZone($zone);
        $order->save();
		
		switch($request->input('payment_type')){
			case Order::PAYMENT_TYPE_STRIPE:
				// Set your secret key. Remember to switch to your live secret key in production!
				// See your keys here: https://dashboard.stripe.com/account/apikeys
				\Stripe\Stripe::setApiKey('sk_test_4eC39HqLyjWDarjtT1zdp7dc');
                
                if($request->input('payment_method_id')){
                    $payment_method_id = $request->input('payment_method_id');
                }else{
                    $payment_method_id = $user->payment_method_id;
                }

                try {
                    $intent = \Stripe\PaymentIntent::create([
                        'amount' => $order->total * 100,
                        'currency' => $order->currency,
                        'customer' => $user->stripe_id,
                        'payment_method' => $user->payment_method_id,
                        'off_session' => true,
                        'confirm' => true,
                    ]);
        
                    $intent_id = $intent->id;
				    $order->payment_status = Order::PAYMENT_STATUS_PING;
                    
                } catch (\Stripe\Exception\CardException $e) {
                    // Error code will be authentication_required if authentication is needed
                    //echo 'Error code is:' . $e->getError()->code;
                    $intent_id = $e->getError()->payment_intent->id;
                    //$intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
				    $order->payment_status = Order::PAYMENT_STATUS_AUTH_REQUIRED;
                }
        
                PaymentToken::create([
                    'payment_type' => Order::PAYMENT_TYPE_STRIPE,
                    'amount' => $order->total * 100,
                    'currency' => $order->currency,
                    'order_id' => $order->getKey(),
                    'token' => $intent_id,
                ]);

				$order->status = Order::STATUS_ON_HOLD;
				$order->payment_type = Order::PAYMENT_TYPE_STRIPE;
				$order->save();
			break;
			default:
			case Order::PAYMENT_TYPE_CASH:
				$order->status = Order::STATUS_OK;
                $order->payment_status = Order::PAYMENT_STATUS_PING;
				$order->payment_type = Order::PAYMENT_TYPE_CASH;
				$order->save();
			break;
		}

        return new OrderResource($order->load(['items', 'items.point']));
    }
    
    /**
     * Cancel order
     *
     * @param  Request  $request
     * @param  Order $order
     * @return Response
     */
    public function cancel(Request $request)
    {
        $order = Order::findOrFail($request->input('id'));

        if(!$order->isCancelable()){
            return $this->error(400, 2003, trans('messages.order.not.cancelable'));
        }
        
        $order->cancel($request->user());
		
		foreach($order->items as $item){
			if($item->isCancelable()){
				$item->cancel();
				foreach($item->rideitems as $rideitem){
					if($rideitem->isCancelable()){
						$rideitem->cancel();
						if($rideitem->ride){
							$rideitem->ride->getNextRideItem();
						}
					}
				}
			}
		}
        
        return new OrderResource($order->load(['items', 'items.point']));
    }
}
