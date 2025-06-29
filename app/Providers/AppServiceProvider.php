<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set pagination template to Bootstrap 5
        Paginator::useBootstrapFive();

        // Add helper function to check if product is in favorites
        Blade::if('isFavorite', function ($productId) {
            if (auth()->check()) {
                return auth()->user()->favorites()->where('product_id', $productId)->exists();
            } else {
                $favorites = session('favorites', []);
                return isset($favorites[$productId]);
            }
        });

        // Add helper function to get total favorites count for a product
        Blade::directive('totalFavorites', function ($productId) {
            return "<?php echo \App\Helpers\FavoriteHelper::getTotalFavorites($productId); ?>";
        });
    }
}
