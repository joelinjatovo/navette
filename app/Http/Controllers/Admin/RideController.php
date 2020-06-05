<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ride;

class RideController extends Controller
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
            $rides = Ride::join('users', 'users.id', '=', 'rides.driver_id')
						->orWhere('users.name', 'LIKE', $s)
                        ->orWhere('users.phone', 'LIKE', $s)
                        ->orWhere('users.email', 'LIKE', $s)
						->with('driver')
                        ->paginate();
        }else{
	        $rides = Ride::with('driver')->paginate();
        }
        
        return view('admin.ride.index', ['models' => $rides]);
    }

    /**
     * Show the ride info.
     *
     * @param Ride $ride
     * @return Response
     */
    public function show(Ride $ride)
    {
		$points = $ride->points()->with('items')->with('items.order')->get();
		$items = $ride->items()->with('order')->with('order.user')->get();
        return view('admin.ride.show', ['model' => $ride, 'items' => $items, 'points' => $points]);
    }

    /**
     * Live the ride info.
     *
     * @param Ride $ride
     * @return Response
     */
    public function live(Ride $ride)
    {
		$points = $ride->points()->with('items')->with('items.order')->get();
		$items = $ride->items()->with('order')->with('order.user')->get();
        return view('admin.ride.live', ['model' => $ride, 'items' => $items, 'points' => $points]);
    }

    /**
     * Vuejs
     *
     * @param Ride $ride
     * @return Response
     */
    public function vuejs(Ride $ride)
    {
		$points = $ride->points()->with('items')->with('items.order')->get();
		$items = $ride->items()->with('order')->with('order.user')->get();
        return view('admin.ride.vuejs', ['model' => $ride, 'items' => $items, 'points' => $points]);
    }
    
    /**
     * Show the form to create a new ride.
     *
     * @return Response
     */
    public function create()
    {
        $model = new Ride();
        return view('admin.ride.create', ['model' => $model]);
    }

    /**
     * Store a new ride.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
    }
    
    /**
     * Show the form to edit specified ride.
     *
     * @param Ride $ride
     * @return Response
     */
    public function edit(Ride $ride)
    {
        return view('admin.ride.edit', ['model' => $ride]);
    }

    /**
     * Update the specified ride.
     *
     * @param Request  $request
     * @param Ride $ride
     * @return Response
     */
    public function update(Request $request, Ride $ride)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
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
        $ride = Ride::findOrFail($request->input('id'));
		switch($request->input('action')){
			case 'start':
				if(!$ride->isStartable()){
					return response()->json([
						'status' => "error",
						'message' => trans('messages.controller.success.ride.not.startable'),
					]);
				}
        		$ride->start();
				return response()->json([
					'status' => "success",
					'message' => trans('messages.controller.success.ride.started'),
					'view' => view('admin.ride.table-row', ['model' => $ride])->render(),
				]);
			break;
			case 'cancel':
				if(!$ride->cancelable()){
					return response()->json([
						'status' => "error",
						'message' => trans('messages.controller.success.ride.not.cancelable'),
					]);
				}
        		$ride->cancel();
				return response()->json([
					'status' => "success",
					'message' => trans('messages.controller.success.ride.canceled'),
					'view' => view('admin.ride.table-row', ['model' => $ride])->render(),
				]);
			break;
			case 'complete':
        		$ride->complete();
				return response()->json([
					'status' => "success",
					'message' => trans('messages.controller.success.ride.completed'),
					'view' => view('admin.ride.table-row', ['model' => $ride])->render(),
				]);
			break;
		}
		
        return response()->json([
            'status' => "success",
            'message' => trans('messages.controller.success.ride.unknown'),
        ]);
    }

    /**
     * Delete the specified ride.
     *
     * @param Request  $request
     * 
     * @return Response
     */
    public function delete(Request $request)
    {
        $ride = Ride::findOrFail($request->input('id'));
		$ride->delete();
        return response()->json([
            'status' => "success",
            'message' => trans('messages.controller.success.ride.deleted'),
        ]);
    }
}
