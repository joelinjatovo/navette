<?php

namespace App\Http\Controllers\Customer;

use App\Models\Item;
use App\Models\Order;
use App\Http\Resources\ItemItem as ItemItemResource;
use App\Http\Resources\RideItem as RideItemResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    
    /**
     * Active a ride point.
     *
     * @param  Request  $request
     * @param  Ride  $ride
     *
     * @return Response
     */
    public function show(Request $request, Order $order, Item $item)
    {
        if($request->ajax()){
            return new ItemItemResource($item);
        }
        
        return view('item.show', ['model' => $item, 'order' => $order]);
    }
    
    /**
     * Active a ride point.
     *
     * @param  Request  $request
     * @param  Ride  $ride
     *
     * @return Response
     */
    public function finish(Request $request)
    {
        $item = Item::findOrFail($request->input('item_id'));
        
        if(!$item->finishable()){
            return $this->error(400, 118, "Item not finishable");
        }
        
        $item->finish();
        
        $ride = $item->ride;
        if($ride){
            // Select next item
            $ride->next();
        }
        
        return new ItemItemResource($item);
    }
    
    /**
     * Cancel item
     *
     * @param  Request  $request
     * @param  Ride  $ride
     *
     * @return Response
     */
    public function cancel(Request $request)
    {
        $item = Item::findOrFail($request->input('item_id'));
        
        if(!$item->cancelable()){
            return $this->error(400, 119, "Item not cancelable");
        }
        
        $item->cancel();
        
        $ride = $item->ride;
        if($ride){
            // Select next item
            $ride->next();
        }
        
        return new ItemItemResource($item);
    }
}
