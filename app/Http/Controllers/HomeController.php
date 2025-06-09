<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_active', true)
            ->withCount('favorites')
            ->orderBy('favorites_count', 'desc')
            ->take(8)
            ->get();

        return view('home', compact('featuredProducts'));
    }
}
