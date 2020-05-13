<?php

namespace App\Http\Controllers\Customer;

use App\Events\OrderStatusChanged;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrder as StoreOrderRequest;
use App\Http\Resources\OrderItem as OrderItemResource;
use App\Http\Resources\OrderCollection;
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
    
    /**
     * Show the list of all order
     *
     * @return Response
     */
    public function index()
    {
        $orders = Order::paginate();
        
        return view('customer.order.index', ['models' => $orders]);
    }

    /**
     * Show the order info.
     *
     * @param Order $order
     * @return Response
     */
    public function show(Order $order)
    {
        return view('customer.order.show', ['model' => $order]);
    }
    
    /**
     * Show the form to create a new order.
     *
     * @return Response
     */
    public function create()
    {
        $model = new Order();
        return view('customer.order.create', ['model' => $model]);
    }

    /**
     * Store a new order.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $club = Club::findOrFail($request->input('order.club'));
        $car = Car::find($request->input('order.car'));
        
        if( null === $club->point ) {
            return back()->with('error', "Club Without Position");
        }
        
        $order = new Order($request->input('order'));
        $order->status = Order::STATUS_PING;
        $order->setVat(0);
        $order->club()->associate($club);
        if($car) $order->car()->associate($car);
        $order->save();
        
        $distance = 0;
        $values = $request->input('order.items');
        foreach($values as $value){
            if(isset($value['point']) && isset($value['item'])){
                if($value['point']['lat'] == null) continue;
                if($value['point']['lng'] == null) continue;

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
            return back()->with('error', "Invalid Distance Between User Position And Club");
        }
        
        $distance = (int) ( $distance / 2 );
        $zone = Zone::findByDistance($distance);
        if(null == $zone){
            return back()->with('error', "No Zone Found");
        }
        $order->distance = $distance;
        $order->setZone($zone);
        $order->save();

        event(new OrderStatusChanged($order, 'created', null, Order::STATUS_PING));
      
        return back()->with('success', "Order created successfully");
    }
    
    /**
     * Show the form to edit specified order.
     *
     * @param Order $order
     * @return Response
     */
    public function edit(Order $order)
    {
        return view('customer.order.edit', ['model' => $order]);
    }

    /**
     * Update the specified order.
     *
     * @param Request  $request
     * @param Order $order
     * @return Response
     */
    public function update(Request $request, Order $order)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
    }

    /**
     * Delete the specified order.
     *
     * @param Request  $request
     * @param Order $order
     * @return Response
     */
    public function delete(Order $order)
    {
        $order->delete();

        return response()->json([
            'code' => 200,
            'status' => "success",
        ]);
    }
}
