@extends('components.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Categories</h1>
        <a href="{{ route('admin.categories.create') }}" class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-4 py-2 rounded-xl hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">Add Category</a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-3">ID</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Slug</th>
                    <th class="p-3">Parent</th>
                    <th class="p-3">Products Count</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="border-b">
                        <td class="p-3">{{ $category->id }}</td>
                        <td class="p-3">{{ $category->name }}</td>
                        <td class="p-3">{{ $category->slug }}</td>
                        <td class="p-3">{{ $category->parent?->name ?? 'None' }}</td>
                        <td class="p-3">{{ $category->products()->count() }}</td>
                        <td class="p-3">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="bg-gradient-to-r from-amber-500 to-amber-600 text-white px-3 py-1 rounded-xl hover:from-amber-600 hover:to-amber-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 mr-2">Edit</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-gradient-to-r from-red-600 to-red-700 text-white px-3 py-1 rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $categories->links() }}
    </div>
@endsection
