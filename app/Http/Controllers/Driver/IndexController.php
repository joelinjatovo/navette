<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Show dashboard
     *
     * @return View
     */
    public function index(Request $request)
    {
        return view('driver.dashboard.index', [
			'count' => [
				'rides' => $request->user()->ridesDrived()->count()
			],
			'rides' => $request->user()->ridesDrived()->orderBy('created_at', 'desc')->take(10)->get()
		]);
    }
}
