<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ClubCollection;
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
}
