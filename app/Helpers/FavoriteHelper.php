<?php

namespace App\Helpers;

use App\Models\Product;

class FavoriteHelper
{
    /**
     * Get total favorites count for a product (database + session)
     */
    public static function getTotalFavorites($productId)
    {
        // Get database favorites count
        $product = Product::find($productId);
        if (!$product) {
            return 0;
        }
        
        $databaseCount = $product->favorites()->count();
        
        // Get session favorites count for this product
        $sessionFavorites = session('favorites', []);
        $sessionCount = isset($sessionFavorites[$productId]) ? 1 : 0;
        
        // If user is authenticated, check if they have this product in session
        if (auth()->check()) {
            $user = auth()->user();
            $hasInDatabase = $user->favorites()->where('product_id', $productId)->exists();
            $hasInSession = isset($sessionFavorites[$productId]);
            
            // If product is in both session and database, don't double count
            if ($hasInDatabase && $hasInSession) {
                $sessionCount = 0;
            }
        }
        
        return $databaseCount + $sessionCount;
    }

    /**
     * Get total favorites count for all products (database + session)
     */
    public static function getAllTotalFavorites()
    {
        // Get all database favorites count
        $databaseCount = \App\Models\Favorite::count();
        
        // Get session favorites count
        $sessionFavorites = session('favorites', []);
        $sessionCount = count($sessionFavorites);
        
        // If user is authenticated, subtract duplicates
        if (auth()->check()) {
            $user = auth()->user();
            $userFavorites = $user->favorites()->pluck('product_id')->toArray();
            $sessionProductIds = array_keys($sessionFavorites);
            
            // Count duplicates (products that exist in both session and database for this user)
            $duplicates = count(array_intersect($userFavorites, $sessionProductIds));
            $sessionCount -= $duplicates;
        }
        
        return $databaseCount + $sessionCount;
    }
} 