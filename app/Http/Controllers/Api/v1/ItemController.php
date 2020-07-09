<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Item;
use App\Http\Resources\Item as ItemResource;
use App\Http\Resources\ItemCollection;
use App\Http\Resources\Ride as RideResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    /**
     * Paginate items
     *
     * @return Response
     */
    public function index(Request $request){
		$models = Item::join('orders', 'orders.id', '=', 'items.order_id')
            ->select('items.*')
			->where('orders.user_id', '=', $request->user()->getKey())
			->with('point')
			->with(['rides', 'rides.driver'])
			->with(['order', 'order.club', 'order.club.point', 'order.payments'])
			->orderBy('items.created_at', 'desc')
			->paginate();
        return new ItemCollection($models);
    }
    
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
		$item->load('point')
			->load(['rides', 'rides.driver'])
			->load(['order', 'order.club', 'order.club.point', 'order.payments']);
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
		
		$item->load('point')
			->load(['rides', 'rides.driver'])
			->load(['order', 'order.club', 'order.payments']);
		
        return new ItemResource($item);
    }
}
