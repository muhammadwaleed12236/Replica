<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'DAWN ERP') }} | Business Management System</title>

        <!-- Fonts: Poppins & JetBrains Mono -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&family=JetBrains+Mono:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Tailwind CSS CDN for instant, reliable design rendering -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#e9eff6] text-slate-900 min-h-screen antialiased selection:bg-[#0f4c81] selection:text-white font-sans">
        
        <div class="min-h-screen flex flex-col justify-between">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white border-b border-[#cbd8e4] shadow-sm">
                    <div class="max-w-[1400px] mx-auto py-3 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-grow">
                {{ $slot ?? '' }}
                @yield('content')
            </main>

            <!-- DAWN ERP Footer -->
            <footer class="border-t border-[#cbd7e6] bg-[#dbe5f2] py-2 text-center text-xs text-slate-600 font-medium select-none">
                <div class="max-w-[1400px] mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-1">
                    <span>DevoAccounts ERP System • Licensed to <strong class="text-slate-800 font-bold">DAWN</strong></span>
                    <span class="font-mono text-slate-500">Active Terminal • Fast Accounting Engine</span>
                </div>
            </footer>
        </div>
    </body>
</html>
