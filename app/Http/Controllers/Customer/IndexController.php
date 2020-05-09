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
    public function index()
    {
        return view('customer.dashboard.index');
    }
}
