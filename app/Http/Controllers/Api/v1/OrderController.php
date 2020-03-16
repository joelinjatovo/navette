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
        return new OrderCollection($request->user()->orders()->paginate());
    }

    /**
     * Store a new order.
     *
     * @param  Request  $request
     * @param  Zone  $zone
     * @return Response
     */
    public function store(StoreOrderRequest $request, ZoneRepository $zoneRrepository, Club $club)
    {
        if( null === $club->point ) {
            return $this->error(400, 105, "Club Without Position");
        }
        
        $points = $request->input('points');
        
        $point_a = null;
        if( isset( $points['a'] ) ) {
            $point_a = new Point($points['a']);
            $point_a->save();
        }
        
        $point_b = null;
        if( isset( $points['b'] ) ) {
            $point_b = new Point($points['b']);
            $point_b->save();
        }
        
        $distance = $this->calculateDistance($point_a, $club->point);
        if($distance == 0){
            return $this->error(400, 106, "Invalid Distance Between User Position And Club");
        }
        
        $zone = $zoneRrepository->getByDistance($distance);
        if(null == $zone){
            return $this->error(400, 107, "No Zone Found");
        }
        
        $order = new Order($request->only('place', 'privatized', 'preordered'));
        $order->vat = 0;
        $order->amount = $zone->price;
        $order->currency = $zone->currency;
        $order->subtotal = $order->place * $zone->price;
        $order->total = $order->subtotal + $order->subtotal * $order->vat;
        $order->club_id = $club->getKey();
        $order->zone_id = $zone->getKey();
        $order->save();
        
        
        $phone = new Phone($request->input('phone'));
        $phone->save();
        $order->phones()->save($phone);
        
        $order->points()->attach($point_a->getKey(), ['type' => OrderPoint::TYPE_START, 'created_at' => now()]);
        $order->points()->attach($club->point->getKey(), ['type' => OrderPoint::TYPE_END, 'created_at' => now()]);

        if($point_b){
            $second = $order->replicate();
            $order->second()->save($second);
            
            $second->points()->attach($club->point->getKey(), ['type' => OrderPoint::TYPE_START, 'created_at' => now()]);
            $second->points()->attach($point_b->getKey(), ['type' => OrderPoint::TYPE_END, 'created_at' => now()]);
        }

        event(new \App\Events\OrderCreated($order));
        
        //\App\Jobs\ProcessOrder::dispatchAfterResponse($order);
        
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
