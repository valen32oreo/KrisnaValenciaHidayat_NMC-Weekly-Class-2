<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="EcoBite menghubungkan UMKM kuliner dengan masyarakat untuk menyelamatkan makanan surplus dan mengurangi food waste.">
    <title>@yield('title', 'EcoBite | Platform Surplus Makanan UMKM')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css'])
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased flex flex-col min-h-screen selection:bg-brand-500 selection:text-white">

    <!-- Sticky Glassmorphism Header -->
    <header class="sticky top-0 z-40 w-full border-b border-slate-200 bg-white/90 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('images/logo.png') }}" alt="Logo EcoBite" class="h-10 w-10 object-contain">
                <span class="text-lg font-extrabold tracking-tight text-brand-800">EcoBite</span>
                <span class="hidden sm:inline text-xs font-semibold text-brand-700 bg-brand-50 border border-brand-200 px-2 py-0.5 rounded-full">Tech for Good</span>
            </a>

            <nav class="hidden md:flex items-center gap-1 text-sm font-semibold ml-auto">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('home') ? 'text-brand-700 bg-brand-50' : 'text-slate-600 hover:text-brand-700' }}">Beranda</a>
                <a href="{{ route('home') }}#cara-kerja" class="px-3 py-2 rounded-lg text-slate-600 hover:text-brand-700">Cara kerja</a>
                <a href="{{ route('home') }}#katalog" class="px-3 py-2 rounded-lg text-slate-600 hover:text-brand-700">Katalog</a>
                <a href="{{ route('perancangan') }}" class="px-3 py-2 rounded-lg {{ request()->routeIs('perancangan') ? 'text-brand-700 bg-brand-50' : 'text-slate-600 hover:text-brand-700' }}">Perancangan</a>
            </nav>

            <div class="flex items-center gap-2">
                <button onclick="openModalForm()" class="inline-flex items-center gap-2 bg-brand-600 hover:bg-brand-700 text-white font-semibold text-sm px-4 py-2 rounded-xl transition active:scale-95">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    <span class="hidden sm:inline">Tambah porsi</span><span class="sm:hidden">Tambah</span>
                </button>
                <button id="tombolMenu" onclick="toggleMenu()" aria-label="Buka menu" aria-expanded="false" aria-controls="menuMobile" class="md:hidden w-10 h-10 flex items-center justify-center rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-50">
                    <span id="ikonBuka"><i data-lucide="menu" class="w-5 h-5"></i></span>
                    <span id="ikonTutup" class="hidden"><i data-lucide="x" class="w-5 h-5"></i></span>
                </button>
            </div>
        </div>
        <nav id="menuMobile" class="hidden md:hidden border-t border-slate-100 bg-white px-4 py-2 flex flex-col text-sm font-semibold text-slate-700">
            <a href="{{ route('home') }}" onclick="toggleMenu()" class="px-3 py-3 rounded-lg hover:bg-brand-50 hover:text-brand-700">Beranda</a>
            <a href="{{ route('home') }}#cara-kerja" onclick="toggleMenu()" class="px-3 py-3 rounded-lg hover:bg-brand-50 hover:text-brand-700">Cara kerja</a>
            <a href="{{ route('home') }}#katalog" onclick="toggleMenu()" class="px-3 py-3 rounded-lg hover:bg-brand-50 hover:text-brand-700">Katalog</a>
            <a href="{{ route('perancangan') }}" onclick="toggleMenu()" class="px-3 py-3 rounded-lg hover:bg-brand-50 hover:text-brand-700">Perancangan</a>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="footer" class="border-t border-slate-200 bg-white font-sans">
        <div class="max-w-7xl mx-auto px-6 py-16">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-6 items-start">

                <!-- Logo & Deskripsi Utama -->
                <div class="flex flex-col gap-4 lg:col-span-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" class="w-9 h-9 object-contain" alt="EcoBite Logo">
                        <span class="font-extrabold text-xl tracking-tight text-slate-900">
                            EcoBite
                        </span>
                        <span class="text-[10px] uppercase font-bold text-brand-700 bg-brand-50 border border-brand-200 px-2 py-0.5 rounded-full">
                            Tech for Good
                        </span>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        Platform penyelamat makanan surplus dari UMKM kuliner lokal. Berkomitmen mengurangi <em>food waste</em> dan memperluas akses makanan terjangkau bagi masyarakat.
                    </p>
                </div>

                <!-- Navigasi -->
                <div class="lg:col-span-2 lg:col-start-5">
                    <p class="font-semibold mb-4 text-slate-900">Navigasi Utama</p>
                    <ul class="space-y-3 text-sm text-slate-500">
                        <li>
                            <a href="{{ route('home') }}" class="hover:text-brand-600 transition">Beranda Utama</a>
                        </li>
                        <li>
                            <a href="{{ request()->routeIs('home') ? '#cara-kerja' : route('home').'#cara-kerja' }}" class="hover:text-brand-600 transition">
                                Cara Kerja
                            </a>
                        </li>
                        <li>
                            <a href="{{ request()->routeIs('home') ? '#katalog' : route('home').'#katalog' }}" class="hover:text-brand-600 transition">
                                Katalog Porsi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('perancangan') }}" class="hover:text-brand-600 transition font-semibold text-brand-700">
                                Perancangan Web
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Fokus & Dampak -->
                <div class="lg:col-span-2">
                    <p class="font-semibold mb-4 text-slate-900">Fokus & Dampak</p>
                    <ul class="space-y-3 text-sm text-slate-500">
                        <li><span class="hover:text-brand-600 transition cursor-default">SDG 12 Konsumsi</span></li>
                        <li><span class="hover:text-brand-600 transition cursor-default">Food Waste Rescue</span></li>
                        <li><span class="hover:text-brand-600 transition cursor-default">Mitra UMKM Kuliner</span></li>
                        <li><span class="hover:text-brand-600 transition cursor-default">Diskon Makanan 50%</span></li>
                    </ul>
                </div>

                <!-- Stack Teknologi -->
                <div class="lg:col-span-2">
                    <p class="font-semibold mb-4 text-slate-900">Teknologi</p>
                    <ul class="space-y-3 text-sm text-slate-500">
                        <li><span class="hover:text-brand-600 transition cursor-default">Laravel 13 (PHP 8.3)</span></li>
                        <li><span class="hover:text-brand-600 transition cursor-default">Tailwind CSS</span></li>
                        <li><span class="hover:text-brand-600 transition cursor-default">MySQL Database</span></li>
                        <li><span class="hover:text-brand-600 transition cursor-default">Lucide Vector Icons</span></li>
                    </ul>
                </div>

                <!-- Submission Info -->
                <div class="lg:col-span-2">
                    <p class="font-semibold mb-4 text-slate-900">Submission</p>
                    <ul class="space-y-3 text-sm text-slate-500">
                        <li>
                            <span class="font-medium text-slate-700 block">GDGoC Gunadarma</span>
                            <span class="block text-xs text-slate-400 mt-0.5">Weekly Class 2</span>
                        </li>
                        <li>
                            <span class="font-medium text-slate-700 block">Class Web Developer</span>
                            <span class="block text-xs text-slate-400 mt-0.5">Task Submission</span>
                        </li>
                        <li>
                            <span class="font-medium text-slate-700 block">Developer</span>
                            <span class="block text-xs text-slate-400 mt-0.5">Krisna Valencia Hidayat</span>
                        </li>
                    </ul>
                </div>

            </div>

            <!-- Sub-footer / Hak Cipta -->
            <div class="mt-16 pt-6 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-slate-400">
                <p class="text-center sm:text-left">
                    <span>
                        Copyright © {{ date('Y') }} 
                        <span class="font-bold text-slate-700">EcoBite App</span>. All rights reserved.
                    </span>
                </p>

                <div class="flex items-center gap-6">
                    <a href="{{ route('perancangan') }}" class="text-sm text-slate-400 hover:text-brand-600 font-medium transition-colors underline-offset-4 hover:underline">
                        Perancangan Aplikasi
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function openModalForm() {
            const modal = document.getElementById('modalForm');
            if (modal) { modal.classList.remove('hidden'); }
            else { window.location.href = "{{ route('home') }}?tambah=1"; }
        }
        function toggleMenu() {
            const menu = document.getElementById('menuMobile');
            const terbuka = menu.classList.toggle('hidden') === false;
            document.getElementById('ikonBuka').classList.toggle('hidden', terbuka);
            document.getElementById('ikonTutup').classList.toggle('hidden', !terbuka);
            document.getElementById('tombolMenu').setAttribute('aria-expanded', terbuka);
        }
        function closeModalForm() {
            const modal = document.getElementById('modalForm');
            if (modal) { modal.classList.add('hidden'); }
        }
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeModalForm(); });
    </script>
    @stack('scripts')
    <script>
        lucide.createIcons();
    </script>
</body>
</html>