<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sale;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $productCount = Product::count();
        $categoryCount = Category::count();
        $saleCount = Sale::count();
        $userCount = User::count();

        // Produk per kategori
        $productsPerCategory = Category::withCount('products')->get()->mapWithKeys(function($cat) {
            return [$cat->name => $cat->products_count];
        });

        // User growth dummy (bulan ini dan 5 bulan ke belakang)
        $userGrowth = [
            now()->subMonths(5)->format('M Y') => rand(1, 5),
            now()->subMonths(4)->format('M Y') => rand(2, 8),
            now()->subMonths(3)->format('M Y') => rand(3, 10),
            now()->subMonths(2)->format('M Y') => rand(5, 12),
            now()->subMonths(1)->format('M Y') => rand(7, 15),
            now()->format('M Y') => $userCount,
        ];

        // Sales aktif vs nonaktif
        $salesActive = Sale::where('is_active', true)->count();
        $salesInactive = Sale::where('is_active', false)->count();

        return view('admin.dashboard', compact(
            'productCount', 'categoryCount', 'saleCount', 'userCount',
            'productsPerCategory', 'userGrowth', 'salesActive', 'salesInactive'
        ));
    }
}
