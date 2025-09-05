<a href="{{ $link }}"
    class="flex items-center py-3 px-4 rounded-lg hover:bg-gray-100 transition-colors duration-200 text-gray-700 hover:text-gray-900 font-medium {{ request()->is(ltrim($link, '/')) ? 'bg-emerald-50 text-emerald-700 border-r-2 border-emerald-600' : '' }}">{{ $slot }}</a>
