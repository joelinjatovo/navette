<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\RideCollection;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\RidePointCollection;
use App\Http\Resources\RideItem as RideItemResource;
use App\Models\Ride;
use Illuminate\Http\Request;

class RideController extends Controller
{
    /**
     * Paginate rides
     *
     * @return Response
     */
    public function index(Request $request){
        return new RideCollection($request->user()->ridesDrived()->paginate());
    }
    
    /**
     * Start a new ride.
     *
     * @param  Request  $request
     * @param  Ride  $ride
     *
     * @return Response
     */
    public function orders(Request $request, Ride $ride)
    {
        return new OrderCollection($ride->orders()->paginate());
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
        
        if(!$ride->startable()){
            return $this->error(400, 112, "Ride not startable");
        }
        
        $ride->start();
        
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
