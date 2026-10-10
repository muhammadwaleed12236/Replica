<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }" 
      x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))" 
      :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ProWave Technologies') }} | Enterprise OS</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased selection:bg-blue-500 selection:text-white transition-colors duration-300">
        
        <div class="min-h-screen flex flex-col relative z-10 bg-gray-50 dark:bg-slate-900 text-gray-900 dark:text-slate-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="prowave-glass border-b border-slate-800/80">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-grow">
                {{ $slot }}
            </main>

            <!-- Mini App Footer -->
            <footer class="border-t border-slate-800/80 bg-[#070a12] py-6 text-center text-xs text-slate-500">
                <div class="max-w-7xl mx-auto px-4">
                    ProWave Technologies Platform • Laravel 12 Enterprise Engine • Active Session
                </div>
            </footer>
        </div>
    </body>
</html>
