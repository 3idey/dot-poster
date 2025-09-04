@props(['title'])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Vite Assets -->
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
    
    <!-- Additional Meta Tags -->
    <meta name="description" content="Discover amazing posters that transform your space. From vintage classics to modern art, find the perfect piece for your walls.">
    <meta name="theme-color" content="#111827">
    
    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Preload critical resources -->
    <link rel="preload" href="{{ Vite::asset('resources/images/whitelogo.png') }}" as="image">
</head>
