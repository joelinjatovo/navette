<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUser as StoreUserRequest;
use App\Http\Requests\UpdateUser as UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
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
        // Retrieve the validated input data...
        $validated = $request->validated();
        $user = new User([
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]);
        //$request->get('user_role');
        return $user->save() ? view('admin.user.create', ['success' => 'Utilisateur ajouté!' ]) : view('admin.user.create', ['error' => 'Erreur, réessayez plus tard.' ]); 
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
