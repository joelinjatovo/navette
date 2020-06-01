<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\RidePoint;
use App\Http\Resources\RideItem as RideItemResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RidePointController extends Controller
{
    
    /**
     * Arrive a ride point.
     *
     * @param  Request  $request
     * @param  Ride  $ride
     *
     * @return Response
     */
    public function arrive(Request $request)
    {
        $ridepoint = RidePoint::findOrFail($request->input('id'));
        
        if(!$ridepoint->arrivable()){
            return $this->error(400, 120, trans('messages.ridepoint.not.cancelable'));
        }
        
		// 1- Set driver as arrived to the ride point
		// 2- Set driver as arrived to the order item
        $ridePoint->arrive();
        
		// Select next item
        $ride = $ridePoint->ride;
        if($ride){$ride->next();}
        
        return new RideItemResource($ride);
    }
    
    /**
     * Cancel a ride point.
     *
     * @param  Request  $request
     * @param  Ride  $ride
     *
     * @return Response
     */
    public function cancel(Request $request)
    {
        $ridePoint = RidePoint::findOrFail($request->input('id'));
        
        if(!$ridePoint->cancelable()){
            return $this->error(400, 117, "Ride Point not cancelable");
        }
        
		// 1- Cancel ride point
		// 2- Cancel order item
        $ridePoint->cancel();
        
		// Select next item
        $ride = $ridePoint->ride;
        if($ride){$ride->next();}
        
        return new RideItemResource($ride);
    }
    
    /**
     * Pick or drop ride point
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function pickOrDrop(Request $request)
    {
        $ridePoint = RidePoint::findOrFail($request->input('id'));
        
        if(!$ridePoint->pickable() && !$ridePoint->dropable()){
            return $this->error(400, 116, "Ride Point not finishable");
        }
        
		// 1- Pick or drop ride point
		// 2- Pick or drop order item
        $ridePoint->pickOrDrop();
        
		// Select next item
        $ride = $ridePoint->ride;
        if($ride){$ride->next();}
        
        return new RideItemResource($ride);
    }
}
