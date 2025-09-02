<x-header title="Profile" />

<x-layout>
    <div class="max-w-5xl mx-auto bg-gray-900 text-white rounded-xl shadow p-8 space-y-8">

        {{-- User Info + Edit --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-6">
                <img src="{{ $user->avatar
                    ? asset('storage/' . $user->avatar)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff' }}"
                    class="w-20 h-20 rounded-full border-2 border-emerald-500 shadow-lg" alt="avatar">


                <div>
                    <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                    <p class="text-gray-400">{{ $user->email }}</p>
                </div>
            </div>

            <a href="{{ route('profile.edit') }}"
                class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-4 py-2 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                Edit Profile
            </a>
        </div>

        {{-- Orders --}}
        <div>
            <h3 class="text-xl font-semibold mb-4">Your Orders</h3>
            @forelse ($orders as $order)
                <a href="{{ route('orders.show', $order) }}">
                    <div class="border border-gray-700 p-4 rounded-lg mb-3 hover:bg-gray-800 transition">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="font-semibold">Order #{{ $order->id }}</span>
                                <p class="text-gray-400 text-sm">{{ $order->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="text-sm text-gray-300">
                                {{ $order->orderItems->count() }} items
                                — <span
                                    class="font-semibold">${{ number_format($order->orderItems->sum('price'), 2) }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <p class="text-gray-400">No orders yet.</p>
            @endforelse
        </div>
    </div>
</x-layout>

<x-footer />
