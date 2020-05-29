<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUser as StoreUserRequest;
use App\Http\Requests\UpdateUser as UpdateUserRequest;
use App\Models\User;
use App\Models\Image;
use App\Services\ImageUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
            $users = User::orWhere('name', 'LIKE', $s)
                        ->orWhere('phone', 'LIKE', $s)
                        ->orWhere('email', 'LIKE', $s)
                        ->paginate();
        }else{
            $users = User::paginate();
        }
        
        return view('admin.user.index', ['models' => $users]);
    }

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(User $user)
    {
        $orders = $user->orders()->paginate();
        return view('admin.user.show', ['model' => $user, 'orders' => $orders]);
    }
    
    /**
     * Show the form to create a new user.
     *
     * @return Response
     */
    public function create()
    {
        $model = new User();
        return view('admin.user.create', ['model' => $model]);
    }

    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $user = new User([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'])
        ]);
        
        if($user->save()){
            $user->roles()->attach($validated['roles']);
            $this->uploader->upload('image', $user);
            return back()->with("success", trans('messages.controller.success.user.created'));
        }else{
            return back()->with("error",  trans('messages.controller.error'));
        }
    }
    
    /**
     * Show the form to edit specified user.
     *
     * @param  string  $id
     * @return Response
     */
    public function edit(User $user)
    {
        return view('admin.user.edit', ['model' => $user]);
    }

    /**
     * Update the specified user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->fill([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
        ]);
        
        if($user->save()){
            $user->roles()->sync($validated['roles']);
            $this->uploader->upload('image', $user);
            return back()->with("success", trans('messages.controller.success.user.updated'));
        }
        
        return back()->with("error",  trans('messages.controller.error'));
    }

    /**
     * Delete the specified user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function delete(Request $request)
    {
        $user = User::findOrFail($request->input('id'));
        
        $user->delete();

        return response()->json([
            'status' => "success",
            'message' => trans('messages.controller.success.user.deleted'),
        ]);
    }

}
