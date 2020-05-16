<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Show cart details
     *
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request)
    {
        if (!$request->session()->has('cart')) {
            // redirect to shop order form
            return redirect()->route('shop.order')
                ->with('error', "Votre panier est vide. Veuillez passer votre commande!");
        }
        
        return view('shop.cart', ['cart' => $request->session()->get('cart')]);
    }
    
    /**
     * Clear cart
     *
     * @param Request $request
     *
     * @return View
     */
    public function clear(Request $request)
    {
        // Deleting Cart
        $request->session()->forget('cart');
        
        return redirect()->route('shop.order')
            ->with('success', "Votre panier est maintenant vide!");
    }
}
