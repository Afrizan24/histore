<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return redirect()->route('products.index', ['category' => $category->slug]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category with existing products. Please move or delete the products first.');
        }

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    /**
     * Admin index with advanced features
     */
    public function adminIndex(Request $request)
    {
        $query = Category::withCount('products');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'products_desc':
                    $query->orderBy('products_count', 'desc');
                    break;
                case 'products_asc':
                    $query->orderBy('products_count', 'asc');
                    break;
                case 'newest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                default:
                    $query->orderBy('name', 'asc');
            }
        } else {
            $query->orderBy('name', 'asc');
        }

        $categories = $query->paginate(20);

        // Calculate statistics
        $totalProducts = Product::count();
        $avgProductsPerCategory = $categories->total() > 0 ? round($totalProducts / $categories->total(), 1) : 0;

        return view('admin.categories.index', compact('categories', 'totalProducts', 'avgProductsPerCategory'));
    }

    /**
     * Toggle category status
     */
    public function toggleStatus(Request $request, Category $category)
    {
        $category->update(['is_active' => $request->is_active]);

        return response()->json([
            'success' => true,
            'message' => 'Category status updated successfully',
            'is_active' => $category->is_active
        ]);
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id'
        ]);

        $categories = Category::whereIn('id', $validated['category_ids']);

        switch ($validated['action']) {
            case 'activate':
                $categories->update(['is_active' => true]);
                $message = 'Categories activated successfully.';
                break;
            case 'deactivate':
                $categories->update(['is_active' => false]);
                $message = 'Categories deactivated successfully.';
                break;
            case 'delete':
                // Check if any category has products
                $categoriesWithProducts = $categories->whereHas('products')->count();
                if ($categoriesWithProducts > 0) {
                    return redirect()->back()->with('error', 'Cannot delete categories with existing products.');
                }
                
                // Delete images
                $categories->get()->each(function($category) {
                    if ($category->image) {
                        Storage::disk('public')->delete($category->image);
                    }
                });
                
                $categories->delete();
                $message = 'Categories deleted successfully.';
                break;
        }

        return redirect()->route('admin.categories.index')->with('success', $message);
    }

    /**
     * Get category statistics
     */
    public function statistics()
    {
        $stats = [
            'total_categories' => Category::count(),
            'active_categories' => Category::where('is_active', true)->count(),
            'total_products' => Product::count(),
            'categories_with_products' => Category::has('products')->count(),
            'top_categories' => Category::withCount('products')
                ->orderBy('products_count', 'desc')
                ->take(5)
                ->get(),
            'recent_categories' => Category::latest()->take(5)->get(),
            'products_per_category' => Category::withCount('products')
                ->get()
                ->pluck('products_count')
                ->avg()
        ];

        return response()->json($stats);
    }

    /**
     * Export categories
     */
    public function export(Request $request)
    {
        $categories = Category::withCount('products')->get();
        
        $filename = 'categories_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($categories) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, ['ID', 'Name', 'Slug', 'Description', 'Products Count', 'Status', 'Created At']);
            
            // Add data
            foreach ($categories as $category) {
                fputcsv($file, [
                    $category->id,
                    $category->name,
                    $category->slug,
                    $category->description,
                    $category->products_count,
                    $category->is_active ? 'Active' : 'Inactive',
                    $category->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import categories from CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048'
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        
        $imported = 0;
        $errors = [];

        if (($handle = fopen($path, 'r')) !== FALSE) {
            // Skip header row
            fgetcsv($handle);
            
            while (($data = fgetcsv($handle)) !== FALSE) {
                try {
                    if (count($data) >= 3) {
                        $name = trim($data[0]);
                        $description = trim($data[1] ?? '');
                        $isActive = strtolower(trim($data[2] ?? 'true')) === 'true';
                        
                        if (!empty($name)) {
                            Category::create([
                                'name' => $name,
                                'slug' => Str::slug($name),
                                'description' => $description,
                                'is_active' => $isActive
                            ]);
                            $imported++;
                        }
                    }
                } catch (\Exception $e) {
                    $errors[] = "Row " . ($imported + 2) . ": " . $e->getMessage();
                }
            }
            fclose($handle);
        }

        $message = "Successfully imported {$imported} categories.";
        if (!empty($errors)) {
            $message .= " Errors: " . implode(', ', $errors);
        }

        return redirect()->route('admin.categories.index')
            ->with('success', $message);
    }

    /**
     * Get categories for API
     */
    public function apiIndex()
    {
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    /**
     * Get category details for API
     */
    public function apiShow(Category $category)
    {
        $category->load(['products' => function($query) {
            $query->where('is_active', true);
        }]);

        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }
}
