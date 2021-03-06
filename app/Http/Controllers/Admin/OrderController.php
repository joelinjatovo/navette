<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    
    /**
     * Show the list of all order
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $s = $request->get('s');
        if(!empty($s)){
            $s = '%'.$s.'%';
            $orders = Order::join('users', 'users.id', '=', 'orders.user_id')
						->join('clubs', 'clubs.id', '=', 'orders.club_id')
						->orWhere('clubs.name', 'LIKE', $s)
						->orWhere('users.name', 'LIKE', $s)
                        ->orWhere('users.phone', 'LIKE', $s)
                        ->orWhere('users.email', 'LIKE', $s)
						->with('user')
						->with('club')
                        ->paginate();
        }else{
	        $orders = Order::with('user')->with('club')->paginate();
        }
        
        return view('admin.order.index', ['models' => $orders]);
    }

    /**
     * Show the order info.
     *
     * @param Order $order
     * @return Response
     */
    public function show(Order $order)
    {
        return view('admin.order.show', ['model' => $order]);
    }

    /**
     * Show the order details.
     *
     * @param Order $order
     * @return Response
     */
    public function details(Order $order)
    {
        return view('admin.order.details', ['model' => $order]);
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
        $order = Order::findOrFail($request->input('id'));
		switch($request->input('action')){
			case 'cancel':
				if(!$order->isCancelable()){
					return response()->json([
						'status' => "error",
						'message' => trans('messages.controller.success.order.not.cancelable'),
					]);
				}

				$order->cancel($request->user());

				// @TODO Cancel order items
				
				return response()->json([
					'status' => "success",
					'message' => trans('messages.controller.success.order.canceled'),
					'view' => view('admin.order.table-row', ['model' => $order])->render(),
				]); 
			break;
		}
		
        return response()->json([
            'status' => "error",
            'message' => trans('messages.controller.success.order.unknown'),
        ]);
    }

    /**
     * Delete the specified order.
     *
     * @param Request  $request
     * 
     * @return Response
     */
    public function delete(Request $request)
    {
        $order = Order::findOrFail($request->input('id'));
        $order->delete();
        return response()->json([
            'status' => "success",
            'message' => trans('messages.controller.success.order.deleted'),
        ]);
    }
}
