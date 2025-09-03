@extends('components.admin')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Users Management</h1>

    <table class="w-full bg-white shadow-md rounded-lg">
        <thead>
            <tr class="bg-gray-200 text-left">

                <th class="p-3">ID</th>
                <th class="p-3">Avatar</th>
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
                    <td class="rounded-md p-3"> <img
                            src="{{ $user->avatar_url }}"
                            class="w-20 h-20 rounded-full border-2 border-emerald-500 shadow-lg" alt="avatar">
                    </td>
                    <td class="p-3">{{ $user->name }}</td>
                    <td class="p-3">{{ $user->email }}</td>
                    <td class="p-3">{{ $user->is_banned ? 'banned' : 'active' }}</td>
                    <td class="p-3 space-x-2">
                        @if (!$user->is_banned)
                            <form action="{{ route('admin.users.ban', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button class="bg-gradient-to-r from-red-600 to-red-700 text-white px-3 py-1 rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">Ban</button>
                            </form>
                        @else
                            <form action="{{ route('admin.users.unban', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white px-3 py-1 rounded-xl hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">Unban</button>
                            </form>
                        @endif

                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="bg-gradient-to-r from-gray-600 to-gray-700 text-white px-3 py-1 rounded-xl hover:from-gray-700 hover:to-gray-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@endsection
