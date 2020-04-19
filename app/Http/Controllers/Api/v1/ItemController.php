<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Item;
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
        
        return new RideItemResource($ride);
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
        
        return new RideItemResource($ride);
    }
}
