<?php

namespace App\Http\Controllers\Driver;

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
						->join('cars', 'cars.id', '=', 'rides.car_id')
						->where('rides.driver_id', $request->user()->getKey())
						->where(function($query) use ($s){
							$query->orWhere('cars.name', 'LIKE', $s);
						})
						->with('driver')
						->with('car')
                        ->paginate();
        }else{
	        $rides = Ride::with('driver')
				->where('rides.driver_id', $request->user()->getKey())
				->with('car')->paginate();
        }
        
        return view('driver.ride.index', ['models' => $rides]);
    }

    /**
     * Show the ride info.
     *
     * @param Ride $ride
     * @return Response
     */
    public function show(Ride $ride)
    {
		$items = $ride->items()->with('order')->with('order.user')->get();
        return view('driver.ride.show', ['model' => $ride, 'items' => $items]);
    }

    /**
     * Live the ride info.
     *
     * @param Ride $ride
     * @return Response
     */
    public function live(Ride $ride)
    {
		$items = $ride->items()->with('order')->with('order.user')->get();
        return view('driver.ride.live', ['model' => $ride, 'items' => $items]);
    }
    
    /**
     * Show the form to create a new ride.
     *
     * @return Response
     */
    public function create()
    {
        $model = new Ride();
        return view('driver.ride.create', ['model' => $model]);
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
        return view('driver.ride.edit', ['model' => $ride]);
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
					'view' => view('driver.ride.table-row', ['model' => $ride])->render(),
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
					'view' => view('driver.ride.table-row', ['model' => $ride])->render(),
				]);
			break;
			case 'complete':
        		$ride->complete();
				return response()->json([
					'status' => "success",
					'message' => trans('messages.controller.success.ride.completed'),
					'view' => view('driver.ride.table-row', ['model' => $ride])->render(),
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
     * @param Ride $ride
     * @return Response
     */
    public function delete(Ride $ride)
    {
        $club->delete();

        return response()->json([
            'code' => 200,
            'status' => "success",
        ]);
    }
}
