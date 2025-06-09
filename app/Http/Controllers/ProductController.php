<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'favorites']);

        // Filter by category
        $categorySlug = $request->route('category');
        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Search
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price !== '') {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price !== '') {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by series
        if ($request->has('series') && $request->series !== '') {
            $query->where('name', 'like', "%{$request->series}%");
        }

        // Filter by color
        if ($request->has('warna') && $request->warna !== '' && $request->warna !== 'all') {
            $query->where('warna', $request->warna);
        }

        // Filter by condition
        if ($request->has('kondisi') && $request->kondisi !== '' && $request->kondisi !== 'all') {
            $query->where('kondisi', $request->kondisi);
        }

        // Filter by storage
        if ($request->has('storage') && $request->storage !== '' && $request->storage !== 'all') {
            $query->where('storage', $request->storage);
        }

        // Sort
        if ($request->has('sort') && $request->sort !== '') {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->latest();
                    break;
                case 'popular':
                    $query->withCount('favorites')->orderBy('favorites_count', 'desc');
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12);

        // Get unique values for filters based on current category only
        $baseQuery = Product::query();
        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $baseQuery->where('category_id', $category->id);
            }
        }

        // Get all available colors for current category
        $colors = (clone $baseQuery)->distinct()->pluck('warna');

        // Get all available conditions for current category
        $conditions = (clone $baseQuery)->distinct()->pluck('kondisi');

        // Get all available storages for current category
        $storages = (clone $baseQuery)->distinct()->pluck('storage');

        $currentCategory = null;
        if ($categorySlug) {
            $currentCategory = Category::where('slug', $categorySlug)->first();
        }

        return view('products.index', compact('products', 'colors', 'conditions', 'storages', 'currentCategory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'warna' => 'required|string|max:50',
            'kondisi' => 'required|in:New,Second',
            'storage' => 'required|string|max:50',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'favorites']);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'warna' => 'required|string|max:50',
            'kondisi' => 'required|in:New,Second',
            'storage' => 'required|string|max:50',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function adminIndex()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }
}
