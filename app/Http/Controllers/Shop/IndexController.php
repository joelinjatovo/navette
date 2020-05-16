<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
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

        event(new OrderStatusChanged($order, 'created', null, Order::STATUS_PING));
      
        $request->session()->put('cart', $order);
        
        return redirect()->route('shop.cart')
            ->with('success', "Order created successfully");
    }
}
