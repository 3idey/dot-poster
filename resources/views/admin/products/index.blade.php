@extends('components.admin')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Products Management</h1>

    <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Add Product</a>

    <table class="w-full bg-white shadow-md rounded-lg mt-4">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="p-3">ID</th>
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
                    <td class="p-3">{{ $product->name }}</td>
                    <td class="p-3">${{ $product->price }}</td>
                    <td class="p-3">{{ $product->stock }}</td>
                    <td class="p-3 space-x-2">
                        <a href="{{ route('admin.products.edit', $product) }}"
                            class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 text-white px-3 py-1 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-3"> {{ $products->links() }}</div>
@endsection
