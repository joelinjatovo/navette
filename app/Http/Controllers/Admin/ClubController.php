<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClub as StoreClubRequest;
use App\Http\Requests\UpdateClub as UpdateClubRequest;
use App\Models\Club;
use App\Models\Image;
use App\Models\Point;
use App\Services\ImageUploader;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    
    private $uploader;
    
    public function __construct(ImageUploader $uploader)
    {
        $this->uploader = $uploader;
    }
    
    /**
     * Show the list of all user
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $s = $request->get('s');
        if(!empty($s)){
            $s = '%'.$s.'%';
            $clubs = Club::orWhere('name', 'LIKE', $s)
                        ->withCount('orders')
                        ->paginate();
        }else{
            $clubs = Club::withCount('orders')
                        ->paginate();
        }
        
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
        $orders = $club->orders()->with('user')->paginate();
        $cars = $club->cars()->with('driver')->get();
        return view('admin.club.show', ['model' => $club, 'orders' => $orders, 'cars' => $cars]);
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
        $point->name = $validated['name'];
        $point->save();
        
        $model = new Club($validated);
        $model->point()->associate($point);
        
        if($model->save()){
            $this->uploader->upload('image', $model);
            return back()->with("success", trans('messages.controller.success.club.created'));
        }else{
            return back()->with("error",  trans('messages.controller.error'));
        }
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
        
        $point = $club->point;
        if(!$point) {
            $point = new Point();
        }
        $point->fill($validated['point']);
        $point->name = $validated['name'];
        $point->save();
        
        $club->fill($validated);
        $club->point()->associate($point);
        
        if($club->save()){
            $this->uploader->upload('image', $club);
            return back()->with("success", trans('messages.controller.success.club.updated'));
        }else{
            return back()->with("error",  trans('messages.controller.error'));
        }
    }

    /**
     * Delete the specified club.
     *
     * @param Request  $request
     * @return Response
     */
    public function delete(Request $request)
    {
        $club = Club::findOrFail($request->input('id'));
        $club->delete();
        return response()->json([
            'status' => "success",
            'message' => trans('messages.controller.success.club.deleted'),
        ]);
    }

}
