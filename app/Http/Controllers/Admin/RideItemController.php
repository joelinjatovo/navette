<?php

namespace App\Http\Controllers\Admin;

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
            $rideitems = RideItem::join('items', 'items.id', '=', 'ride_point.item_id')
						->join('orders', 'orders.id', '=', 'items.order_id')
						->join('users', 'users.id', '=', 'orders.user_id')
						->orWhere('users.name', 'LIKE', $s)
                        ->orWhere('users.phone', 'LIKE', $s)
                        ->orWhere('users.email', 'LIKE', $s)
                        ->paginate();
        }else{
	        $rideitems = RideItem::paginate();
        }
        
        return view('admin.rideitem.index', ['models' => $rideitems]);
    }

    /**
     * Show the ride point info.
     *
     * @param RideItem $rideitem
     * @return Response
     */
    public function show(RideItem $rideitem)
    {
        return view('admin.rideitem.show', ['model' => $rideitem]);
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