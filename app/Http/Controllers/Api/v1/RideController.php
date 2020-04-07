<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Ride;
use Illuminate\Http\Request;

class RideController extends Controller
{
    //

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
        return $this->json('status' => 'ok')->status(200);
    }
}
