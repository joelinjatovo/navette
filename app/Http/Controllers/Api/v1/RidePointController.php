<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\RidePoint;
use App\Http\Resources\RideItem as RideItemResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RidePointController extends Controller
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
        $ridePoint = RidePoint::findOrFail($request->input('ride_point_id'));
        
        if(!$ridePoint->finishable()){
            return $this->error(400, 116, "Ride Point not finishable");
        }
        
        $ridePoint->finish();
        
        $ride = $ridePoint->ride;
        if($ride){
            // Select next item
            $ride->next();
        }
        
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
        $ridePoint = RidePoint::findOrFail($request->input('ride_point_id'));
        
        if(!$ridePoint->cancelable()){
            return $this->error(400, 117, "Ride Point not cancelable");
        }
        
        $ridePoint->cancel();
        
        $ride = $ridePoint->ride;
        if($ride){
            // Select next item
            $ride->next();
        }
        
        return new RideItemResource($ride);
    }
}
