<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Show payment gateways
     *
     * @param Request $request
     *
     * @return View
     */
    public function checkout(Request $request)
    {
        if (!$request->session()->has('cart')) {
            // redirect to shop order form
            return redirect()->route('shop.order')
                ->with('error', "Votre panier est vide. Veuillez passer votre commande!");
        }
        
        return view('shop.checkout', ['gateways' => ['cash', 'stripe']]);
    }
}
