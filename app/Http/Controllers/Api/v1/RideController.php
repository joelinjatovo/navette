<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\ItemStatusChanged;
use App\Events\RideStatusChanged;
use App\Http\Controllers\Controller;
use App\Http\Resources\RideCollection;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\ItemCollection;
use App\Http\Resources\RidePointCollection;
use App\Http\Resources\RideItem as RideItemResource;
use App\Models\Ride;
use App\Models\RidePoint;
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
        return new RideCollection($request->user()->ridesDrived()->with('driver')->with('car')->orderBy('rides.created_at', 'desc')->paginate());
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
        return new RideItemResource($ride);
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
    public function points(Request $request, Ride $ride)
    {
        return new RidePointCollection($ride->points()->paginate());
    }
    
    /**
     * Add item to the current ride
     *
     * @param  Request  $request
     * @param  Ride  $ride
     *
     * @return Response
     */
    public function attach(Request $request, Ride $ride)
    {
        $item = Item::findOrFail($request->input('id'));
		
		$ride->attach($item->point);
        
        return new RideItemResource($ride);
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
            return $this->error(400, 112, trans('messages.ride.not.startable'));
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
            return $this->error(400, 113, trans('messages.ride.not.cancelable'));
        }
        
        $ride->cancel();
		
		$status = [Item::STATUS_CANCELED, Item::STATUS_COMPLETED];
		// List of items can be detached
		$items = $this->items()->whereNotIn('items.status', $status)->get();
		forach($items as $item){
			if($item->point){
				$ride->detachPoint($item->point);
			}
			$item->detach();
			$item->setStartAt(null);
			
			if($item->order){
				$item->order->ok();
			}
		}
        
        return new RideItemResource($ride);
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
		
		$points = $this->points()->wherePivot('status', RidePoint::STATUS_ONLINE)->get();
        foreach($points as $point){
            $this->points()->updateExistingPivot($point->getKey(), [
				'status' => RidePoint::STATUS_COMPLETED,
				'completed_at' => now()
			]);
		}
		
		$items = $this->items()->where('items.status', Item::STATUS_ONLINE)->get();
		foreach($items as $item){
			$item->complete();
			if($item->order){
				$item->order->updateStatus();
			}
		}
        
        return new RideItemResource($ride);
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
        
        $points = $ride->points()->wherePivot('status', RidePoint::STATUS_ACTIVE)->get();
        if(empty($points)){
            return $this->error(400, 114, "Empty ride locations");
        }
        
        if(!$ride->verifyDirection($this->google)){
            return $this->error(400, 115, "Ride direction not verified");
        }
        
        $ride->getNextPoint();
        
        return new RideItemResource($ride);
    }
}
