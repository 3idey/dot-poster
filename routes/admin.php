<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', function () {
        $totalRevenue = \App\Models\Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $totalOrders = \App\Models\Order::count();
        $pendingOrders = \App\Models\Order::where('status', 'pending')->count();
        $totalProducts = \App\Models\Product::count();
        $lowStockProducts = \App\Models\Product::where('stock', '<=', 5)->count();
        $totalUsers = \App\Models\User::where('role', 'customer')->count();
        $newUsersThisMonth = \App\Models\User::where('role', 'customer')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $totalCategories = \App\Models\Category::count();
        
        $recentOrders = \App\Models\Order::with('user')
            ->latest()
            ->take(5)
            ->get();
            
        $lowStockItems = \App\Models\Product::with('category')
            ->where('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders', 
            'pendingOrders',
            'totalProducts',
            'lowStockProducts',
            'totalUsers',
            'newUsersThisMonth',
            'totalCategories',
            'recentOrders',
            'lowStockItems'
        ));
    })->name('dashboard');

    // Users
    Route::get('users', [AdminUserController::class, 'index'])->name('users.index');
    Route::match(['PATCH', 'POST'], 'users/{user}/ban', [AdminUserController::class, 'ban'])->name('users.ban');
    Route::match(['PATCH', 'POST'], 'users/{user}/unban', [AdminUserController::class, 'unban'])->name('users.unban');
    Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::patch('orders/{order}', [AdminOrderController::class, 'update'])->name('orders.update');
    Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

    // Products
    Route::get('products', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::match(['PATCH', 'PUT'], 'products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    // Categories
    Route::get('categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
});
