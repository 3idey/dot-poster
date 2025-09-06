@props(['title'])
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | Dot Poster</title>

    <!-- Favicon -->

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Meta Tags -->
    <meta name="description"
        content="Dot Poster: Transform your space with curated, high-quality posters. Shop vintage, modern, and exclusive art prints. Fast delivery, secure payment, and a vibrant community.">
    <meta name="theme-color" content="#111827">

    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Preload critical resources -->
    <link rel="preload" href="{{ Vite::asset('resources/images/whitelogo.png') }}" as="image">

    <!-- Dark mode script (runs before CSS to prevent FOUC) -->
    <script>
        (function() {
            if (
                localStorage.getItem('darkMode') === 'true' ||
                (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)
            ) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
