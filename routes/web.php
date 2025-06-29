<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Api\SalesController;
use App\Http\Controllers\InfoController;
use App\Http\Middleware\AdminMiddleware;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/info', [InfoController::class, 'index'])->name('info.index');

// API routes
Route::get('/api/sales', [SalesController::class, 'index'])->name('api.sales.index');
Route::get('/api/sales/{id}', [SalesController::class, 'show'])->name('api.sales.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.all');
Route::get('/products/category/{category:slug}', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Sales routes
Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
Route::post('/sales/{sale}/chat', [SaleController::class, 'chat'])->name('sales.chat');

// Favorite routes (available for both guests and authenticated users)
Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
Route::post('/favorites/{product}', [FavoriteController::class, 'store'])->name('favorites.store');
Route::delete('/favorites/{product}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
Route::get('/favorites/{product}/check', [FavoriteController::class, 'check'])->name('favorites.check');
Route::get('/favorites/count', [FavoriteController::class, 'count'])->name('favorites.count');
Route::get('/favorites/{product}/count', [FavoriteController::class, 'getProductCount'])->name('favorites.product-count');
Route::post('/favorites/{product}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
Route::post('/favorites/clear-notification', [FavoriteController::class, 'clearNotification'])->name('favorites.clear-notification');
Route::get('/favorites/refresh-product-counts', [FavoriteController::class, 'refreshProductCounts'])->name('favorites.refresh-product-counts');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Admin routes
    Route::middleware([AdminMiddleware::class])->group(function () {
        // Product management
        Route::get('/admin/products', [ProductController::class, 'adminIndex'])->name('admin.products.index');
        Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin.products.create');
        Route::post('/admin/products', [ProductController::class, 'store'])->name('admin.products.store');
        Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
        Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

        // Category management
        Route::get('/admin/categories', [CategoryController::class, 'adminIndex'])->name('admin.categories.index');
        Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');
        
        // Advanced category features
        Route::post('/admin/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('admin.categories.toggle-status');
        Route::post('/admin/categories/bulk-action', [CategoryController::class, 'bulkAction'])->name('admin.categories.bulk-action');
        Route::get('/admin/categories/statistics', [CategoryController::class, 'statistics'])->name('admin.categories.statistics');
        Route::get('/admin/categories/export', [CategoryController::class, 'export'])->name('admin.categories.export');
        Route::post('/admin/categories/import', [CategoryController::class, 'import'])->name('admin.categories.import');
        
        // Category API routes
        Route::get('/api/categories', [CategoryController::class, 'apiIndex'])->name('api.categories.index');
        Route::get('/api/categories/{category}', [CategoryController::class, 'apiShow'])->name('api.categories.show');

        // Sales management
        Route::get('/admin/sales', [SaleController::class, 'adminIndex'])->name('admin.sales.index');
        Route::get('/admin/sales/create', [SaleController::class, 'create'])->name('admin.sales.create');
        Route::post('/admin/sales', [SaleController::class, 'store'])->name('admin.sales.store');
        Route::get('/admin/sales/{sale}/edit', [SaleController::class, 'edit'])->name('admin.sales.edit');
        Route::put('/admin/sales/{sale}', [SaleController::class, 'update'])->name('admin.sales.update');
        Route::delete('/admin/sales/{sale}', [SaleController::class, 'destroy'])->name('admin.sales.destroy');
        Route::post('/admin/sales/{sale}/toggle-active', [SaleController::class, 'toggleActive'])->name('admin.sales.toggle-active');
        Route::post('/admin/sales/{sale}/reset-chats', [SaleController::class, 'resetDailyChats'])->name('admin.sales.reset-chats');
        Route::delete('/admin/sales/{sale}/chats/{chat}', [SaleController::class, 'deleteChat'])->name('admin.sales.chat.delete');
        Route::get('/admin/sales/{sale}/chats', [SaleController::class, 'adminChats'])->name('admin.sales.chats');

        // Banner management
        Route::resource('admin/banners', BannerController::class, ['as' => 'admin']);

        // Admin dashboard
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // User management
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });
});
