<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApiKey;

class ApiKeyController extends Controller
{
    
    /**
     * Show the list of all apikey
     *
     * @return Response
     */
    public function index()
    {
        $apikeys = ApiKey::paginate();
        
        return view('admin.apikey.index', ['models' => $apikeys]);
    }

    /**
     * Show the apikey info.
     *
     * @param ApiKey $apikey
     * @return Response
     */
    public function show(ApiKey $apikey)
    {
        return view('admin.apikey.show', ['model' => $apikey]);
    }
    
    /**
     * Show the form to create a new apikey.
     *
     * @return Response
     */
    public function create()
    {
        $model = new ApiKey();
        return view('admin.apikey.create', ['model' => $model]);
    }

    /**
     * Store a new apikey.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
			'name' => 'required|string|max:255',
			'scopes' => 'required|string|max:255',
			'version' => 'sometimes|string|max:255',
		]);
		
        ApiKey::create($request->all());
		
		return back()->with("success", trans('messages.controller.success.apikey.created'));
    }
    
    /**
     * Show the form to edit specified apikey.
     *
     * @param ApiKey $apikey
     * @return Response
     */
    public function edit(ApiKey $apikey)
    {
        return view('admin.apikey.edit', ['model' => $apikey]);
    }

    /**
     * Update the specified apikey.
     *
     * @param Request  $request
     * @param ApiKey $apikey
     * @return Response
     */
    public function update(Request $request, ApiKey $apikey)
    {
        $request->validate([
			'name' => 'required|string|max:255',
			'scopes' => 'required|string|max:255',
			'version' => 'sometimes|string|max:255',
		]);
		
        $apikey->fill($request->all());
		
		return back()->with("success", trans('messages.controller.success.apikey.updated'));
    }

    /**
     * Delete the specified apikey.
     *
     * @param Request  $request
     * @param ApiKey $apikey
     * @return Response
     */
    public function delete(ApiKey $apikey)
    {
        $club->delete();

        return response()->json([
            'code' => 200,
            'status' => "success",
        ]);
    }
}
