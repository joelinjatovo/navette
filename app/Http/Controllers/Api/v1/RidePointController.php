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
        
        if(!$ridepoint->isArrivable()){
            return $this->error(400, 120, trans('messages.ridepoint.not.arrivable'));
        }
        
        $ridepoint->arrive();
		
		if($ridepoint->item){
			$ridepoint->item->arrive();
		}
		
		if($ridepoint->ride){
			$ridepoint->ride->getNextPoint();
		}
        
        return new RideItemResource($ridepoint->ride);
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
        $ridepoint = RidePoint::findOrFail($request->input('id'));
        
        if(!$ridepoint->isCancelable()){
            return $this->error(400, 117, trans('messages.ridepoint.not.cancelable'));
        }
        
        $ridepoint->cancel();
		
		if($ridepoint->item){
			$ridepoint->item->cancel();
		}
		
		if($ridepoint->ride){
			$ridepoint->ride->getNextPoint();
		}
        
        return new RideItemResource($ridepoint->ride);
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
        $ridepoint = RidePoint::findOrFail($request->input('id'));
        
        if(!$ridepoint->isPickable() && !$ridepoint->isDropable()){
            return $this->error(400, 116, trans('messages.ridepoint.not.pickable.or.dropable'));
        }
        
        $ridepoint->pickOrDrop();
		
		if($ridepoint->item){
			if($ridepoint->item->type == Item::TYPE_GO){
				$ridepoint->item->start();
            }else{
				$ridepoint->item->complete();
            }
		}
		
		if($ridepoint->ride){
			$ridepoint->ride->getNextPoint();
		}
        
        return new RideItemResource($ridepoint->ride);
    }
	
}
