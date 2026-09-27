<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-black">
    <header class="bg-black px-4 py-4 sm:px-8">
        <a href="{{ route('home') }}" class="block w-fit">
            <img
                src="{{ asset('images/logo.png') }}"
                alt="{{ config('app.name') }}"
                class="h-9 max-w-full object-contain"
            />
        </a>
    </header>
    <main>{{ $slot }}</main>
</body>
</html>
