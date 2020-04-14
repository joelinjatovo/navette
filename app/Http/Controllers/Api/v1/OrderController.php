<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrder as StoreOrderRequest;
use App\Http\Resources\OrderItem as OrderItemResource;
use App\Http\Resources\OrderCollection;
use App\Jobs\ProcessOrder;
use App\Models\Car;
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
        
        $origin = $request->input('origin');
        if( $origin ) {
            $origin = new Point($origin);
            $origin->save();
        }
        
        $retours = $request->input('retours');
        if( $retours ) {
            $retours = new Point($retours);
            $retours->save();
        }
        
        $distance = 20; //$this->calculateDistance($origin, $club->point);
        if($distance == 0){
            return $this->error(400, 106, "Invalid Distance Between User Position And Club");
        }
        
        $zone = $zoneRrepository->getByDistance($distance);
        if(null == $zone){
            return $this->error(400, 107, "No Zone Found");
        }
        
        $car = $request->input('car');
        if( $car > 0 ) {
            $car = Car::find($car);
        }
        
        $order = new Order($request->only('place', 'privatized', 'preordered'));
        $order->status = Order::STATUS_PING;
        $order->vat = 0;
        $order->amount = $zone->price;
        $order->currency = $zone->currency;
        $order->subtotal = $order->place * $zone->price;
        $order->total = $order->subtotal + $order->subtotal * $order->vat;
        $order->club_id = $club->getKey();
        $order->zone_id = $zone->getKey();
        $order->car_id = ($car?$car->getKey():null);
        $order->save();
        
        $phone = $request->input('phone');
        if( $retours ) {
            $phone = new Phone($phone);
            $phone->save();
            $order->phones()->save($phone);
        }
        
        $order->points()->attach($origin->getKey(), ['type' => OrderPoint::TYPE_START, 'created_at' => now()]);
        $order->points()->attach($club->point->getKey(), ['type' => OrderPoint::TYPE_END, 'created_at' => now()]);

        if($retours){
            $second = $order->replicate();
            $order->second()->save($second);
            
            $second->points()->attach($club->point->getKey(), ['type' => OrderPoint::TYPE_START, 'created_at' => now()]);
            $second->points()->attach($retours->getKey(), ['type' => OrderPoint::TYPE_END, 'created_at' => now()]);
        }

        event(new OrderCreated($order));
        
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
        $order = Order::findOrFail($request->input('order'));

        if(!$order->cancelable()){
            return $this->error(400, 111, "Order not cancelable");
        }
        
        $order->cancel($request->user());
        
        return new OrderItemResource($order);
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
            echo json_encode($response); exit;
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
