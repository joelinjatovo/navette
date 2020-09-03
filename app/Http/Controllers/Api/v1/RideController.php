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
use App\Models\Point;
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
						->with(['club', 'club.point'])
                        ->with(['driver', 'car'])
						->with(['items', 'items.point', 'items.order', 'items.order.user', 'items.order.club', 'items.order.club.point', 'items.order.payments'])
						->orderBy('rides.created_at', 'desc')
						->paginate();
        return new RideCollection($models);
    }
    
    /**
     * Get current ride.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function current(Request $request)
    {
		$model = $request->user()->ridesDrived()
            ->whereIn('rides.status', [Ride::STATUS_STARTED, Ride::STATUS_PING, Ride::STATUS_COMPLETABLE])
            ->with(['club', 'club.point'])
            ->with(['driver', 'car'])
            ->with(['items', 'items.point', 'items.order', 'items.order.user', 'items.order.club', 'items.order.club.point', 'items.order.payments'])
            ->orderBy('rides.start_at', 'asc')
            ->firstOrFail();
        return new RideResource($model);
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
		$ride->load(['driver', 'car'])
            ->load(['club', 'club.point'])
			->load(['items', 'items.point', 'items.order', 'items.order.user', 'items.order.club', 'items.order.club.point', 'items.order.payments']);
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
		
		if($ride->car){
			$ride->car->lock();
		}
		
        return $this->direction($request);
    }
    
    /**
     * Finish driving ride: complete or cancel
     *
     * @param  Request  $request
     * @param  Ride  $ride
     *
     * @return Response
     */
    public function finish(Request $request)
    {
        $ride = Ride::findOrFail($request->input('id'));
        
        if(!$ride->isCancelable() && !$ride->isCompletable()){
            return $this->error(400, 4003, trans('messages.ride.not.finishable'));
        }
        
        if($ride->isCompletable()){
            return $this->complete($request);
        }
		
        return $this->cancel($request);
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
            if($ride->status == Ride::STATUS_CANCELED){
                $ride->load(['items', 'items.point', 'items.order', 'items.order.user', 'items.order.club', 'items.order.club.point', 'items.order.payments']);
                return new RideResource($ride);
            }
            return $this->error(400, 4003, trans('messages.ride.not.cancelable'));
        }
        
        $ride->cancel();
		
		if($ride->car){
			$ride->car->free();
		}
        
		foreach($ride->rideitems as $rideitem){
			if($rideitem->isCancelable()){
				$rideitem->cancel();
				
				if($rideitem->ride){
					$rideitem->ride->getNextRideItem();
				}
				
				if($rideitem->item){
        			if($rideitem->item->isCancelable()){
						$rideitem->item->cancel();
					}
				}
				
				if($rideitem->order){
					$rideitem->order->cancel($request->user());
				}
			}
		}
		
		$ride->load(['items', 'items.point', 'items.order', 'items.order.user', 'items.order.club', 'items.order.club.point', 'items.order.payments']);
		
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
		
		if($ride->car){
			$ride->car->free();
		}
		
		$rideitems = $ride->rideitems()
			->where('ride_item.status', RideItem::STATUS_STARTED)
			->get();
		
        foreach($rideitems as $rideitem){
			$rideitem->complete();
			if($rideitem->item){
				$rideitem->item->complete();
				if($rideitem->item->order){
					$rideitem->item->order->updateStatus(); // Check order status
				}
			}
		}
        
		$ride->load(['items', 'items.point', 'items.order', 'items.order.user', 'items.order.club', 'items.order.club.point', 'items.order.payments']);
		
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
        
        $rideitems = $ride->rideitems()->where('ride_item.status', RideItem::STATUS_ACTIVE)->get();
        if(empty($rideitems)){
            return $this->error(400, 4005, trans('messages.no.items.found'));
        }
        
        $orgin = null;
        $point = $request->input('origin');
        if(!empty($point)){
            $orgin = new Point($point);
        }
        
        if(!$ride->verifyDirection($this->google, $orgin)){
            return $this->error(400, 4006, trans('messages.no.route.found'));
        }
        
		$ride->getNextRideItem();
        
		$ride->load(['items', 'items.point', 'items.order', 'items.order.user', 'items.order.club', 'items.order.club.point', 'items.order.payments']);
		
        return new RideResource($ride);
    }
}
