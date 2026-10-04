<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ProWave Technologies') }} | Intelligent Enterprise Cloud</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Vite CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0b0f19] text-slate-100 prowave-bg-grid min-h-screen selection:bg-cyan-500 selection:text-white">

    <!-- Ambient Glowing Background Orbs -->
    <div class="fixed top-0 left-1/4 w-96 h-96 bg-cyan-500/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="fixed top-1/3 right-1/4 w-[30rem] h-[30rem] bg-indigo-600/10 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="fixed bottom-10 left-1/3 w-80 h-80 bg-purple-600/10 rounded-full blur-[120px] pointer-events-none"></div>

    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-50 prowave-glass border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-cyan-500 to-indigo-600 p-0.5 shadow-lg shadow-cyan-500/20 group-hover:shadow-cyan-500/40 transition-all duration-300">
                    <div class="w-full h-full bg-[#0b0f19] rounded-[10px] flex items-center justify-center">
                        <svg class="w-6 h-6 text-cyan-400 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
                <div>
                    <span class="text-xl font-extrabold tracking-tight text-white font-['Outfit']">Pro<span class="prowave-gradient-text">Wave</span></span>
                    <span class="block text-[10px] font-semibold tracking-widest text-cyan-400 uppercase">Technologies</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="#solutions" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors">Solutions</a>
                <a href="#architecture" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors">Architecture</a>
                <a href="#metrics" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors">Performance</a>
                <a href="#developers" class="text-sm font-medium text-slate-300 hover:text-cyan-400 transition-colors">Developers</a>
            </nav>

            <!-- Auth Buttons -->
            <div class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="prowave-btn-primary px-5 py-2.5 rounded-xl text-sm inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            Control Panel
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="prowave-btn-secondary px-5 py-2.5 rounded-xl text-sm font-semibold">
                            Sign In
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="prowave-btn-primary px-5 py-2.5 rounded-xl text-sm font-semibold">
                                Get Started
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative pt-16 pb-20 md:pt-24 md:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            
            <!-- Tech Version Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full prowave-glass border border-cyan-500/30 text-xs font-semibold text-cyan-300 mb-8 animate-pulse-border">
                <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                ProWave Enterprise Core v4.2 Active & Ready
            </div>

            <!-- Main Title -->
            <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold tracking-tight max-w-5xl mx-auto leading-tight">
                Architecting Next-Gen <br class="hidden sm:inline"/>
                <span class="prowave-gradient-text">Cloud Systems & AI Intelligence</span>
            </h1>

            <p class="mt-6 text-lg sm:text-xl text-slate-400 max-w-3xl mx-auto leading-relaxed">
                Empowering modern enterprises with high-throughput cloud microservices, real-time telemetry, automated zero-trust security, and scalable edge computing.
            </p>

            <!-- Action Buttons -->
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="w-full sm:w-auto prowave-btn-primary px-8 py-4 rounded-xl text-base font-bold flex items-center justify-center gap-3 group">
                    <span>Deploy Solution</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto prowave-btn-secondary px-8 py-4 rounded-xl text-base font-bold flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Live Demo Portal
                </a>
            </div>

            <!-- Interactive Platform Showcase Mockup -->
            <div class="mt-16 relative max-w-5xl mx-auto animate-float">
                <div class="prowave-glass-card rounded-2xl p-4 md:p-6 border border-slate-700/60 shadow-2xl">
                    <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 rounded-full bg-rose-500/80"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-500/80"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-500/80"></div>
                            <span class="text-xs text-slate-500 font-mono ml-4">prowave-node-us-east-1 // telemetry-dashboard</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                🟢 Operational
                            </span>
                        </div>
                    </div>

                    <!-- Platform Dashboard Cards Preview -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 text-left">
                        <div class="bg-slate-900/80 rounded-xl p-4 border border-slate-800">
                            <div class="text-xs text-slate-400 uppercase font-semibold">Global Telemetry Stream</div>
                            <div class="text-2xl font-bold text-cyan-400 mt-2">1,482,900 req/sec</div>
                            <div class="w-full bg-slate-800 rounded-full h-1.5 mt-3">
                                <div class="bg-cyan-400 h-1.5 rounded-full w-[88%]"></div>
                            </div>
                        </div>

                        <div class="bg-slate-900/80 rounded-xl p-4 border border-slate-800">
                            <div class="text-xs text-slate-400 uppercase font-semibold">Average Edge Latency</div>
                            <div class="text-2xl font-bold text-indigo-400 mt-2">8.4ms</div>
                            <div class="w-full bg-slate-800 rounded-full h-1.5 mt-3">
                                <div class="bg-indigo-400 h-1.5 rounded-full w-[94%]"></div>
                            </div>
                        </div>

                        <div class="bg-slate-900/80 rounded-xl p-4 border border-slate-800">
                            <div class="text-xs text-slate-400 uppercase font-semibold">Zero-Trust Guard status</div>
                            <div class="text-2xl font-bold text-emerald-400 mt-2">100% Shielded</div>
                            <div class="w-full bg-slate-800 rounded-full h-1.5 mt-3">
                                <div class="bg-emerald-400 h-1.5 rounded-full w-[100%]"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Metrics Stats Ticker -->
    <section id="metrics" class="py-12 border-y border-slate-800/80 prowave-glass">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl sm:text-4xl font-extrabold text-white font-['Outfit']">99.999%</div>
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Enterprise Uptime SLA</div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-extrabold text-cyan-400 font-['Outfit']">2.5B+</div>
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Monthly API Transactions</div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-extrabold text-indigo-400 font-['Outfit']">&lt; 10ms</div>
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Global Data Routing</div>
                </div>
                <div>
                    <div class="text-3xl sm:text-4xl font-extrabold text-purple-400 font-['Outfit']">256-Bit</div>
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">AES Hardware Encryption</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Solutions Grid -->
    <section id="solutions" class="py-24 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-xs font-extrabold tracking-widest text-cyan-400 uppercase">ProWave Capabilities</h2>
                <p class="text-3xl sm:text-4xl font-bold text-white mt-2 font-['Outfit']">Empowering Critical Technology Stack</p>
                <p class="mt-4 text-slate-400">Our suite provides modular tools designed for high-availability enterprise applications.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="prowave-glass-card rounded-2xl p-8 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-cyan-500/10 border border-cyan-500/30 flex items-center justify-center text-cyan-400 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-white">Autonomous Cloud Mesh</h3>
                        <p class="mt-3 text-sm text-slate-400 leading-relaxed">Self-healing infrastructure that balances loads, isolates faults, and auto-scales microservices effortlessly across global clusters.</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-800/80 flex items-center text-xs font-semibold text-cyan-400 gap-1">
                        <span>Read Technical Docs</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="prowave-glass-card rounded-2xl p-8 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-indigo-500/10 border border-indigo-500/30 flex items-center justify-center text-indigo-400 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-white">Cyber Shield Protocol</h3>
                        <p class="mt-3 text-sm text-slate-400 leading-relaxed">Built-in threat detection, automated rate-limiting, OAuth2 authentication, and end-to-end encrypted session persistence.</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-800/80 flex items-center text-xs font-semibold text-indigo-400 gap-1">
                        <span>Security Compliance</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="prowave-glass-card rounded-2xl p-8 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/30 flex items-center justify-center text-purple-400 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-white">Real-Time Data Pipeline</h3>
                        <p class="mt-3 text-sm text-slate-400 leading-relaxed">High-frequency WebSockets & event streaming pipelines with zero memory leaks and instantaneous telemetry visualization.</p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-slate-800/80 flex items-center text-xs font-semibold text-purple-400 gap-1">
                        <span>Explore Pipeline APIs</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-slate-800/80 bg-[#070a12] py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
            <div>
                <span class="text-lg font-bold text-white font-['Outfit']">Pro<span class="prowave-gradient-text">Wave</span> Technologies</span>
                <p class="text-xs text-slate-500 mt-1">© {{ date('Y') }} ProWave Technologies Inc. All rights reserved. Laravel 12 Enterprise Stack.</p>
            </div>
            <div class="flex items-center space-x-6 text-xs text-slate-400">
                <a href="#" class="hover:text-cyan-400 transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-cyan-400 transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-cyan-400 transition-colors">Security Audit</a>
                <a href="#" class="hover:text-cyan-400 transition-colors">Contact Engineering</a>
            </div>
        </div>
    </footer>
</body>
</html>
