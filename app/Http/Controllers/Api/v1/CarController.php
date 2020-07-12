<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\AccessToken as AccessTokenResource;
use App\Models\Car;


class CarController extends Controller
{
    
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
            if($car->status == Car::STATUS_UNAVAILABLE){
                $car->status = Car::STATUS_AVAILABLE;
                $car->save();
            }elseif($car->status == Car::STATUS_AVAILABLE){
                $car->status = Car::STATUS_UNAVAILABLE;
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
