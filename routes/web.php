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
use App\Http\Controllers\InfoController;
use App\Http\Middleware\AdminMiddleware;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/info', [InfoController::class, 'index'])->name('info.index');

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

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Favorite routes
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{product}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{product}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // Admin routes
    Route::middleware([AdminMiddleware::class])->group(function () {
        // Product management
        Route::get('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/admin/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/admin/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/admin/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/admin/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        // Category management
        Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/admin/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        // Sales management
        Route::get('/admin/sales/create', [SaleController::class, 'create'])->name('sales.create');
        Route::post('/admin/sales', [SaleController::class, 'store'])->name('sales.store');
        Route::get('/admin/sales/{sale}/edit', [SaleController::class, 'edit'])->name('sales.edit');
        Route::put('/admin/sales/{sale}', [SaleController::class, 'update'])->name('sales.update');
        Route::delete('/admin/sales/{sale}', [SaleController::class, 'destroy'])->name('sales.destroy');

        // Admin index routes
        Route::get('/admin/products', [ProductController::class, 'adminIndex'])->name('admin.products.index');
        Route::get('/admin/categories', [CategoryController::class, 'adminIndex'])->name('admin.categories.index');
        Route::get('/admin/sales', [SaleController::class, 'adminIndex'])->name('admin.sales.index');

        // Admin dashboard
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // User management
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });
});
