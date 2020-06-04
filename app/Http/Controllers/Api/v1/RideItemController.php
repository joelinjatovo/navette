<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\RidePoint;
use App\Http\Resources\RideItem as RideItemResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RideItemController extends Controller
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
        $rideitem = RideItem::findOrFail($request->input('id'));
        
        if(!$rideitem->isArrivable()){
            return $this->error(400, 5002, trans('messages.rideitem.not.arrivable'));
        }
        
        $rideitem->arrive();
		
		/*
		if($rideitem->item){
			$rideitem->item->arrive();
		}
		
		if($rideitem->ride){
			$rideitem->ride->getNextPoint();
		}
		*/
        
        return new RideItemResource($rideitem);
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
        $rideitem = RidePoint::findOrFail($request->input('id'));
        
        if(!$rideitem->isCancelable()){
            return $this->error(400, 5003, trans('messages.rideitem.not.cancelable'));
        }
        
        $rideitem->cancel();
		
		/*
		if($rideitem->item){
			$rideitem->item->cancel();
		}
		
		if($rideitem->ride){
			$rideitem->ride->getNextPoint();
		}
		*/
        
        return new RideItemResource($rideitem);
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
        $rideitem = RidePoint::findOrFail($request->input('id'));
        
        if(!$rideitem->isPickable() && !$rideitem->isDropable()){
            return $this->error(400, 5004, trans('messages.rideitem.not.pickable.or.dropable'));
        }
        
        $rideitem->pickOrDrop();
		
		/*
		if($rideitem->item){
			if($rideitem->item->type == Item::TYPE_GO){
				$rideitem->item->start();
            }else{
				$rideitem->item->complete();
            }
		}
		
		if($rideitem->ride){
			$rideitem->ride->getNextPoint();
		}
		*/
        
        return new RideItemResource($rideitem);
    }
	
}
