<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Show order wizard
     *
     * @param  int  $id
     * @return View
     */
    public function index()
    {
        return view('shop.index');
    }
}
