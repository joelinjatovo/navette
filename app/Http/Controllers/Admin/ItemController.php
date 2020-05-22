<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemItem as ItemItemResource;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    
    /**
     * Show the list of all items
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $s = $request->get('s');
        if(!empty($s)){
            $s = '%'.$s.'%';
            $items = Item::join('points', 'points.id', '=', 'items.point_id')
						->join('users', 'users.id', '=', 'orders.user_id')
						->join('orders', 'orders.id', '=', 'items.order_id')
						->orWhere('points.name', 'LIKE', $s)
						->orWhere('users.name', 'LIKE', $s)
                        ->orWhere('users.phone', 'LIKE', $s)
                        ->orWhere('users.email', 'LIKE', $s)
						->with('order')
						->with('order.user')
						->with('point')
						->orderBy('created_at', 'desc')
                        ->paginate();
        }else{
	        $items = Item::with('order')
						->with('order.user')
						->with('point')
						->orderBy('created_at', 'desc')
						->paginate();
        }
        
        return view('admin.item.index', ['models' => $items]);
    }

    /**
     * Show the item info.
     *
     * @param Item $item
     * @return Response
     */
    public function show(Request $request, Item $item)
    {
        if($request->ajax()){
            return new ItemItemResource($item);
        }
        return view('admin.item.show', ['model' => $item]);
    }
    
    /**
     * Show the form to create a new item.
     *
     * @return Response
     */
    public function create()
    {
        $model = new Item();
        return view('admin.item.create', ['model' => $model]);
    }

    /**
     * Store a new ride.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
    }
    
    /**
     * Show the form to edit specified item.
     *
     * @param Item $item
     * @return Response
     */
    public function edit(Item $item)
    {
        return view('admin.item.edit', ['model' => $item]);
    }

    /**
     * Update the specified item.
     *
     * @param Request  $request
     * @param Item $item
     * @return Response
     */
    public function update(Request $request, Item $item)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
    }

    /**
     * Delete the specified item.
     *
     * @param Request  $request
     * 
     * @return Response
     */
    public function delete(Request $request)
    {
        $item = Item::findOrFail($request->input('id'));
        $item->delete();
        return response()->json([
            'status' => "success",
            'message' => trans('messages.controller.success.item.deleted'),
        ]);
    }
}
