@extends('components.vendor')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Create New Product</h1>
                <a href="{{ route('vendor.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition-colors">
                    ← Back to Products
                </a>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Product Information</h2>
                    <p class="text-gray-600 mt-1">Fill in the details below to create a new product</p>
                </div>
                
                <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Product Name *</label>
                                <input type="text" name="name" id="name" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror" 
                                    value="{{ old('name') }}" placeholder="Enter product name" required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">Price ($) *</label>
                                    <input type="number" step="0.01" min="0" name="price" id="price" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('price') border-red-500 @enderror" 
                                        value="{{ old('price') }}" placeholder="0.00" required>
                                    @error('price')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">Stock Quantity *</label>
                                    <input type="number" min="0" name="stock" id="stock" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('stock') border-red-500 @enderror" 
                                        value="{{ old('stock') }}" placeholder="0" required>
                                    @error('stock')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description *</label>
                                <textarea name="description" id="description" rows="5" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none @error('description') border-red-500 @enderror" 
                                    placeholder="Describe your product..." required>{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Category *</label>
                                    <select name="category_id" id="category_id" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('category_id') border-red-500 @enderror" required>
                                        <option value="">Choose category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status *</label>
                                    <select name="status" id="status" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('status') border-red-500 @enderror" required>
                                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Column - Image Upload -->
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Product Image *</label>
                                <input type="file" name="image" id="image" accept="image/*" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('image') border-red-500 @enderror" 
                                    required onchange="previewImage(this)">
                                <div id="image-preview" class="mt-4 hidden">
                                    <img id="preview-img" src="#" alt="Preview" class="max-h-64 mx-auto rounded-lg border border-gray-200">
                                    <button type="button" onclick="removeImage()" class="mt-2 text-red-600 text-sm hover:underline">Remove image</button>
                                </div>
                                <script>
                                function previewImage(input) {
                                    if (input.files && input.files[0]) {
                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            document.getElementById('preview-img').src = e.target.result;
                                            document.getElementById('image-preview').classList.remove('hidden');
                                        };
                                        reader.readAsDataURL(input.files[0]);
                                    }
                                }
                                
                                function removeImage() {
                                    document.getElementById('image').value = '';
                                    document.getElementById('image-preview').classList.add('hidden');
                                }
                                </script>
                                @error('image')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h3 class="text-sm font-semibold text-blue-800 mb-2">Image Guidelines</h3>
                                <ul class="text-sm text-blue-700 space-y-1">
                                    <li>• Use high-quality images (minimum 800x600px)</li>
                                    <li>• Supported formats: JPEG, PNG, GIF</li>
                                    <li>• Maximum file size: 2MB</li>
                                    <li>• Square images work best for product listings</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center pt-8 border-t border-gray-200 mt-8">
                        <a href="{{ route('vendor.products.index') }}" 
                            class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                            class="inline-flex items-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Create Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
