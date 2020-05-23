<?php

namespace App\Http\Controllers\Shop;

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

class IndexController extends Controller
{
    /**
     * Show order form
     *
     * @return View
     */
    public function create()
    {
        return view('shop.index');
    }
    
    /**
     * Store order as cart
     *
     * @param Request $request
     *
     * @return View
     */
    public function store(Request $request)
    {
        $club = Club::findOrFail($request->input('order.club'));
        $car = Car::find($request->input('order.car'));
        
        if(!$club || null === $club->point ) {
            return back()->with('error', "Club Without Position");
        }
        
        $order = new Order($request->input('order'));
        $order->status = Order::STATUS_PING;
        $order->setVat(0);
        $order->club()->associate($club);
        if($car) $order->car()->associate($car);
        $order->save();
        
        $distance = 0;
        $items_count = 0;
        $values = $request->input('order.items');
        foreach($values as $value){
            if(isset($value['point']) && isset($value['item'])){
                if($value['point']['name'] == null) continue;
                if($value['point']['lat'] == null) continue;
                if($value['point']['lng'] == null) continue;

                $point = new Point($value['point']);
                $point->save();

                $item = new Item($value['item']);
                $item->point()->associate($point);
                $item->order()->associate($order);
                $item->save();

                $distance += (int) $item->distance_value;
                $items_count++;
            }
        }
        
        if($distance == 0){
            return back()->with('error', "Invalid Distance Between User Position And Club");
        }
        
        if($items_count==0){
            return back()->with('error', "Order empty");
        }
        
        $distance = (int) ( $distance / $items_count );
        $zone = Zone::findByDistance($distance);
        if(null == $zone){
            return back()->with('error', "No Zone Found");
        }
        
        $order->distance = $distance;
        $order->setZone($zone);
        $order->save();

        //event(new OrderStatusChanged($order, 'created', null, Order::STATUS_PING));
      
        $request->session()->put('cart', $order);
        
        return redirect()->route('shop.cart')
            ->with('success', "Order created successfully");
    }


    /**
     * Delete the specified user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function cars_ajax(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if(isset($data['_id'])){
                $cars = Car::where('club_id', $data['_id'])->get();
                return view('shop.cars', ['models' => $cars]);
            }
        }
    }

}
