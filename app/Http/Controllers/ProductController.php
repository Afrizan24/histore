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
     * Generate unique slug for product
     */
    private function generateUniqueSlug($name, $excludeId = null)
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        // If base slug is empty, use a default
        if (empty($baseSlug)) {
            $baseSlug = 'product';
            $slug = $baseSlug;
        }

        while (true) {
            $query = Product::where('slug', $slug);

            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }

            if (!$query->exists()) {
                break;
            }

            $slug = $baseSlug . '-' . $counter;
            $counter++;

            // Prevent infinite loop
            if ($counter > 100) {
                $slug = $baseSlug . '-' . time();
                break;
            }
        }

        return $slug;
    }

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
            $query->where(function ($q) use ($search) {
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

        // Filter by stock status
        if ($request->has('stock') && $request->stock !== '' && $request->stock !== 'all') {
            switch ($request->stock) {
                case 'in_stock':
                    $query->where('stock', '>', 5);
                    break;
                case 'low_stock':
                    $query->where('stock', '>', 0)->where('stock', '<=', 5);
                    break;
                case 'out_of_stock':
                    $query->where('stock', 0);
                    break;
            }
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
            'stock' => 'required|integer|min:0',
            'warna' => 'required|string|max:50',
            'kondisi' => 'required|in:New,Second',
            'storage' => 'nullable|string|max:50',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = $this->generateUniqueSlug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        // Get sales data for testing
        $sales = \App\Models\Sale::where('is_active', true)
            ->select('id', 'name', 'whatsapp as phone', 'email', 'description')
            ->orderBy('name')
            ->get();

        return view('products.show', compact('product', 'relatedProducts', 'sales'));
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
        // Debug: Log request data
        \Log::info('Update Product Request', [
            'product_id' => $product->id,
            'has_image' => $request->hasFile('image'),
            'image_size' => $request->hasFile('image') ? $request->file('image')->getSize() : 'no file',
            'image_mime' => $request->hasFile('image') ? $request->file('image')->getMimeType() : 'no file',
            'all_data' => $request->all()
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'warna' => 'required|string|max:50',
            'kondisi' => 'required|in:New,Second',
            'storage' => 'nullable|string|max:50',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean'
        ]);

        // Generate unique slug
        $validated['slug'] = $this->generateUniqueSlug($validated['name'], $product->id);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            try {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $validated['image'] = $request->file('image')->store('products', 'public');

                // Debug: Log successful upload
                \Log::info('Image uploaded successfully', [
                    'old_image' => $product->image,
                    'new_image' => $validated['image']
                ]);
            } catch (\Exception $e) {
                // Debug: Log upload error
                \Log::error('Image upload failed', [
                    'error' => $e->getMessage(),
                    'file' => $request->file('image')->getClientOriginalName()
                ]);

                return back()->withErrors(['image' => 'Gagal mengupload gambar: ' . $e->getMessage()]);
            }
        }

        try {
            $product->update($validated);

            // Debug: Log successful update
            \Log::info('Product updated successfully', [
                'product_id' => $product->id,
                'updated_fields' => array_keys($validated)
            ]);

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil diperbarui.');
        } catch (\Exception $e) {
            // Debug: Log update error
            \Log::error('Product update failed', [
                'error' => $e->getMessage(),
                'product_id' => $product->id
            ]);

            return back()->withErrors(['general' => 'Gagal memperbarui produk: ' . $e->getMessage()]);
        }
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
            ->with('success', 'Produk berhasil dihapus.');
    }

    public function adminIndex(Request $request)
    {
        $query = Product::with(['category', 'favorites']);

        // Search functionality
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category !== '') {
            $query->where('category_id', $request->category);
        }

        // Filter by condition
        if ($request->has('condition') && $request->condition !== '') {
            $query->where('kondisi', $request->condition);
        }

        // Filter by stock status
        if ($request->has('stock') && $request->stock !== '') {
            switch ($request->stock) {
                case 'in_stock':
                    $query->where('stock', '>', 5);
                    break;
                case 'low_stock':
                    $query->where('stock', '>', 0)->where('stock', '<=', 5);
                    break;
                case 'out_of_stock':
                    $query->where('stock', 0);
                    break;
            }
        }

        // Sort
        if ($request->has('sort') && $request->sort !== '') {
            switch ($request->sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                case 'popular':
                    $query->withCount('favorites')->orderBy('favorites_count', 'desc');
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(15);

        // Get categories for filter dropdown
        $categories = Category::orderBy('name')->get();

        // Debug information
        if ($request->has('debug')) {
            \Log::info('Admin Products Query Debug', [
                'search' => $request->search ?? 'none',
                'category' => $request->category ?? 'none',
                'condition' => $request->condition ?? 'none',
                'total_products' => $products->total(),
                'current_page' => $products->currentPage(),
                'per_page' => $products->perPage(),
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings()
            ]);
        }

        return view('admin.products.index', compact('products', 'categories'));
    }
}
