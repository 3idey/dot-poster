@extends('components.admin')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Users Management</h1>

    <table class="w-full bg-white shadow-md rounded-lg">
        <thead>
            <tr class="bg-gray-200 text-left">
                <th class="p-3">ID</th>
                <th class="p-3">Name</th>
                <th class="p-3">Email</th>
                <th class="p-3">Status</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr class="border-b">
                    <td class="p-3">{{ $user->id }}</td>
                    <td class="p-3">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3">{{ $user->is_banned ? 'banned' : 'active' }}</td>
                    <td class="p-3 space-x-2">
                        @if (!$user->is_banned)
                            <form action="{{ route('admin.users.ban', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button class="bg-red-600 text-white px-3 py-1 rounded">Ban</button>
                            </form>
                        @else
                            <form action="{{ route('admin.users.unban', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button class="bg-green-600 text-white px-3 py-1 rounded">Unban</button>
                            </form>
                        @endif

                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="bg-gray-600 text-white px-3 py-1 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
