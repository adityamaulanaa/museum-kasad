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
    x-data="{ sidebarOpen: false }">


    <div class="flex h-screen overflow-hidden">

        @include('admin.partials.sidebar')

        <div :class="sidebarOpen ? 'sm:ml-64' : 'sm:ml-20'"
            class="flex flex-col flex-1 min-w-0 transition-all duration-300 ml-0">

            @include('admin.partials.header')

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-8 bg-[#0a0a0a] sm:p-5">
                <div class="max-w-7xl mx-auto space-y-8">

                    <!-- alert sukses -->
                    @if (session('success'))
                        <div id="toast-success"
                            class="fixed top-5 right-5 z-9999 flex items-center w-full max-w-xs p-4 rounded-xl shadow-2xl bg-[#141d17] border border-green-800 font-montserrat transition-all duration-300"
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

                    <!-- konfirmasi global -->
                    <div id="global-confirm-modal"
                        class="hidden fixed inset-0 z-9999 items-center justify-center p-4 font-montserrat">
                        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm" onclick="tutupKonfirmasi()"></div>

                        <div
                            class="bg-[#111111] border border-gray-800 rounded-2xl max-w-sm w-full p-6 shadow-2xl relative z-10 text-center">
                            <div
                                class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-amber-950/50 border border-amber-800 text-amber-500 mb-4 animate-bounce">
                                <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                            </div>

                            <h3 id="global-confirm-title" class="text-lg font-bold text-white">Konfirmasi Aksi</h3>
                            <p id="global-confirm-msg" class="text-sm text-gray-400 mt-2 leading-relaxed">Apakah Anda
                                yakin ingin melanjutkan tindakan ini?</p>

                            <div
                                class="flex items-center justify-center space-x-3 mt-6 pt-4 border-t border-gray-800/50">
                                <button type="button" onclick="tutupKonfirmasi()"
                                    class="w-1/2 text-center text-gray-400 hover:text-white text-xs font-bold py-3 border border-gray-800 hover:border-gray-700 rounded-xl transition-colors uppercase cursor-pointer">
                                    Batal
                                </button>
                                <button type="button" id="global-confirm-submit-btn"
                                    class="w-1/2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-3 rounded-xl transition-colors uppercase tracking-wider shadow-lg cursor-pointer">
                                    Ya, Lanjutkan
                                </button>
                            </div>
                        </div>
                    </div>

                    <script>
                        let targetFormGlobal = null;

                        function konfirmasi(element, judul, pesan, warnaTombol = 'bg-red-600 hover:bg-red-700') {
                            targetFormGlobal = element.closest('form');

                            document.getElementById('global-confirm-title').innerText = judul;
                            document.getElementById('global-confirm-msg').innerText = pesan;

                            const btnSubmit = document.getElementById('global-confirm-submit-btn');
                            btnSubmit.className =
                                `w-1/2 text-white text-xs font-bold py-3 rounded-xl transition-colors uppercase tracking-wider shadow-lg cursor-pointer ${warnaTombol}`;

                            document.getElementById('global-confirm-modal').classList.remove('hidden');
                            document.getElementById('global-confirm-modal').classList.add('flex');
                        }

                        function tutupKonfirmasi() {
                            document.getElementById('global-confirm-modal').classList.remove('flex');
                            document.getElementById('global-confirm-modal').classList.add('hidden');
                            targetFormGlobal = null;
                        }

                        document.getElementById('global-confirm-submit-btn').addEventListener('click', function() {
                            if (targetFormGlobal) targetFormGlobal.submit();
                            tutupKonfirmasi();
                        });
                    </script>

                    @yield('content')
                </div>
            </main>

        </div>
    </div>

</body>

</html>
