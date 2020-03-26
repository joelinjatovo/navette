<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show the user's profile.
     *
     * @param  Request  $request
     * @return Response
     */
    public function show(Request $request)
    {
        // $request->user() returns an instance of the authenticated user...
    }
    
    /**
     * Show form to edit the user's profile.
     *
     * @param  Request  $request
     * @return Response
     */
    public function edit()
    {
        // $request->user() returns an instance of the authenticated user...
    }
    
    /**
     * Update the user's profile.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(Request $request)
    {
        // $request->user() returns an instance of the authenticated user...
    }
}
