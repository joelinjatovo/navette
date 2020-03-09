<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrder as StoreOrderRequest;
use App\Http\Resources\Order as OrderResource;
use App\Models\Order;
use App\Models\OrderPoint;
use App\Models\Phone;
use App\Models\Point;
use App\Models\Zone;
use App\Repositories\Repository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    
    private $repository;
    
    /**
     *
     * @param  Order  $order
     */
    public function __construct(Order $order){
        $this->repository = new Repository($order);
    }

    /**
     * Store a new order.
     *
     * @param  Request  $request
     * @param  Zone  $zone
     * @return Response
     */
    public function store(StoreOrderRequest $request, Zone $zone)
    {
        $order = new Order($request->only('place', 'privatized', 'preordered'));
        $order->calculate($zone);
        $zone->orders()->save($order);
        
        $phone = new Phone($request->input('phone'));
        $phone->phone = $phone->phone_country_code . $phone->phone_number;
        $phone->save();
        $order->phones()->save($phone);
        
        $points = $request->input('points');
        $keys = ['a', 'b'];
        foreach($keys as $key){
            if( isset( $points[$key] ) ) {
                $point = new Point($points[$key]);
                $point->save();
                $order->points()->attach($point->id, [
                    'type' => $key == 'a' ? OrderPoint::TYPE_START : OrderPoint::TYPE_END, 
                    'created_at' => now()
                ]);
            }
        }
        
        $keys = ['b', 'c'];
        if( isset( $points['c'] ) ) {
            $second = $order->replicate();
            $order->second()->save($second);
            
            foreach($keys as $key){
                if( isset( $points[$key] ) ) {
                    $point = new Point($points[$key]);
                    $point->save();
                    $second->points()->attach($point->id, [
                        'type' => $key == 'b' ? OrderPoint::TYPE_START : OrderPoint::TYPE_END, 
                        'created_at' => now()
                    ]);
                }
            }
        }

        //event(new \App\Events\OrderCreated($order));
        
        return new OrderResource($order);
    }
}
