@extends('components.admin')
@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-6">
        <h1 class="text-xl font-semibold mb-4">Create Product</h1>

        <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="mb-4">
                <label for="name" class="block font-medium">Name</label>
                <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                    value="{{ old('name', $product->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Price --}}
            <div class="mb-4">
                <label for="price" class="block font-medium">Price</label>
                <input type="number" name="price" id="price" step="0.01" class="w-full border border-gray-300 rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                    value="{{ old('price', $product->price) }}" required>
                @error('price')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Stock --}}
            <div class="mb-4">
                <label for="stock" class="block font-medium">Stock</label>
                <input type="number" name="stock" id="stock" min="0" class="w-full border border-gray-300 rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                    value="{{ old('stock', $product->stock  ) }}" required>
                @error('stock')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
          

            {{-- Status --}}
            <div class="mb-4">
                <label for="status" class="block font-medium">Status</label>
                <select name="status" id="status" class="w-full border border-gray-300 rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors" required>
                    <option value="1" {{ old('status', $product->status) == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('status', $product->status) == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            {{-- Category --}}
            <div class="mb-4">
                <label for="category_id" class="block font-medium">Category</label>
                <select name="category_id" id="category_id" class="w-full border border-gray-300 rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors" required>
                    <option value="">-- Select Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>


            {{-- Description --}}
            <div class="mb-4">
                <label for="description" class="block font-medium">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full border border-gray-300 rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label for="image" class="block font-medium">Image</label>
                <input type="file" name="image" id="image" class="w-full border border-gray-300 rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors" accept="image/*">
                @error('image')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-4 py-2 rounded-xl hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                Save Product
            </button>
        </form>
    </div>
@endsection
