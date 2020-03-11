<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrder as StoreOrderRequest;
use App\Http\Resources\Order as OrderResource;
use App\Http\Resources\OrderCollection;
use App\Models\Club;
use App\Models\Order;
use App\Models\OrderPoint;
use App\Models\Phone;
use App\Models\Point;
use App\Models\Zone;
use App\Services\GoogleApiService;
use App\Repositories\OrderRepository;
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
        return new OrderCollection($request->user()->orders()->paginate());
    }

    /**
     * Store a new order.
     *
     * @param  Request  $request
     * @param  Zone  $zone
     * @return Response
     */
    public function store(StoreOrderRequest $request, OrderRepository $repository, Club $club)
    {
        if( null === $club->point ) {
            abort(400, "Invalid Club");
        }
        
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
        
        $distance = $this->calculateDistance($point_a, $club->point);
        if($distance == 0){
            abort(400, "Distance null");
        }
        
        $zone = $this->getZone($distance);
        if(null == $zone){
            abort(400, "Very far.");
        }
        
        $order = new Order($request->only('place', 'privatized', 'preordered'));
        $order = $repository->calculate($order, $zone);
        
        $zone->orders()->save($order);
        
        $order->phones()->save($phone);
        $order->points()->attach($point_a->id, ['type' => OrderPoint::TYPE_START, 'created_at' => now()]);
        $order->points()->attach($club->point->id, ['type' => OrderPoint::TYPE_END, 'created_at' => now()]);

        
        if($point_b){
            $second = $order->replicate();
            $order->second()->save($second);
            
            $second->points()->attach($club->point->id, ['type' => OrderPoint::TYPE_START, 'created_at' => now()]);
            $second->points()->attach($point_b->id, ['type' => OrderPoint::TYPE_END, 'created_at' => now()]);
        }

        event(new \App\Events\OrderCreated($order));
        
        \App\Jobs\ProcessOrder::dispatchAfterResponse($order);
        
        return new OrderResource($order);
    }
    
    /**
     * calculateDistance
     *
     * @params Point $a
     * @params Point $b
     */
    protected function calculateDistance(Point $a, Point $b)
    {
        $response = $this->google->getDistance($a, $b);
        if($response['status'] === 'OK'){
            return ceil( $response['rows'][0]['elements'][0]['distance']['value'] / 1000 );
        }
        
        return 0;
    }
    
    /**
     * Find zone
     *
     * @params Order $order
     * @params Club $club
     */
    protected function getZone($distance)
    {
        return Zone::where('distance', '>=', $distance)->orderBy('distance', 'ASC')->first();
    }
}
