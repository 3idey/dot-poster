<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 text-gray-900 font-sans antialiased">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <nav class="w-64 bg-gray-900 text-white flex flex-col py-8 space-y-6 fixed left-0 top-0 h-full shadow-lg">
            <h2 class="text-xl font-bold px-6">Admin</h2>

            <ul class="w-full px-6 space-y-4">
                <li><a href="{{ route('admin.users.index') }}" class="block hover:text-emerald-400">Users</a></li>
                <li><a href="{{ route('admin.products.index') }}" class="block hover:text-emerald-400">Products</a></li>
                <li><a href="{{ route('admin.orders.index') }}" class="block hover:text-emerald-400">Orders</a></li>
                <li><a href="{{ route('admin.categories.index') }}" class="block hover:text-emerald-400">Categories</a></li>
            </ul>
        </nav>

        <!-- Content -->
        <main class="flex-1 ml-64 p-10 overflow-y-auto w-full">
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>

</html>
