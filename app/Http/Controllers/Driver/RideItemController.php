<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RideItem;

class RideItemController extends Controller
{
    
    /**
     * Show the list of all ride
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $s = $request->get('s');
        if(!empty($s)){
            $s = '%'.$s.'%';
            $points = RideItem::join('items', 'items.id', '=', 'ride_point.item_id')
						->join('rides', 'rides.id', '=', 'ride_point.ride_id')
						->join('orders', 'orders.id', '=', 'items.order_id')
						->join('users', 'users.id', '=', 'orders.user_id')
						->where('rides.driver_id', $request->user()->getKey())
						->where(function($query) use ($s){
							$query->where('users.name', 'LIKE', $s);
							$query->orWhere('users.phone', 'LIKE', $s);
							$query->orWhere('users.email', 'LIKE', $s);
						})
                        ->paginate();
        }else{
	        $points = RideItem::with('point')
				->join('rides', 'rides.id', '=', 'ride_point.ride_id')
				->where('rides.driver_id', $request->user()->getKey())
				->with('point.user')
				->paginate();
        }
        
        return view('driver.rideitem.index', ['models' => $points]);
    }

    /**
     * Show the ride point info.
     *
     * @param RideItem $rideitem
     * @return Response
     */
    public function show(RideItem $rideitem)
    {
        return view('driver.rideitem.show', ['model' => $rideitem]);
    }

    /**
     * Handle specified action
     *
     * @param Request  $request
	 *
     * @return Response
     */
    public function action(Request $request)
    {
        $rideitem = RideItem::findOrFail($request->input('id'));
		switch($request->input('action')){
			case 'arrive':
				if(!$rideitem->arrivable()){
					return response()->json([
						'status' => "error",
						'message' => trans('messages.controller.success.rideitem.not.arrivable'),
					]);
				}

				$rideitem->arrive();

				$ride = $rideitem->ride;
				if($ride){
					// Select next item
					$ride->next();
				}
				return response()->json([
					'status' => "success",
					'message' => trans('messages.controller.success.rideitem.arrived'),
				]);
			break;
			case 'pick-or-drop':
				if(!$rideitem->dropable() && !$rideitem->pickable()){
					return response()->json([
						'status' => "error",
						'message' => trans('messages.controller.success.rideitem.not.completable'),
					]);
				}

				$rideitem->pickOrDrop();

				$ride = $rideitem->ride;
				if($ride){
					// Select next item
					$ride->next();
				}
				return response()->json([
					'status' => "success",
					'message' => trans('messages.controller.success.rideitem.completed'),
				]);
			break;
		}
		
        return response()->json([
            'status' => "error",
            'message' => trans('messages.controller.success.rideitem.unknown'),
        ]);
    }

    /**
     * Delete the specified ride point.
     *
     * @param Request  $request
     * 
     * @return Response
     */
    public function delete(Request $request)
    {
        $rideitem = RideItem::findOrFail($request->input('id'));
		$rideitem->delete();
        return response()->json([
            'status' => "success",
            'message' => trans('messages.controller.success.rideitem.deleted'),
        ]);
    }
}