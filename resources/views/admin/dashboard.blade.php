@extends('components.admin')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <a href="{{ route('admin.users.index') }}" class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition">
            <h2 class="text-lg font-semibold">Manage Users</h2>
        </a>

        <a href="{{ route('admin.products.index') }}" class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition">
            <h2 class="text-lg font-semibold">Manage Products</h2>
        </a>

        <a href="{{ route('admin.categories.index') }}" class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition">
            <h2 class="text-lg font-semibold">Manage Categories</h2>
        </a>

        <a href="{{ route('admin.orders.index') }}" class="bg-white shadow rounded-lg p-6 hover:shadow-lg transition">
            <h2 class="text-lg font-semibold">Manage Orders</h2>
        </a>
    
    </div>
@endsection
