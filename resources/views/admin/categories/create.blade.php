@extends('components.admin')

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-6">
        <h1 class="text-xl font-semibold mb-4">Create Category</h1>

        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf

            {{-- Name --}}
            <div class="mb-4">
                <label for="name" class="block font-medium">Name</label>
                <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors" value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Parent Category --}}
            <div class="mb-4">
                <label for="parent_id" class="block font-medium">Parent Category</label>
                <select name="parent_id" id="parent_id" class="w-full border border-gray-300 rounded-lg p-3 bg-gray-50 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    <option value="">-- No Parent (Root Category) --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <button type="submit" class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-4 py-2 rounded-xl hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">Create Category</button>
            <a href="{{ route('admin.categories.index') }}" class="ml-2 px-4 py-2 rounded-xl border border-gray-400 text-gray-700 hover:bg-gray-100 transition-all duration-300">Cancel</a>
        </form>
    </div>
@endsection
