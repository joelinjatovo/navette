<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrder as StoreOrderRequest;
use App\Http\Resources\Order as OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * Store a new order.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreOrderRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $order = Order::create($validated);

        event(new \App\Events\OrderCreated($order));
        
        return new OrderResource($order);
    }
}
