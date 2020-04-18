<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\OrderStatusChanged;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrder as StoreOrderRequest;
use App\Http\Resources\OrderItem as OrderItemResource;
use App\Http\Resources\OrderCollection;
use App\Jobs\ProcessOrder;
use App\Models\Car;
use App\Models\Club;
use App\Models\Order;
use App\Models\Item;
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
        return new OrderCollection($request->user()->orders()->orderBy('created_at', 'desc')->paginate());
    }

    /**
     * Get cart info
     *
     * @param  Request $request
     * @return Response
     */
    public function cart(Request $request)
    {
        $club = Club::findOrFail($request->input('order.club_id'));
        $car = Car::find($request->input('order.car_id'));
        
        if( null === $club->point ) {
            return $this->error(400, 105, "Club Without Position");
        }
        
        $order = new Order($request->input('order'));
        $order->status = Order::STATUS_PING;
        $order->setVat(0);
        
        $distance = 0;
        $values = $request->input('items');
        foreach($values as $value){
            if(isset($value['item']) && $value['item']){
                $item = new Item($value['item']);
                $distance += (int) $item->distance_value;
            }
        }
        
        if($distance == 0){
            return $this->error(400, 106, "Invalid Distance Between User Position And Club");
        }
        
        $distance = (int) ( $distance / 2 );
        $zone = Zone::findByDistance($distance);
        if(null == $zone){
            return $this->error(400, 107, "No Zone Found");
        }
        $order->distance = $distance;
        $order->setZone($zone);

        return new OrderItemResource($order);
    }

    /**
     * Store a new order.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $club = Club::findOrFail($request->input('order.club_id'));
        $car = Car::find($request->input('order.car_id'));
        
        if( null === $club->point ) {
            return $this->error(400, 105, "Club Without Position");
        }
        
        $order = new Order($request->input('order'));
        $order->status = Order::STATUS_PING;
        $order->setVat(0);
        $order->club()->associate($club);
        if($car) $order->car()->associate($car);
        $order->save();
        
        $distance = 0;
        $values = $request->input('items');
        foreach($values as $value){
            if(isset($value['point']) && isset($value['item'])){
                $point = new Point($value['point']);
                $point->save();

                $item = new Item($value['item']);
                $item->point()->associate($point);
                $item->order()->associate($order);
                $item->save();

                $distance += (int) $item->distance_value;
            }
        }
        
        if($distance == 0){
            return $this->error(400, 106, "Invalid Distance Between User Position And Club");
        }
        
        $distance = (int) ( $distance / 2 );
        $zone = Zone::findByDistance($distance);
        if(null == $zone){
            return $this->error(400, 107, "No Zone Found");
        }
        $order->distance = $distance;
        $order->setZone($zone);
        $order->save();

        event(new OrderStatusChanged($order, 'created', null, Order::STATUS_PING));
        
        ProcessOrder::dispatchAfterResponse($order);

        return new OrderItemResource($order);
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
        $order = Order::findOrFail($request->input('order_id'));

        if(!$order->cancelable()){
            return $this->error(400, 111, "Order not cancelable");
        }
        
        $order->cancel($request->user());
        
        return new OrderItemResource($order);
    }
}
