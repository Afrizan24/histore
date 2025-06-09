<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $quantity = $request->input('quantity', 1);

        if ($quantity > $product->stock) {
            return back()->with('error', 'Quantity exceeds available stock.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $quantity;
            if ($newQuantity > $product->stock) {
                return back()->with('error', 'Total quantity exceeds available stock.');
            }
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Product added to cart.');
    }

    public function update(Request $request, Product $product)
    {
        $quantity = $request->input('quantity');

        if ($quantity > $product->stock) {
            return back()->with('error', 'Quantity exceeds available stock.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $quantity;
            session()->put('cart', $cart);
            return back()->with('success', 'Cart updated successfully.');
        }

        return back()->with('error', 'Product not found in cart.');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session()->put('cart', $cart);
            return back()->with('success', 'Product removed from cart.');
        }

        return back()->with('error', 'Product not found in cart.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared successfully.');
    }
}
