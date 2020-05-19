<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClub as StoreClubRequest;
use App\Http\Requests\UpdateClub as UpdateClubRequest;
use App\Models\Club;
use App\Models\Image;
use App\Models\Point;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    
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
                        ->paginate();
        }else{
            $clubs = Club::paginate();
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
        $point->name = $validated['club']['name'];
        $point->save();
        
        $model = new Club($validated['club']);
        $model->point()->associate($point);
        $model->save();
        
        if ($request->hasFile('club.image')) {
            $file = $request->file('club.image');
            if ($file->isValid()) {
                $name = md5(time()).'.'.$file->extension();
                $path = $file->storeAs('uploads',  'clubs/' . $model->getKey() . '/' . $name);
                
                $image = new Image([
                    'url' => $path, 
                    'type' => $file->getClientMimeType(), 
                    'name'=>$file->getClientOriginalName()
                ]);
                
                $model->image()->save($image);
            }
        }
        
        return back()->withInput()->with('success', __('messages.success.club.stored'));
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
        $point->name = $validated['club']['name'];
        $point->save();
        
        $club->fill($validated['club']);
        $club->point()->associate($point);
        $club->save();
        
        if ($request->hasFile('club.image')) {
            $file = $request->file('club.image');
            if ($file->isValid()) {
                $name = md5(time()).'.'.$file->extension();
                $path = $file->storeAs('uploads',  'clubs/' . $club->getKey() . '/' . $name);
                
                $data = [
                    'url' => $path, 
                    'type' => $file->getClientMimeType(), 
                    'name' => $file->getClientOriginalName()
                ];
                $image = $club->image;
                if(!$image){
                    $image = new Image($data);
                    $club->image()->save($image);
                }else{
                    $image->fill($data);
                    $club->image()->save($image);
                }
                
            }
        }
        
        return back()->withInput()->with('success', __('messages.success.club.updated'));
    }

    /**
     * Delete the specified user.
     *
     * @param Request  $request
     * @return Response
     */
    public function delete(Request $request, Club $club)
    {
        $club->delete();
        return response()->json([
            'code' => 200,
            'status' => "success",
            'message' => __('messages.success.club.deleted'),
        ]);
    }

}
