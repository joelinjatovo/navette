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
     * Show the form to create a new order.
     *
     * @return Response
     */
    public function create()
    {
        $model = new Order();
        return view('admin.order.create', ['model' => $model]);
    }

    /**
     * Store a new order.
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
     * Show the form to edit specified order.
     *
     * @param Order $order
     * @return Response
     */
    public function edit(Order $order)
    {
        return view('admin.order.edit', ['model' => $order]);
    }

    /**
     * Update the specified order.
     *
     * @param Request  $request
     * @param Order $order
     * @return Response
     */
    public function update(Request $request, Order $order)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();
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
