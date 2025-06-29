<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    public function __construct()
    {
        // Remove auth middleware to allow guest access
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->check()) {
            // For authenticated users, get from database
            $favorites = auth()->user()->favorites()
                ->with('product')
                ->paginate(12);
        } else {
            // For guest users, get from session
            $sessionFavorites = session('favorites', []);
            
            if (empty($sessionFavorites)) {
                $favorites = collect([]);
                // Show notification about empty favorites for guest users
                session()->flash('info', 'Anda belum memiliki produk favorit. Tambahkan produk ke favorit untuk melihatnya di sini. Login untuk melihat favorit yang tersimpan di akun Anda.');
            } else {
                $favorites = collect($sessionFavorites)->map(function ($favoriteData) {
                    return (object) $favoriteData;
                });
                
                // Show notification about session favorites
                if (!session()->has('favorites_notification_shown')) {
                    session()->flash('info', 'Favorit Anda disimpan sementara di browser. Login untuk menyimpan favorit secara permanen.');
                    session()->put('favorites_notification_shown', true);
                }
            }
        }

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
        if (auth()->check()) {
            // For authenticated users, save to database
            $user = auth()->user();
            
            if ($user->favorites()->where('product_id', $product->id)->exists()) {
                if (request()->expectsJson()) {
                    return response()->json(['error' => 'Produk sudah ada di favorit'], 400);
                }
                return back()->with('error', 'Produk sudah ada di favorit');
            }

            $user->favorites()->create([
                'product_id' => $product->id
            ]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produk berhasil ditambahkan ke favorit',
                    'count' => $user->favorites()->count()
                ]);
            }

            return back()->with('success', 'Produk berhasil ditambahkan ke favorit');
        } else {
            // For guest users, save to session
            $favorites = session('favorites', []);
            
            if (isset($favorites[$product->id])) {
                if (request()->expectsJson()) {
                    return response()->json(['error' => 'Produk sudah ada di favorit'], 400);
                }
                return back()->with('error', 'Produk sudah ada di favorit');
            }

            $favorites[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'slug' => $product->slug,
                'added_at' => now()
            ];

            session(['favorites' => $favorites]);

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produk berhasil ditambahkan ke favorit',
                    'count' => count($favorites)
                ]);
            }

            return back()->with('success', 'Produk berhasil ditambahkan ke favorit');
        }
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
    public function destroy($productId)
    {
        if (auth()->check()) {
            // For authenticated users, delete from database
            $user = auth()->user();
            $deleted = $user->favorites()->where('product_id', $productId)->delete();
            
            if ($deleted > 0) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Produk berhasil dihapus dari favorit',
                        'count' => $user->favorites()->count()
                    ]);
                }
                return back()->with('success', 'Produk berhasil dihapus dari favorit');
            } else {
                if (request()->expectsJson()) {
                    return response()->json(['error' => 'Produk tidak ditemukan di favorit'], 404);
                }
                return back()->with('error', 'Produk tidak ditemukan di favorit');
            }
        } else {
            // For guest users, delete from session
            $favorites = session('favorites', []);
            
            if (isset($favorites[$productId])) {
                unset($favorites[$productId]);
                session(['favorites' => $favorites]);
                
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Produk berhasil dihapus dari favorit',
                        'count' => count($favorites)
                    ]);
                }
                return back()->with('success', 'Produk berhasil dihapus dari favorit');
            } else {
                if (request()->expectsJson()) {
                    return response()->json(['error' => 'Produk tidak ditemukan di favorit'], 404);
                }
                return back()->with('error', 'Produk tidak ditemukan di favorit');
            }
        }
    }

    /**
     * Check if a product is in favorites
     */
    public function check(Product $product)
    {
        if (auth()->check()) {
            $isFavorite = auth()->user()->favorites()->where('product_id', $product->id)->exists();
        } else {
            $favorites = session('favorites', []);
            $isFavorite = isset($favorites[$product->id]);
        }

        return response()->json([
            'is_favorite' => $isFavorite,
            'product_id' => $product->id
        ]);
    }

    /**
     * Get favorites count
     */
    public function count()
    {
        if (auth()->check()) {
            $count = auth()->user()->favorites()->count();
        } else {
            $favorites = session('favorites', []);
            $count = count($favorites);
        }

        return response()->json([
            'count' => $count,
            'is_authenticated' => auth()->check()
        ]);
    }

    /**
     * Toggle favorite status via AJAX
     */
    public function toggle(Request $request, Product $product)
    {
        if (auth()->check()) {
            // For authenticated users
            $user = auth()->user();
            $existing = $user->favorites()->where('product_id', $product->id)->first();
            
            if ($existing) {
                $existing->delete();
                $isFavorite = false;
                $message = 'Produk berhasil dihapus dari favorit';
            } else {
                $user->favorites()->create(['product_id' => $product->id]);
                $isFavorite = true;
                $message = 'Produk berhasil ditambahkan ke favorit';
            }
            
            $count = $user->favorites()->count();
        } else {
            // For guest users
            $favorites = session('favorites', []);
            
            if (isset($favorites[$product->id])) {
                unset($favorites[$product->id]);
                $isFavorite = false;
                $message = 'Produk berhasil dihapus dari favorit';
            } else {
                $favorites[$product->id] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image,
                    'slug' => $product->slug,
                    'added_at' => now()
                ];
                $isFavorite = true;
                $message = 'Produk berhasil ditambahkan ke favorit';
            }
            
            session(['favorites' => $favorites]);
            $count = count($favorites);
        }

        return response()->json([
            'is_favorite' => $isFavorite,
            'message' => $message,
            'count' => $count
        ]);
    }

    /**
     * Clear favorites notification flag
     */
    public function clearNotification()
    {
        session()->forget('favorites_notification_shown');
        return response()->json(['success' => true]);
    }

    /**
     * Refresh product favorite counts
     */
    public function refreshProductCounts()
    {
        // Get all products with their favorites count
        $products = Product::withCount('favorites')->get();
        $counts = [];
        
        // Get session favorites
        $sessionFavorites = session('favorites', []);
        
        foreach ($products as $product) {
            $databaseCount = $product->favorites_count;
            $sessionCount = isset($sessionFavorites[$product->id]) ? 1 : 0;
            
            // If user is authenticated, check for duplicates
            if (auth()->check()) {
                $user = auth()->user();
                $hasInDatabase = $user->favorites()->where('product_id', $product->id)->exists();
                $hasInSession = isset($sessionFavorites[$product->id]);
                
                // If product is in both session and database, don't double count
                if ($hasInDatabase && $hasInSession) {
                    $sessionCount = 0;
                }
            }
            
            $counts[$product->id] = $databaseCount + $sessionCount;
        }
        
        return response()->json($counts);
    }

    /**
     * Get favorites count for a specific product
     */
    public function getProductCount(Product $product)
    {
        $count = \App\Helpers\FavoriteHelper::getTotalFavorites($product->id);
        
        return response()->json([
            'product_id' => $product->id,
            'count' => $count
        ]);
    }
}
