<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCar as StoreCarRequest;
use App\Http\Requests\UpdateCar as UpdateCarRequest;
use App\Models\Car;

class CarController extends Controller
{
    
    /**
     * Show the list of all car
     *
     * @return Response
     */
    public function index()
    {
        $cars = Car::paginate();
        
        return view('admin.car.index', ['models' => $cars]);
    }

    /**
     * Show the car info.
     *
     * @param Car $car
     * @return Response
     */
    public function show(Car $car)
    {
        return view('admin.car.show', ['model' => $car]);
    }
    
    /**
     * Show the form to create a new car.
     *
     * @return Response
     */
    public function create()
    {
        $model = new Car();
        return view('admin.car.create', ['model' => $model]);
    }

    /**
     * Store a new car.
     *
     * @param  StoreCarRequest  $request
     * @return Response
     */
    public function store(StoreCarRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
    }
    
    /**
     * Show the form to edit specified car.
     *
     * @param Car $car
     * @return Response
     */
    public function edit(Car $car)
    {
        return view('admin.club.edit', ['model' => $car]);
    }

    /**
     * Update the specified car.
     *
     * @param Request  $request
     * @param Car $car
     * @return Response
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
    }

    /**
     * Delete the specified car.
     *
     * @param Request  $request
     * @param Car $car
     * @return Response
     */
    public function delete(Car $car)
    {
        $car->delete();

        return response()->json([
            'code' => 200,
            'status' => "success",
            'message' => __('messages.success.car.deleted'),
        ]);
    }
}
