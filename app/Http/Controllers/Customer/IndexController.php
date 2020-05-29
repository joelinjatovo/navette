<?php

namespace App\Http\Controllers\Customer;

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
        return view('customer.dashboard.index', [
			'count' => [
				'orders' => $request->user()->orders()->count()
			],
			'orders' => $request->user()->orders()->orderBy('created_at', 'desc')->take(10)->get()
		]);
    }
}
