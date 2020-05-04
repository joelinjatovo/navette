<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClub as StoreClubRequest;
use App\Http\Requests\UpdateClub as UpdateClubRequest;
use App\Models\Club;
use App\Models\Point;

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
        $validated = $request->validated();
        
        $point = new Point($validated['point']);
        $point->save();
        
        $model = new Club($validated['club']);
        $model->point()->associate($point);
        $model->save();
        
        return back()->withInput()->with('success', __('messages.success.club.created'));
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
        $validated = $request->validated();
        
        $point = $club->point();
        if(!$point) {
            $point = new Point();
        }
        $point->fill($validated['point']);
        $point->save();
        
        $club->fill($validated['club']);
        $club->point()->associate($point);
        $club->save();
        
        return back()->withInput()->with('success', __('messages.success.club.updated'));
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
