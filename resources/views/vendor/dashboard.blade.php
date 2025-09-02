@extends('components.vendor')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Vendor Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <a href="{{ route('vendor.products.index') }}" class="bg-gradient-to-br from-gray-800 to-gray-900 text-white shadow-lg rounded-xl p-6 hover:shadow-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 transform hover:scale-105 border border-gray-700">
            <h2 class="text-lg font-semibold text-emerald-400">Manage Products</h2>
            <p class="text-gray-300 text-sm mt-2">View and manage your products</p>
        </a>
        <a href="{{ route('vendor.orders.index') }}" class="bg-gradient-to-br from-gray-800 to-gray-900 text-white shadow-lg rounded-xl p-6 hover:shadow-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 transform hover:scale-105 border border-gray-700">
            <h2 class="text-lg font-semibold text-emerald-400">Manage Orders</h2>
            <p class="text-gray-300 text-sm mt-2">View and manage your orders</p>
        </a>
    </div>
@endsection


