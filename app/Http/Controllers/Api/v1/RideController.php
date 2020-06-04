<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\ItemStatusChanged;
use App\Events\RideStatusChanged;
use App\Http\Controllers\Controller;
use App\Http\Resources\RideCollection;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\ItemCollection;
use App\Http\Resources\RideItemCollection;
use App\Http\Resources\Item as ItemResource;
use App\Http\Resources\Ride as RideResource;
use App\Models\Ride;
use App\Models\RideItem;
use App\Models\Item;
use App\Services\GoogleApiService;
use Illuminate\Http\Request;

class RideController extends Controller
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
     * Paginate rides
     *
     * @return Response
     */
    public function index(Request $request){
		$models = $request->user()->ridesDrived()
						->with(['items', 'items.point'])
						->with(['items.order', 'items.order.user', 'items.order.club', 'items.order.club.point'])
						->orderBy('rides.created_at', 'desc')
						->paginate();
        return new RideCollection($models);
    }
    
    /**
     * Start a new ride.
     *
     * @param  Request  $request
     * @param  Ride  $ride
     *
     * @return Response
     */
    public function show(Request $request, Ride $ride)
    {
		$ride->load(['items', 'items.point'])
			->load(['items.order', 'items.order.user', 'items.order.club', 'items.order.club.point']);
        return new RideResource($ride);
    }
    
    /**
     * Get items of the ride
     *
     * @param  Request $request
     * @param  Ride  $ride
     *
     * @return Response
     */
    public function items(Request $request, Ride $ride)
    {
        return new ItemCollection($ride->items()->paginate());
    }
    
    /**
     * Get points of the ride
     *
     * @param  Request  $request
     * @param  Ride  $ride
     *
     * @return Response
     */
    public function rideitems(Request $request, Ride $ride)
    {
        return new RideItemCollection($ride->rideitems()->paginate());
    }
    
    /**
     * Add item to the ride
     *
     * @param  Request  $request
     * @param  Ride  $ride
     *
     * @return Response
     */
    public function attachItem(Request $request, Ride $ride)
    {
        $item = Item::findOrFail($request->input('id'));
		
		/*
		$ride->attachRidePoint($item);
		$item->associateRide($ride);
		$item->active();
		if($item->order){
			$item->order->active();
		}
		*/
		
        return new ItemResource($item);
    }
    
    /**
     * Start driving ride
     *
     * @param  Request  $request
     * @param  Ride  $ride
     *
     * @return Response
     */
    public function start(Request $request)
    {
        $ride = Ride::findOrFail($request->input('id'));
        
        if(!$ride->isStartable()){
            return $this->error(400, 4004, trans('messages.ride.not.startable'));
        }
        
        $ride->start();
		
        return $this->direction($request);
    }
    
    /**
     * Cancel a ride.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function cancel(Request $request)
    {
        $ride = Ride::findOrFail($request->input('id'));
        
        if(!$ride->isCancelable()){
            return $this->error(400, 4003, trans('messages.ride.not.cancelable'));
        }
        
        $ride->cancel();
        
		foreach($ride->rideitems as $rideitem){
			if($rideitem->isCancelable()){
				$rideitem->cancel();
				if($rideitem->ride){
					$rideitem->ride->getNextRideItem();
				}
				
				if($rideitem->item){
        			if($item->isCancelable()){
						$rideitem->item->cancel();
						if($rideitem->item->order){
							$rideitem->item->order->cancel($request->user());
						}
					}
				}
			}
		}
		
		$ride->load(['items', 'items.point'])
			->load(['items.order', 'items.order.user', 'items.order.club', 'items.order.club.point']);
		
        return new RideResource($ride);
    }
    
    /**
     * Complete a ride.
     *
     * @param  Request  $request
     * @param  Ride  $ride
     *
     * @return Response
     */
    public function complete(Request $request)
    {
        $ride = Ride::findOrFail($request->input('id'));
        
        $ride->complete();
		
		$rideitems = $ride->rideitems()
			->with('item')
			->with('item.order')
			->where('status', RideItem::STATUS_STARTED)
			->get();
		
        foreach($rideitems as $rideitem){
			$rideitem->complete();
			if($ride->item){
				$ride->item->complete();
				if($ride->item->order){
					$ride->item->order->updateStatus(); // Check order status
				}
			}
		}
        
		$ride->load(['items', 'items.point'])
			->load(['items.order', 'items.order.user', 'items.order.club', 'items.order.club.point']);
		
        return new RideResource($ride);
    }
    
    /**
     * Verify a ride direction.
     *
     * @param  Request  $request
     * @param  Ride  $ride
     *
     * @return Response
     */
    public function direction(Request $request)
    {
        $ride = Ride::findOrFail($request->input('id'));
        
        $rideitems = $ride->rideitems()->where('status', RideItem::STATUS_ACTIVE)->get();
        if(empty($rideitems)){
            return $this->error(400, 4005, trans('messages.no.items.found'));
        }
        
        if(!$ride->verifyDirection($this->google)){
            return $this->error(400, 4006, trans('messages.no.route.found'));
        }
        
		$ride->getNextRideItem();
        
		$ride->load(['items', 'items.point'])
			->load(['items.order', 'items.order.user', 'items.order.club', 'items.order.club.point']);
		
        return new RideResource($ride);
    }
}
