<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClub as StoreClubRequest;
use App\Http\Requests\UpdateClub as UpdateClubRequest;
use App\Models\Club;

class ClubController extends Controller
{
    
    /**
     * Show the list of all user
     *
     * @return Response
     */
    public function index()
    {
        $clubs = Club::all();
        
        return view('admin.club.index', ['models' => $clubs]);
    }

    /**
     * Show the club info.
     *
     * @param  Club $club
     * @return Response
     */
    public function show(Club $club)
    {
        return view('admin.club.show', ['model' => $club]);
    }
    
    /**
     * Show the form to create a new club.
     *
     * @return Response
     */
    public function create()
    {
        $model = new Club();
        return view('admin.club.create', ['model' => $model]);
    }

    /**
     * Store a new club.
     *
     * @param  StoreClubRequest  $request
     * @return Response
     */
    public function store(StoreClubRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
    }
    
    /**
     * Show the form to edit specified club.
     *
     * @param Club $club
     * @return Response
     */
    public function edit(Club $club)
    {
        return view('admin.club.edit', ['model' => $club]);
    }

    /**
     * Update the specified club.
     *
     * @param Request  $request
     * @param Club $club
     * @return Response
     */
    public function update(UpdateClubRequest $request, Club $club)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
    }

    /**
     * Delete the specified user.
     *
     * @param Request  $request
     * @param Club $club
     * @return Response
     */
    public function delete(Club $club)
    {
        $club->delete();

        return response()->json([
            'code' => 200,
            'status' => "success",
        ]);
    }

}
