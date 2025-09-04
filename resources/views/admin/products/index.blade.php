@extends('components.admin')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Products Management</h1>

    <table class="w-full bg-white shadow-md rounded-lg mt-4">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="p-3">ID</th>
                <th class="p-3">Image</th>
                <th class="p-3">Name</th>
                <th class="p-3">Price</th>
                <th class="p-3">Stock</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr class="border-b">
                    <td class="p-3">{{ $product->id }}</td>
                    <td class="p-3"><img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-24 h-24 object-cover"></td>
                    <td class="p-3">{{ $product->name }}</td>
                    <td class="p-3">${{ $product->price }}</td>
                    <td class="p-3">{{ $product->stock }}</td>
                    <td class="p-3 space-x-2">
                        <a href="{{ route('admin.products.edit', $product) }}"
                            class="bg-gradient-to-r from-amber-500 to-amber-600 text-white px-3 py-1 rounded-xl hover:from-amber-600 hover:to-amber-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="bg-gradient-to-r from-red-600 to-red-700 text-white px-3 py-1 rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-3"> {{ $products->links() }}</div>
@endsection
