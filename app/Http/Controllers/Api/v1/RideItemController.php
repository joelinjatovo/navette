<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\RideItem;
use App\Models\Payment;
use App\Http\Resources\RideItem as RideItemResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RideItemController extends Controller
{
    
    /**
     * Arrive a ride point.
     *
     * @param  Request  $request
     * @param  RideItem $rideitem
     *
     * @return Response
     */
    public function arrive(Request $request, RideItem $rideitem)
    {
        if(!$rideitem->isArrivable()){
            return $this->error(400, 5002, trans('messages.rideitem.not.arrivable'));
        }
        
        $rideitem->arrive();
		
		if($rideitem->ride){
			$rideitem->ride->getNextRideItem();
		}
        
        return new RideItemResource($rideitem);
    }
    
    /**
     * Cancel a ride point.
     *
     * @param  Request  $request
     * @param  RideItem  $rideitem
     *
     * @return Response
     */
    public function cancel(Request $request, RideItem $rideitem)
    {
        if(!$rideitem->isCancelable()){
            return $this->error(400, 5003, trans('messages.rideitem.not.cancelable'));
        }
        
        $rideitem->cancel();
		
		if($rideitem->ride){
			$rideitem->ride->getNextRideItem();
		}
        
        return new RideItemResource($rideitem);
    }
    
    /**
     * Pick or drop ride point
     *
     * @param  Request  $request
     * @param  RideItem $rideitem
     *
     * @return Response
     */
    public function pickOrDrop(Request $request, RideItem $rideitem)
    {
        if(!$rideitem->isPickable() && !$rideitem->isDropable()){
            return $this->error(400, 5004, trans('messages.rideitem.not.pickable.or.dropable'));
        }
		
		$payments = $request->input('payments');
		if(is_array($payments)){
			$item = $rideitem->item;
			$order = null;
			if($item){
				$order = $item->order;
			}
			
			foreach($payments as $value){
				$payment = Payment::create($value);
				if($order){
					$payment->status = Payment::STATUS_SUCCESS;
					$payment->order_id = $order->getKey();
				}
				
				if($payment->save() && $order){
					$order->paidPer($payment->payment_type);
				}
			}
		}
        
        $rideitem->pickOrDrop();
		
		if($rideitem->ride){
			$rideitem->ride->getNextRideItem();
		}
        
        return new RideItemResource($rideitem);
    }
	
}
