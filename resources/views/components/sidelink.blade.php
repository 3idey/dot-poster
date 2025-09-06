<a href="{{ $link }}"
    class="flex items-center py-3 px-4 rounded-lg transition-colors transition-transform duration-200 font-medium
        text-gray-700 dark:text-gray-200
        hover:bg-gray-100 dark:hover:bg-gray-800
        hover:text-gray-900 dark:hover:text-white
        hover:scale-105 hover:shadow-lg dark:hover:shadow-emerald-900
    {{ request()->is(ltrim($link, '/')) ? 'bg-emerald-50 dark:bg-emerald-900 text-emerald-700 dark:text-emerald-300 border-r-2 border-emerald-600 dark:border-emerald-400 scale-105 shadow-lg dark:shadow-emerald-900' : '' }}">
    {{ $slot }}
</a>
