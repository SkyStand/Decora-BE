<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the carts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $carts = $user->carts()->with('variant.product')->get();

        return response()->json($carts);
    }

    /**
     * Store a newly created cart item in storage.
     *
     * @param  \App\Http\Requests\StoreCartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCartRequest $request)
    {
        $validated = $request->validated();

        // Associate the cart with the authenticated user
        $validated['user_id'] = Auth::id();

        $cart = Cart::create($validated);

        return response()->json($cart, 201);
    }

    /**
     * Update the specified cart item in storage.
     *
     * @param  \App\Http\Requests\UpdateCartRequest  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        $validated = $request->validated();

        if ($cart->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $cart->update($validated);

        return response()->json($cart);
    }

    /**
     * Remove the specified cart item from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $cart->delete();

        return response()->json(null, 204);
    }
}
