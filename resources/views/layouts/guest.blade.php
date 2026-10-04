<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ProWave Technologies') }} | Authentication</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#0b0f19] text-slate-100 prowave-bg-grid min-h-screen antialiased flex flex-col justify-center items-center p-4 sm:p-6 selection:bg-cyan-500 selection:text-white">
        <!-- Ambient Glowing Backdrop -->
        <div class="fixed top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[40rem] h-[25rem] bg-cyan-500/15 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="w-full sm:max-w-md relative z-10 my-auto">
            <!-- Brand Logo -->
            <div class="text-center mb-8">
                <a href="/" class="inline-flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-cyan-500 to-indigo-600 p-0.5 shadow-xl shadow-cyan-500/30 group-hover:scale-105 transition-transform duration-300">
                        <div class="w-full h-full bg-[#0b0f19] rounded-[14px] flex items-center justify-center">
                            <svg class="w-7 h-7 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                    </div>
                </a>
                <h1 class="text-2xl font-extrabold text-white mt-3 font-['Outfit']">Pro<span class="prowave-gradient-text">Wave</span> Technologies</h1>
                <p class="text-xs text-slate-400 mt-1">Enterprise Authentication Gateway</p>
            </div>

            <!-- Auth Form Card -->
            <div class="prowave-glass-card rounded-2xl p-6 sm:p-8 border border-slate-800 shadow-2xl">
                {{ $slot }}
            </div>

            <div class="text-center mt-6 text-xs text-slate-500">
                Licenced To DAWN • ProWave ERP Engine
            </div>
        </div>
    </body>
</html>
