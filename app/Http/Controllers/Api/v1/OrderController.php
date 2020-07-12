<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrder as StoreOrderRequest;
use App\Http\Resources\Cart as CartResource;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\OrderCollection;
use App\Models\Car;
use App\Models\Club;
use App\Models\Order;
use App\Models\Item;
use App\Models\Payment;
use App\Models\Phone;
use App\Models\Point;
use App\Models\Ride;
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
			->with(['payments'])
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
        $order->load(['club', 'club.point'])
			->load(['payments'])
            ->load(['items', 'items.point', 'items.rides']);
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
        $items = [];
        foreach($values as $value){
			$point = null;
            if(isset($value['point'])){
				$point = new Point($value['point']);
			}
				
			if(isset($value['type']) && ($value['type'] == Item::TYPE_BACK)){
				$direction = $this->getDirection($point, $club->point);
			}else{
				$direction = $this->getDirection($club->point, $point);
			}
				
			info($direction);
			
			$value['duration'] = $direction['duration'];
			$value['duration_value'] = $direction['duration_value'];
			$value['distance'] = $direction['distance'];
			$value['distance_value'] = $direction['distance_value'];
			$value['direction'] = $direction['direction'];
			
			$item = new Item($value);
			$items[] = $item;
			
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

        return new CartResource($order, $items);
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
        $items = [];
        $values = $request->input('items');
        foreach($values as $value){
            if(isset($value['point'])){
                $point = new Point($value['point']);
                $point->save();
				
				if(isset($value['type']) && ($value['type'] == Item::TYPE_BACK)){
					$direction = $this->getDirection($point, $club->point);
				}else{
					$direction = $this->getDirection($club->point, $point);
				}
				
				info($direction);
			
				$value['duration'] = $direction['duration'];
				$value['duration_value'] = $direction['duration_value'];
				$value['distance'] = $direction['distance'];
				$value['distance_value'] = $direction['distance_value'];
				$value['direction'] = $direction['direction'];

                $item = new Item($value);
                $item->point()->associate($point);
                $item->order()->associate($order);
                $item->save();
                $items[] = $item;

                $distance += (int) $item->distance_value;
                
                if(isset($value['ride_id'])){
                    $item->ride_id = $value['ride_id'];
                    $items[] = $item;
                }
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
                    $status = Payment::STATUS_PING;
                    
                } catch (\Stripe\Exception\CardException $e) {
                    // Error code will be authentication_required if authentication is needed
                    //echo 'Error code is:' . $e->getError()->code;
                    $intent_id = $e->getError()->payment_intent->id;
                    $intent = \Stripe\PaymentIntent::retrieve($payment_intent_id);
				    $order->payment_status = Order::PAYMENT_STATUS_AUTH_REQUIRED;
                    $status = Payment::STATUS_AUTH_REQUIRED;
                }
        
                Payment::create([
                    'status' => $status,
                    'payment_type' => Order::PAYMENT_TYPE_STRIPE,
                    'amount' => $order->total * 100,
                    'currency' => $order->currency,
                    'order_id' => $order->getKey(),
                    'payment_id' => $intent_id,
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
                foreach($items as $item){
                    $item->ok();
                }
			break;
		}
        
        foreach($items as $item){
            if($item->ride_id){
                $ride = Ride::find($item->ride_id);
                if($ride && $ride->hasAvailablePlace($order->place)){
                    $ride->attachItem($item, $order->place);
                    $ride->addPlace($order->place);
                    $item->active();
                    $order->active();
                }
            }
        }
		
        return new OrderResource($order->load(['items', 'items.point']));
    }

    /**
     * Update n order.
     *
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, Order $order)
    {
		$place = $request->input('place');
		if($place > 0 && ($place < $order->place)){
			$order->place = $place;
			$order->save();
			
			foreach($order->items as $item){
				foreach($item->rides as $ride){
					// TODO Handle multicar
					if($ride->pivot){
						$ride->pivot->place = $place;
						$ride->pivot->save();
					}
				}
			}
			
			// TODO Refund
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
	
	private function getDirection(Point $a, Point $b){
		$output = [
			'duration' => null,
			'duration_value' => 0,
			'distance' => null,
			'distance_value' => 0,
			'direction' => null,
		];
		
		if(!$a) return $output;
		if(!$b) return $output;
		
		$google = $this->google;
        $origin = sprintf("%s,%s", $a->lat, $a->lng);
        $destination = sprintf("%s,%s", $b->lat, $b->lng);
		$direction = $google->getDirection($origin, $destination);
        if($direction && isset($direction['status']) && $direction['status'] == "OK"){
            if(isset($direction['routes'])){
                $routes = $direction['routes'];
                if(is_array($routes) && !empty($routes)){
					$route = $routes[0];
					$output['direction'] = $route['overview_polyline']['points'];
                    if(isset($route['legs'])){
                        $legs = $route['legs'];
						if(is_array($legs) && !empty($legs)){
							$leg = $legs[0];
							$output['duration'] = $leg['duration']['text'];
							$output['duration_value'] = $leg['duration']['value'];
							$output['distance'] = $leg['distance']['text'];
							$output['distance_value'] = $leg['distance']['value'];
							return $output;
						}
					}
				}
			}
		}
		
		return $output;
	}
}
