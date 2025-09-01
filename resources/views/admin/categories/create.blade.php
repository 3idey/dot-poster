@extends('components.admin')

@section('content')
    <div class="max-w-2xl mx-auto bg-white shadow rounded-lg p-6">
        <h1 class="text-xl font-semibold mb-4">Create Category</h1>

        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf

            {{-- Name --}}
            <div class="mb-4">
                <label for="name" class="block font-medium">Name</label>
                <input type="text" name="name" id="name" class="w-full border rounded p-2" value="{{ old('name') }}" required>
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Parent Category --}}
            <div class="mb-4">
                <label for="parent_id" class="block font-medium">Parent Category</label>
                <select name="parent_id" id="parent_id" class="w-full border rounded p-2">
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
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Create Category</button>
            <a href="{{ route('admin.categories.index') }}" class="ml-2 text-gray-600">Cancel</a>
        </form>
    </div>
@endsection
