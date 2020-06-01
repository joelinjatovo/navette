<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Item;
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
    public function show(Request $request, Item $item)
    {
        return new ItemItemResource($item);
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
            return $this->error(400, 119, trans('messages.item.not.cancelable'));
        }
        
        $item->cancel();
		
        if($item->order){
			$item->order->cancel($request->user());
		}
        
        if($item->ride){
			$point = $item->ride->points()->wherePivot('item_id', $item->getKey())->first();
			if($point && $point->pivot){
				$point->pivot->cancel();// Cancel ride at the item's point
			}
			$item->ride->getNextPoint(); // Select next point or update status
        }
        
        return new ItemItemResource($item);
    }
}
