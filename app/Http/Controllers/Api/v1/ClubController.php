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
    public function index(Request $request){
		if($request->get('s') && !empty(trim($request->get('s')))){
			$s = '%'.trim($request->get('s')).'%';
			$models = Club::where('name', 'LIKE', $s)
				->with(['point', 'cars'])
				->paginate();
		}else{
			$models = Club::with(['point', 'cars'])->paginate();
		}
		
        return new ClubCollection($models);
    }
}
