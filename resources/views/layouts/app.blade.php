<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Museum KASAD</title>
    <!-- Tailwind CSS (Pastikan sudah terinstall/ter-link) -->
    @vite('resources/css/app.css')
    <!-- Alpine.js untuk interaksi klik tanpa reload -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<!-- Inisialisasi state Alpine.js (menuOpen = false berarti side menu tertutup di awal) -->
<body x-data="{ menuOpen: false }" class="bg-black text-white font-sans antialiased">

    <!-- ================== NAVBAR UTAMA ================== -->
    <header class="absolute top-0 left-0 right-0 z-40 flex justify-between items-center p-6 bg-transparent">
        
        <!-- Logo Kiri Atas (Merujuk ke Beranda) -->
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Museum KASAD" class="h-10 md:h-12">
        </a>

        <!-- Link Navigasi & Ikon Menu Kanan Atas -->
        <div class="flex items-center gap-8">
            <!-- Navigasi Desktop -->
            <nav class="hidden md:flex items-center gap-6 text-sm tracking-widest font-serif">
                <a href="{{ route('about') }}" class="hover:text-yellow-500 transition-colors">ABOUT</a>
                <a href="{{ route('koleksi') }}" class="hover:text-yellow-500 transition-colors flex items-center gap-1">
                    KOLEKSI
                </a>
                <a href="{{ route('tiket') }}" class="hover:text-yellow-500 transition-colors">TIKET</a>
            </nav>

            <!-- Ikon Menu (Garis 3 / Pencarian) -->
            <button @click="menuOpen = true" class="focus:outline-none hover:text-yellow-500 transition-colors">
                <!-- Gunakan ikon garis 3 atau ikon custom gabungan search & menu dari desain Anda -->
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </header>


    <!-- ================== SIDE MENU (HAMBURGER MENU) ================== -->
    <!-- Menu ini akan muncul sebagai overlay (menutupi layar) di halaman yang sama -->
    <div x-show="menuOpen" class="fixed inset-0 z-50 flex justify-end" style="display: none;">
        
        <div x-show="menuOpen" 
             @click="menuOpen = false" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

        <div x-show="menuOpen" 
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="relative w-full max-w-xs h-full bg-[#1A1A1A] shadow-2xl flex flex-col overflow-hidden">
            
             <div class="absolute inset-0 z-0 opacity-20" 
                style="background-image: url('{{ asset('images/side-menu-bg.png') }}'); background-size: cover; background-position: right bottom;">
             </div>
            
             <div class="flex flex-col h-full w-full p-8 relative z-10">
                
                <div class="flex justify-between items-center mb-16">
                    <a href="{{ route('home') }}" @click="menuOpen = false">
                        <img src="{{ asset('images/logo.png') }}" alt="Museum" class="h-10">
                    </a>
                    <button @click="menuOpen = false" class="text-gray-400 hover:text-yellow-500 focus:outline-none transition-transform hover:rotate-90 duration-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <nav class="flex flex-col gap-6 text-2xl font-serif tracking-widest text-white">
                    <a href="{{ route('home') }}" class="hover:text-yellow-500 transition">HOME</a>
                    <a href="{{ route('about') }}" class="hover:text-yellow-500 transition">ABOUT</a>
                    
                    <div x-data="{ dropKoleksi: false }">
                        <button @click="dropKoleksi = !dropKoleksi" class="flex items-center gap-2 hover:text-yellow-500 transition focus:outline-none w-full justify-between">
                            KOLEKSI
                            <svg :class="{'rotate-180': dropKoleksi}" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="dropKoleksi" x-transition.opacity class="flex flex-col gap-3 mt-4 ml-4 text-lg text-gray-300 border-l border-gray-700 pl-4">
                            <a href="/koleksi?kategori=Arkeologika" class="hover:text-yellow-500">Arkeologika</a>
                            <a href="/koleksi?kategori=Seni Rupa" class="hover:text-yellow-500">Seni Rupa</a>
                            <a href="/koleksi?kategori=Historika" class="hover:text-yellow-500">Historika</a>
                            <a href="/koleksi?kategori=Keramologika" class="hover:text-yellow-500">Keramologika</a>
                            <a href="/koleksi?kategori=Geologika" class="hover:text-yellow-500">Geologika</a>
                        </div>
                    </div>

                    <a href="{{ route('tiket') }}" class="hover:text-yellow-500 transition">BELI TIKET</a>
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-yellow-500 transition flex items-center gap-2 mt-4 border-t border-gray-800 pt-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                            LOGIN ADMIN
                        </a>
                </nav>

                <div class="flex-grow"></div>

                <div class="mt-auto font-serif tracking-wide">
                    <h3 class="text-xl text-yellow-500 mb-2">CONTACT US</h3>
                    <div class="text-gray-400 text-sm leading-relaxed">
                        <p>contact@kasad.id</p>
                        <p>0251 651 998</p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- ================== KONTEN UTAMA HALAMAN ================== -->
    <!-- Di sinilah konten dari masing-masing halaman (Beranda, About, dll) akan disisipkan -->
    <main>
        @yield('content')
    </main>

</body>
</html>