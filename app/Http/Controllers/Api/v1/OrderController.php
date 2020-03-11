<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrder as StoreOrderRequest;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\OrderCollection;
use App\Models\Order;
use App\Models\OrderPoint;
use App\Models\Phone;
use App\Models\Point;
use App\Models\Club;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    
    private $repository;
    
    /**
     *
     * @param  Order  $order
     */
    public function __construct(OrderRepository $repository){
        $this->repository = $repository;
    }

    /**
     * Paginate orders
     *
     * @return Response
     */
    public function index(Request $request){
        return new OrderCollection($request->user()->orders()->paginate());
    }

    /**
     * Store a new order.
     *
     * @param  Request  $request
     * @param  Zone  $zone
     * @return Response
     */
    public function store(StoreOrderRequest $request, Club $club)
    {
        $points = $request->input('points');
        $point_a = null;
        $point_b = null;
        if( isset( $points['a'] ) ) {
            $point_a = new Point($points['a']);
            $point_a->save();
        }
        if( isset( $points['b'] ) ) {
            $point_b = new Point($points['b']);
            $point_b->save();
        }
        
        $phone = new Phone($request->input('phone'));
        $phone->save();
        
        $order = new Order($request->only('place', 'privatized', 'preordered'));
        $zone = $this->repository->calculate($order, $club, $point_a, $point_b);
        
        $zone->orders()->save($order);
        $order->phones()->save($phone);
        $order->points()->attach($point_a->id, ['type' => OrderPoint::TYPE_START, 'created_at' => now()]);
        $order->points()->attach($club->point->id, ['type' => OrderPoint::TYPE_END, 'created_at' => now()]);
        
        if($point_b){
            $second->replicate();
            $order->second()->save($second);
            
            $second->points()->attach($club->point->id, ['type' => OrderPoint::TYPE_START, 'created_at' => now()]);
            $second->points()->attach($point_b->id, ['type' => OrderPoint::TYPE_END, 'created_at' => now()]);
        }

        event(new \App\Events\OrderCreated($order));
        
        \App\Jobs\ProcessOrder::dispatchAfterResponse($order);
        
        return new OrderResource($order);
    }
}
