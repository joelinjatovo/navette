<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUser as StoreUserRequest;
use App\Http\Requests\UpdateUser as UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    
    /**
     * Show the list of all user
     *
     * @return Response
     */
    public function index()
    {
        $users = User::all();
        
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
        // Retrieve the validated input data...
        $validated = $request->validated();
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
        // Retrieve the validated input data...
        $validated = $request->validated();
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

}
