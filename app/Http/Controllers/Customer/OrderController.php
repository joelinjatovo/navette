<?php

namespace App\Http\Controllers\Customer;

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
    public function index()
    {
        $orders = Order::paginate();
        
        return view('customer.order.index', ['models' => $orders]);
    }

    /**
     * Show the order info.
     *
     * @param Order $order
     * @return Response
     */
    public function show(Order $order)
    {
        return view('customer.order.show', ['model' => $order]);
    }
    
    /**
     * Show the form to create a new order.
     *
     * @return Response
     */
    public function create()
    {
        $model = new Order();
        return view('customer.order.create', ['model' => $model]);
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
        return view('customer.order.edit', ['model' => $order]);
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
     * @param Order $order
     * @return Response
     */
    public function delete(Order $order)
    {
        $club->delete();

        return response()->json([
            'code' => 200,
            'status' => "success",
        ]);
    }
}
