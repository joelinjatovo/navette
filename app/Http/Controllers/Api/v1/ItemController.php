<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Item;
use App\Http\Resources\Item as ItemResource;
use App\Http\Resources\Ride as RideResource;
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
    public function show(Request $request, Item $item)
    {
        return new ItemResource($item);
    }
    
    /**
     * Cancel item
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function cancel(Request $request)
    {
        $item = Item::findOrFail($request->input('id'));
        
        if(!$item->isCancelable()){
            return $this->error(400, 3003, trans('messages.item.not.cancelable'));
        }
        
        $item->cancel();
		
        if($item->order){
			$item->order->cancel($request->user());
		}
        
		foreach($item->rideitems as $rideitem){
			if($rideitem->isCancelable()){
				$rideitem->cancel();
				if($rideitem->ride){
					$rideitem->ride->getNextRideItem();
				}
			}
		}
		
        return new ItemResource($item->load(['order']));
    }
}
