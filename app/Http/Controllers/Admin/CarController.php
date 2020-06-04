<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCar as StoreCarRequest;
use App\Http\Requests\UpdateCar as UpdateCarRequest;
use App\Models\Car;
use App\Models\Image;
use App\Services\ImageUploader;
use Illuminate\Http\Request;

class CarController extends Controller
{
    
    private $uploader;
    
    public function __construct(ImageUploader $uploader)
    {
        $this->uploader = $uploader;
    }
    
    /**
     * Show the list of all car
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $s = $request->get('s');
        if(!empty($s)){
            $s = '%'.$s.'%';
            $cars = Car::orWhere('name', 'LIKE', $s)
                        ->with('driver')
                        ->with('club')
                        ->paginate();
        }else{
            $cars = Car::with('driver')
                        ->with('club')
                        ->paginate();
        }
        
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
        $validated = $request->validated();
        $car = new Car($validated);
        $car->driver_id = $request->input('driver');
        $car->club_id = $request->input('club');
        $car->save();
        if($car->save()){
            $this->uploader->upload('image', $car);
            return back()->with("success", trans('messages.controller.success.car.created'));
        }else{
            return back()->with("error",  trans('messages.controller.error'));
        }
    }
    
    /**
     * Show the form to edit specified car.
     *
     * @param Car $car
     * @return Response
     */
    public function edit(Car $car)
    {
        return view('admin.car.edit', ['model' => $car]);
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
        $validated = $request->validated();
        $car->fill($validated);
        $car->driver_id = $request->input('driver');
        $car->club_id = $request->input('club');
        if($car->save()){
            $this->uploader->upload('image', $car);
            return back()->with("success", trans('messages.controller.success.car.updated'));
        }else{
            return back()->with("error",  trans('messages.controller.error'));
        }
    }

    /**
     * Delete the specified club.
     *
     * @param Request  $request
     * @return Response
     */
    public function delete(Request $request)
    {
        $car = Car::findOrFail($request->input('id'));
        $car->delete();
        return response()->json([
            'status' => "success",
            'message' => trans('messages.controller.success.car.deleted'),
        ]);
    }
}
