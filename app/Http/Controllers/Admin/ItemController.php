<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Item as ItemResource;
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
            return new ItemResource($item);
        }
        return view('admin.item.show', ['model' => $item]);
    }

    /**
     * Handle specified action
     *
     * @param Request  $request
	 *
     * @return Response
     */
    public function action(Request $request)
    {
        $item = Item::findOrFail($request->input('id'));
		switch($request->input('action')){
			case 'cancel':
				if(!$item->isCancelable()){
					return response()->json([
						'status' => "error",
						'message' => trans('messages.controller.success.item.not.cancelable'),
					]);
				}

				$item->cancel();

				// Select next item
				/*
				$ride = $item->ride;
				if($ride){$ride->next();}
				*/
				
				return response()->json([
					'status' => "success",
					'message' => trans('messages.controller.success.item.canceled'),
					'view' => view('admin.item.table-row', ['model' => $item])->render(),
				]);
			break;
		}
		
        return response()->json([
            'status' => "error",
            'message' => trans('messages.controller.success.item.unknown'),
        ]);
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
