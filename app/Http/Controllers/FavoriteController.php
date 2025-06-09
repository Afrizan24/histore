<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favorites = auth()->user()->favorites()
            ->with('product')
            ->paginate(12);

        return view('favorites.index', compact('favorites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Product $product)
    {
        $user = auth()->user();
        
        if ($user->favorites()->where('product_id', $product->id)->exists()) {
            return back()->with('error', 'Produk sudah ada di favorit');
        }

        $user->favorites()->create([
            'product_id' => $product->id
        ]);

        return back()->with('success', 'Produk berhasil ditambahkan ke favorit');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $user = auth()->user();
        $user->favorites()->where('product_id', $product->id)->delete();

        return back()->with('success', 'Produk berhasil dihapus dari favorit');
    }
}
