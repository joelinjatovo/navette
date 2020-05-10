<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserPoint as StoreUserPointRequest;
use App\Http\Resources\UserPoint as UserPointResource;
use App\Http\Resources\User as UserResource;
use App\Jobs\ProcessRide;
use App\Models\User;
use App\Models\UserPosition;
use App\Models\Point;
use App\Models\Ride;
use Illuminate\Http\Request;

class UserPointController extends Controller
{
    
    /**
     * Store a new user postion.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreUserPointRequest $request)
    {
        $data = $request->validated();
        $point = Point::create($data);
        
        $user = $request->user();
        $user->positions()->attach($point->id, ['created_at' => now()]);
        
        event(new \App\Events\UserPointCreated($user, $point));
        
        $ride = Ride::where('driver', $user->getKey())
            ->andWhere('status', Ride::STATUS_ACTIVE)
            ->first();
        if($ride){
            ProcessRide::dispatchAfterResponse($ride);
        }

        return $this->success(200, "Position created");
    }
}
