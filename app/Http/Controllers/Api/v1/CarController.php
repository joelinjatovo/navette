<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\AccessToken as AccessTokenResource;
use App\Http\Resources\CarCollection;
use App\Models\Car;
use App\Models\Club;


class CarController extends Controller
{

    /**
     * Paginate cars
     *
     * @return Response
     */
    public function index(Request $request, Club $club){
        return new CarCollection($club->cars()->paginate());
    }
    
    
    /**
     * Get current ride.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function toggle(Request $request)
    {
		$car = $request->user()->car;
        if($car){
            // Deconnect driver of the car
            if($car->status == Car::STATUS_AVAILABLE){
                $car->status = Car::STATUS_UNAVAILABLE;
                $car->driver_id = null;
                $car->save();
            }else if($car->status == Car::STATUS_UNAVAILABLE){
                $car->driver_id = null;
                $car->save();
            }
        }else{
            $car = Car::findOrFail($request->input('id'));
            if($car){
                // Connect driver of the car
                $car->status = Car::STATUS_AVAILABLE;
                $car->driver_id = $request->user()->getKey();
                $car->save();
            }
        }
        
        $token = app('api_token');
		
		$token->load('user')
			->load('user.car')
			->load('user.car.club');

        return (new AccessTokenResource($token));
    }
}
