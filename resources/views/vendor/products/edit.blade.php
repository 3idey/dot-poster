@extends('components.vendor')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Edit Product</h1>
                <a href="{{ route('vendor.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition-colors">
                    ← Back to Products
                </a>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-8 py-6 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800">Product Information</h2>
                    <p class="text-gray-600 mt-1">Update the details below to modify your product</p>
                </div>
                
                <form action="{{ route('vendor.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Product Name *</label>
                                <input type="text" name="name" id="name" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror" 
                                    value="{{ old('name', $product->name) }}" placeholder="Enter product name" required>
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
                                        value="{{ old('price', $product->price) }}" placeholder="0.00" required>
                                    @error('price')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">Stock Quantity *</label>
                                    <input type="number" min="0" name="stock" id="stock" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('stock') border-red-500 @enderror" 
                                        value="{{ old('stock', $product->stock) }}" placeholder="0" required>
                                    @error('stock')
                                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description *</label>
                                <textarea name="description" id="description" rows="5" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none @error('description') border-red-500 @enderror" 
                                    placeholder="Describe your product..." required>{{ old('description', $product->description) }}</textarea>
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
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                        <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>Inactive</option>
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
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Product Image</label>
                                
                                <!-- Current Image Display -->
                                @if($product->image && file_exists(storage_path('app/public/' . $product->image)))
                                    <div id="current-image" class="mb-4">
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                            alt="{{ $product->name }}" 
                                            class="w-full h-64 object-cover rounded-lg border-2 border-gray-200 shadow-sm"
                                            onerror="this.parentElement.style.display='none';">
                                        <p class="text-sm text-gray-500 mt-2">Current image</p>
                                        <button type="button" id="change-image-btn" class="mt-2 text-sm text-blue-600 hover:text-blue-800">Change image</button>
                                    </div>
                                @endif
                                
                                <!-- New Image Preview -->
                                <div id="image-preview" class="hidden mb-4">
                                    <img id="preview-img" src="" alt="Preview" class="w-full h-64 object-cover rounded-lg border-2 border-dashed border-gray-300">
                                    <button type="button" id="remove-image" class="mt-2 text-sm text-red-600 hover:text-red-800">Remove new image</button>
                                </div>
                                
                                <!-- Upload Area -->
                                <div id="upload-area" class="{{ $product->image && file_exists(storage_path('app/public/' . $product->image)) ? 'hidden' : '' }} border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition-colors cursor-pointer">
                                    <input type="file" name="image" id="image" class="hidden" accept="image/*">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p class="text-gray-600 font-medium">{{ $product->image ? 'Click to change image' : 'Click to upload image' }}</p>
                                    <p class="text-gray-400 text-sm mt-1">PNG, JPG, GIF up to 2MB</p>
                                </div>
                                
                                @error('image')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                                
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-4">
                                    <h3 class="text-sm font-semibold text-blue-800 mb-2">Image Guidelines</h3>
                                    <ul class="text-sm text-blue-700 space-y-1">
                                        <li>• Use high-quality images (minimum 800x600px)</li>
                                        <li>• Supported formats: JPEG, PNG, GIF</li>
                                        <li>• Maximum file size: 2MB</li>
                                        <li>• Square images work best for product listings</li>
                                        <li>• Leave empty to keep current image</li>
                                    </ul>
                                </div>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadArea = document.getElementById('upload-area');
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');
            const removeBtn = document.getElementById('remove-image');
            const currentImage = document.getElementById('current-image');
            const changeImageBtn = document.getElementById('change-image-btn');

            // Handle upload area click
            uploadArea.addEventListener('click', () => imageInput.click());
            
            // Handle change image button click
            if (changeImageBtn) {
                changeImageBtn.addEventListener('click', () => {
                    uploadArea.classList.remove('hidden');
                    currentImage.classList.add('hidden');
                });
            }

            // Handle file input change
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        imagePreview.classList.remove('hidden');
                        uploadArea.classList.add('hidden');
                        if (currentImage) {
                            currentImage.classList.add('hidden');
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Handle remove new image
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    imageInput.value = '';
                    imagePreview.classList.add('hidden');
                    if (currentImage) {
                        currentImage.classList.remove('hidden');
                        uploadArea.classList.add('hidden');
                    } else {
                        uploadArea.classList.remove('hidden');
                    }
                });
            }

            // Drag and drop functionality
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.classList.add('border-blue-400', 'bg-blue-50');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-blue-400', 'bg-blue-50');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('border-blue-400', 'bg-blue-50');
                
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    imageInput.files = files;
                    const event = new Event('change', { bubbles: true });
                    imageInput.dispatchEvent(event);
                }
            });
        });
    </script>
@endsection
