<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ClubCollection;
use App\Http\Resources\CarCollection;
use App\Models\Car;
use App\Models\Club;


class ClubController extends Controller
{
    /**
     * Paginate clubs
     *
     * @return Response
     */
    public function index(){
        return new ClubCollection(Club::paginate());
    }
    
    /**
     * Paginate cars
     *
     * @return Response
     */
    public function cars(Club $club){
        return new CarCollection($club->cars()->paginate());
    }
}
