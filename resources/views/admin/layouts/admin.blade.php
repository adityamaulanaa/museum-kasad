<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0a0a0a]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin - Museum KASAD')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="h-full text-gray-200 antialiased font-montserrat [x-cloak] { display: none !important; }"
    x-data="{ sidebarOpen: window.innerWidth >= 640 }">


    <div class="flex h-screen overflow-hidden">

        @include('admin.partials.sidebar')

        <div :class="sidebarOpen ? 'sm:ml-64' : 'sm:ml-20'"
            class="flex flex-col flex-1 min-w-0 transition-all duration-300 ml-0">

            @include('admin.partials.header')

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-8 bg-[#0a0a0a] sm:p-5">
                <div class="max-w-7xl mx-auto space-y-8">
                    <!-- KODE ALERT GLOBAL (Floating di pojok kanan atas) -->
                    @if (session('success'))
                        <div id="toast-success"
                            class="fixed top-5 right-5 z-[9999] flex items-center w-full max-w-xs p-4 rounded-xl shadow-2xl bg-[#141d17] border border-green-800 font-montserrat transition-all duration-300"
                            style="transform: translateY(0); opacity: 1;">
                            <div
                                class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-400 bg-green-950/50 rounded-lg">
                                <i class="fa-solid fa-circle-check text-sm"></i>
                            </div>
                            <div class="ms-3 text-xs font-bold text-gray-200 tracking-wide">
                                {{ session('success') }}
                            </div>
                            <button type="button" onclick="document.getElementById('toast-success').remove()"
                                class="ms-auto -mx-1.5 -my-1.5 bg-transparent text-gray-500 hover:text-white rounded-lg p-1.5 inline-flex items-center justify-center h-6 w-6 cursor-pointer">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </div>

                        <!-- SCRIPT OTOMATIS HILANG DALAM 4 DETIK -->
                        <script>
                            setTimeout(function() {
                                let toast = document.getElementById('toast-success');
                                if (toast) {
                                    toast.style.opacity = '0';
                                    toast.style.transform = 'translateY(-20px)';
                                    setTimeout(() => toast.remove(), 300);
                                }
                            }, 4000);
                        </script>
                    @endif

                    <!-- Tempat halaman anak (seperti lihat_tiket) ditampilkan -->
                    @yield('content')
                </div>
            </main>

        </div>
    </div>

</body>

</html>
