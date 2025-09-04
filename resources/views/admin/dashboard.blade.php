@extends('components.admin')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Dashboard</h1>
        <p class="text-gray-600">Welcome back! Here's what's happening with your store today.</p>
    </div>

    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-3xl font-bold text-gray-900">${{ number_format($totalRevenue ?? 0, 2) }}</p>
                    <p class="text-sm text-green-600 mt-1">+12% from last month</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Orders</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalOrders ?? 0 }}</p>
                    <p class="text-sm text-blue-600 mt-1">{{ $pendingOrders ?? 0 }} pending</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Products</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalProducts ?? 0 }}</p>
                    <p class="text-sm text-orange-600 mt-1">{{ $lowStockProducts ?? 0 }} low stock</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalUsers ?? 0 }}</p>
                    <p class="text-sm text-purple-600 mt-1">{{ $newUsersThisMonth ?? 0 }} this month</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Recent Orders</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">View all</a>
            </div>
            <div class="space-y-4">
                @forelse($recentOrders ?? [] as $order)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-semibold text-gray-900">Order #{{ $order->id }}</p>
                            <p class="text-sm text-gray-600">{{ $order->user->name ?? 'Guest' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">${{ number_format($order->total_amount, 2) }}</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                @elseif($order->status === 'delivered') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">No recent orders</p>
                @endforelse
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Low Stock Alert</h2>
                <a href="{{ route('admin.products.index') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">Manage products</a>
            </div>
            <div class="space-y-4">
                @forelse($lowStockItems ?? [] as $product)
                    <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg border border-red-200">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                            <p class="text-sm text-gray-600">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-red-600">{{ $product->stock }} left</p>
                            <p class="text-sm text-gray-600">${{ number_format($product->price, 2) }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">All products are well stocked</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Management Links -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <a href="{{ route('admin.users.index') }}" class="bg-gradient-to-br from-gray-800 to-gray-900 text-white shadow-lg rounded-xl p-6 hover:shadow-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 transform hover:scale-105 border border-gray-700">
            <h2 class="text-lg font-semibold text-emerald-400">Manage Users</h2>
            <p class="text-gray-300 text-sm mt-2">View and manage user accounts</p>
            <div class="mt-4 text-2xl font-bold text-white">{{ $totalUsers ?? 0 }}</div>
        </a>

        <a href="{{ route('admin.products.index') }}" class="bg-gradient-to-br from-gray-800 to-gray-900 text-white shadow-lg rounded-xl p-6 hover:shadow-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 transform hover:scale-105 border border-gray-700">
            <h2 class="text-lg font-semibold text-emerald-400">Manage Products</h2>
            <p class="text-gray-300 text-sm mt-2">Add, edit, and organize products</p>
            <div class="mt-4 text-2xl font-bold text-white">{{ $totalProducts ?? 0 }}</div>
        </a>

        <a href="{{ route('admin.categories.index') }}" class="bg-gradient-to-br from-gray-800 to-gray-900 text-white shadow-lg rounded-xl p-6 hover:shadow-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 transform hover:scale-105 border border-gray-700">
            <h2 class="text-lg font-semibold text-emerald-400">Manage Categories</h2>
            <p class="text-gray-300 text-sm mt-2">Organize product categories</p>
            <div class="mt-4 text-2xl font-bold text-white">{{ $totalCategories ?? 0 }}</div>
        </a>

        <a href="{{ route('admin.orders.index') }}" class="bg-gradient-to-br from-gray-800 to-gray-900 text-white shadow-lg rounded-xl p-6 hover:shadow-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 transform hover:scale-105 border border-gray-700">
            <h2 class="text-lg font-semibold text-emerald-400">Manage Orders</h2>
            <p class="text-gray-300 text-sm mt-2">Track and update order status</p>
            <div class="mt-4 text-2xl font-bold text-white">{{ $totalOrders ?? 0 }}</div>
        </a>
    </div>
@endsection
