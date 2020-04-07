<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\RideCollection;
use App\Http\Resources\OrderCollection;
use App\Models\Ride;
use Illuminate\Http\Request;

class RideController extends Controller
{
    /**
     * Paginate rides
     *
     * @return Response
     */
    public function index(Request $request){
        return new RideCollection($request->user()->ridesDrived()->paginate());
    }
    
    /**
     * Start a new ride.
     *
     * @param  Request  $request
     * @param  Ride  $ride
     *
     * @return Response
     */
    public function orders(Request $request, Ride $ride)
    {
        return OrderCollection($ride->orders());
    }
    
    /**
     * Start a new ride.
     *
     * @param  Request  $request
     * @param  Ride  $ride
     *
     * @return Response
     */
    public function start(Request $request, Ride $ride)
    {
        $ride->status = 'active';
        $ride->save();
        return $this->json(['status' => 'ok'])->status(200);
    }
}
