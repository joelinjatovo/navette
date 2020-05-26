<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class IndexController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function index()
    {
        return view('admin.dashboard.index', [
			'count' => [
				'orders' => Order::count()
			],
			'orders' => Order::orderBy('created_at', 'desc')->take(10)->get()
		]);
    }
}
