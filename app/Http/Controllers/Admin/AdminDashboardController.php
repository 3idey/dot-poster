<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock', '<=', 5)->count();
        $totalUsers = User::where('role', 'customer')->count();
        $newUsersThisMonth = User::where('role', 'customer')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $totalCategories = Category::count();
        
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();
            
        $lowStockItems = Product::with('category')
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
    }
}
