@props(['size' => 'base'])

@php
$sizeClasses = [
    'sm' => 'text-lg',
    'base' => 'text-2xl',
    'lg' => 'text-3xl',
    'xl' => 'text-4xl'
];
@endphp

<div class="flex items-center group cursor-pointer transition-all duration-300 hover:scale-105">
    <div class="relative">
        <!-- Main text with gradient and shadow effects -->
        <div class="{{ $sizeClasses[$size] ?? $sizeClasses['base'] }} text-logo select-none
                    bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-500 
                    dark:from-emerald-400 dark:via-emerald-300 dark:to-teal-300 
                    bg-clip-text text-transparent
                    drop-shadow-lg group-hover:drop-shadow-xl
                    transition-all duration-300">
            .poster
        </div>
        
        <!-- Subtle glow effect for dark mode -->
        <div class="absolute inset-0 {{ $sizeClasses[$size] ?? $sizeClasses['base'] }} text-logo
                    text-emerald-400/20 dark:text-emerald-300/30 
                    blur-sm group-hover:blur-md 
                    opacity-0 dark:opacity-60 group-hover:dark:opacity-80
                    transition-all duration-300 pointer-events-none">
            .poster
        </div>
        
        <!-- Animated dot -->
        <div class="absolute -top-1 left-0 w-2 h-2 
                    bg-gradient-to-r from-emerald-500 to-teal-400
                    dark:from-emerald-300 dark:to-teal-200
                    rounded-full 
                    animate-pulse group-hover:animate-ping
                    shadow-lg shadow-emerald-500/50 dark:shadow-emerald-300/50
                    transition-all duration-300">
        </div>
    </div>
    
    <!-- Optional tagline for larger sizes -->
    @if($size === 'xl')
        <div class="ml-3 text-sm font-medium text-gray-600 dark:text-gray-300 
                    opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            art & inspiration
        </div>
    @endif
</div>
