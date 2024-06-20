<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('variant.product')->get();
        return response()->json($carts);
    }

    public function store(StoreCartRequest $request)
    {
        $validated = $request->validated();

        $cart = Cart::create($validated);

        return response()->json($cart, 201);
    }

    public function update(UpdateCartRequest $request, Cart $cart)
    {
        $validated = $request->validated();

        $cart->update($validated);

        return response()->json($cart);
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return response()->json(null, 204);
    }
}
