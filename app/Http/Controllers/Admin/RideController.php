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
    public function index()
    {
        $rides = Ride::all();
        
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
        return view('admin.ride.show', ['model' => $ride]);
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
