<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Banner;

class HomeController extends Controller
{
    public function index()
    {
        // Get active banners for carousel
        $banners = Banner::active()->ordered()->get();
        
        // Get featured products
        $featuredProducts = Product::where('is_active', true)
            ->withCount('favorites')
            ->orderBy('favorites_count', 'desc')
            ->take(8)
            ->get();

        return view('home', compact('banners', 'featuredProducts'));
    }
}
