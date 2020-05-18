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
    public function index()
    {
        $users = User::paginate();
        
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
        return view('admin.user.show', ['model' => $user]);
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
            'password' => Hash::make($request->get($validated['password']))
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
    public function delete(User $user)
    {
        $user->delete();

        return response()->json([
            'code' => 200,
            'status' => "success",
        ]);
    }

    /**
     * Delete the specified user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function delete_ajax(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if(isset($data['_id'])){
                $user = User::findOrFail($data['_id']);
                return $user->delete() ? 1 : 0;
            }
        }
    }

    /**
     * Edit the specified user.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function edit_ajax(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if(isset($data['_id']) && isset($data['name']) && isset($data['phone']) && isset($data['email']) ){
                $validated_data = $request->validate([
                    'name' => 'required|max:255',
                    'phone' => 'required|numeric',
                    'email' => 'required|email',
                ]);
                var_dump($validated_data);
                if( isset($validated_data->errors) ){
                    return json_encode(array("error" => $validated_data->errors ));
                }else{
                    $user = User::findOrFail($data['_id']);
                    $user->name = $validated_data['name'];
                    $user->phone = $validated_data['phone'];
                    $user->email = $validated_data['email'];
                    return $user->save() ? 1 : 0;
                }
            }
        }
    }

    /**
     * Display user profile form.
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function edit_modal(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if(isset($data['_id'])){
                $user = User::findOrFail($data['_id']);
                return view('admin.user.edit-modal', ['model' => $user]);
            }
        }
    }

}
