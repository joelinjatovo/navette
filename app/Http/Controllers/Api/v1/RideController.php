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
        return new RideCollection($request->user()->ridesDrived()->orderBy('rides.started_at', 'desc')->paginate());
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
     * Get items.
     *
     * @param  Request  $request
     * @param  Ride  $ride
     *
     * @return Response
     */
    public function items(Request $request, Ride $ride)
    {
        return new ItemCollection($ride->items()->paginate());
    }
    
    /**
     * Get points of rides
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
     * Start a ride.
     *
     * @param  Request  $request
     * @param  Ride  $ride
     *
     * @return Response
     */
    public function start(Request $request)
    {
        $ride = Ride::findOrFail($request->input('ride_id'));
        
        if(!$ride->activable()){
            return $this->error(400, 112, "Ride not activable");
        }
        
        $ride->active();
        
        return $this->direction($request);
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
        $ride = Ride::findOrFail($request->input('ride_id'));
        
        $points = $ride->points()->wherePivot('status', RidePoint::STATUS_ACTIVE)->get();
        if(empty($points)){
            return $this->error(400, 114, "Empty ride locations");
        }
        
        if(!$ride->verifyDirection($this->google)){
            return $this->error(400, 115, "Ride direction not verified");
        }
        
        $ride->next();
        
        return new RideItemResource($ride);
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
        $ride = Ride::findOrFail($request->input('ride_id'));
        
        if(!$ride->cancelable()){
            return $this->error(400, 113, "Ride not cancelable");
        }
        
        $ride->cancel();
        
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
        $ride = Ride::findOrFail($request->input('ride_id'));
        
        $ride->complete();
        
        return new RideItemResource($ride);
    }
}
