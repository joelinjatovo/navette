<?php

namespace App\Http\Controllers\Api\v1;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrder as StoreOrderRequest;
use App\Http\Resources\Order as OrderResource;
use App\Models\Order;
use App\Models\Phone;
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
        $data = $request->only(['place', 'preordered', 'privatized']);
        $data['vat'] = 0;
        $data['amount'] = 10;
        $data['currency'] = 'EUR';
        $data['subtotal'] = $data['place'] * $data['amount'];
        $data['total'] = $data['subtotal'] + $data['subtotal'] * $data['vat'];
        $order = Order::create($data);
        
        $data = $request->input('phone');
        $data['type'] = 'home';
        $data['phone'] = $data['phone_country_code'] . $data['phone_number'];
        $phone = Phone::create($data);
        $order->phones()->save($phone);

        event(new \App\Events\OrderCreated($order));
        
        return new OrderResource($order);
    }
}
