<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RidePoint;

class RidePointController extends Controller
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
            $points = RidePoint::join('items', 'items.id', '=', 'ride_point.item_id')
						->join('orders', 'orders.id', '=', 'items.order_id')
						->join('users', 'users.id', '=', 'orders.user_id')
						->orWhere('users.name', 'LIKE', $s)
                        ->orWhere('users.phone', 'LIKE', $s)
                        ->orWhere('users.email', 'LIKE', $s)
                        ->paginate();
        }else{
	        $points = RidePoint::with('point')
				->with('point.user')
				->paginate();
        }
        
        return view('admin.ridepoint.index', ['models' => $points]);
    }

    /**
     * Show the ride point info.
     *
     * @param RidePoint $ridepoint
     * @return Response
     */
    public function show(RidePoint $ridepoint)
    {
        return view('admin.ridepoint.show', ['model' => $ridepoint]);
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
        $ridepoint = RidePoint::findOrFail($request->input('id'));
		switch($request->input('action')){
			case 'arrive':
				if(!$ridepoint->arrivable()){
					return response()->json([
						'status' => "error",
						'message' => trans('messages.controller.success.ridepoint.not.arrivable'),
					]);
				}

				$ridepoint->arrive();

				$ride = $ridepoint->ride;
				if($ride){
					// Select next item
					$ride->next();
				}
				return response()->json([
					'status' => "success",
					'message' => trans('messages.controller.success.ridepoint.arrived'),
				]);
			break;
			case 'pick-or-drop':
				if(!$ridepoint->dropable() && !$ridepoint->pickable()){
					return response()->json([
						'status' => "error",
						'message' => trans('messages.controller.success.ridepoint.not.completable'),
					]);
				}

				$ridepoint->pickOrDrop();

				$ride = $ridepoint->ride;
				if($ride){
					// Select next item
					$ride->next();
				}
				return response()->json([
					'status' => "success",
					'message' => trans('messages.controller.success.ridepoint.completed'),
				]);
			break;
		}
		
        return response()->json([
            'status' => "error",
            'message' => trans('messages.controller.success.ridepoint.unknown'),
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
        $ridepoint = RidePoint::findOrFail($request->input('id'));
		$ridepoint->delete();
        return response()->json([
            'status' => "success",
            'message' => trans('messages.controller.success.ridepoint.deleted'),
        ]);
    }
}