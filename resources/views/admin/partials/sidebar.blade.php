<aside :class="sidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full sm:translate-x-0 sm:w-20'"
    class="fixed top-0 left-0 z-50 h-full bg-[#111111] border-r border-gray-800 transition-transform duration-300 ease-in-out shrink-0 flex flex-col justify-between sm:overflow-x-hidden">
    <div class="flex flex-col flex-1 min-h-0">

        <div class="flex items-center h-20 relative shrink-0 pl-6 pr-4 justify-between">
            <div x-show="sidebarOpen" x-transition.opacity
                class="flex items-center justify-start transition-all duration-200">
                <img src="/images/kasad-logo.png" alt="Museum Kasad Logo" class="h-7 w-auto object-contain">
            </div>

            <button @click="sidebarOpen = !sidebarOpen"
                :class="sidebarOpen ? 'absolute right-4' : 'mx-auto relative left-0 right-0'"
                class="text-gray-400 hover:text-[#d4af37] focus:outline-none p-1 rounded transition-all duration-200">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <nav class="flex-1 px-3 py-6 space-y-4 overflow-y-auto">

            <a href="/dashboard" :class="sidebarOpen ? 'px-3' : 'justify-center px-0'"
                class="flex items-center py-3 transition-all group
                {{ Request::is('dashboard') ? 'text-[#d4af37] bg-[#1a1a1a]/50 border-b-2 border-[#d4af37] rounded-t-lg font-bold' : 'text-gray-400 hover:text-[#d4af37] hover:bg-[#151515] font-medium' }}">
                <i :class="sidebarOpen ? '' : 'mx-auto'" class="fas fa-home text-base w-5 text-center shrink-0"></i>
                <span :class="sidebarOpen ? 'sm:block' : 'sm:hidden'"
                    class="ml-4 text-xs tracking-widest uppercase transition-all sm:block" x-show="sidebarOpen">
                    Dashboard
                </span>
            </a>

            <a href="/kelola_barang" :class="sidebarOpen ? 'px-3' : 'justify-center px-0'"
                class="flex items-center py-3 transition-all group
                {{ Request::is('kelola_barang*') || Request::is('barang*') ? 'text-[#d4af37] bg-[#1a1a1a]/50 border-b-2 border-[#d4af37] rounded-t-lg font-bold' : 'text-gray-400 hover:text-[#d4af37] hover:bg-[#151515] font-medium' }}">
                <i :class="sidebarOpen ? '' : 'mx-auto'"
                    class="fas fa-solid fa-cubes text-base w-5 text-center shrink-0"></i>
                <span :class="sidebarOpen ? 'sm:block' : 'sm:hidden'"
                    class="ml-4 text-xs tracking-widest uppercase transition-all sm:block" x-show="sidebarOpen">
                    Kelola Koleksi
                </span>
            </a>

            <a href="/lihat_tiket" :class="sidebarOpen ? 'px-3' : 'justify-center px-0'"
                class="flex items-center py-3 transition-all group
                {{ Request::is('lihat_tiket*') ? 'text-[#d4af37] bg-[#1a1a1a]/50 border-b-2 border-[#d4af37] rounded-t-lg font-bold' : 'text-gray-400 hover:text-[#d4af37] hover:bg-[#151515] font-medium' }}">
                <i :class="sidebarOpen ? '' : 'mx-auto'" class="fas fa-ticket text-base w-5 text-center shrink-0"></i>
                <span :class="sidebarOpen ? 'sm:block' : 'sm:hidden'"
                    class="ml-4 text-xs tracking-widest uppercase transition-all sm:block" x-show="sidebarOpen">
                    Kelola Pemesanan
                </span>
            </a>

            <a href="/kelola_halaman" :class="sidebarOpen ? 'px-3' : 'justify-center px-0'"
                class="flex items-center py-3 transition-all group
                {{ Request::is('kelola_halaman*') ? 'text-[#d4af37] bg-[#1a1a1a]/50 border-b-2 border-[#d4af37] rounded-t-lg font-bold' : 'text-gray-400 hover:text-[#d4af37] hover:bg-[#151515] font-medium' }}">
                <i :class="sidebarOpen ? '' : 'mx-auto'" class="fas fa-layer-group text-base w-5 text-center shrink-0"></i>
                <span :class="sidebarOpen ? 'sm:block' : 'sm:hidden'"
                    class="ml-4 text-xs tracking-widest uppercase transition-all sm:block" x-show="sidebarOpen">
                    Kelola Halaman
                </span>
            </a>

        </nav>
    </div>

    <div class="p-3 border-t border-gray-800/60 bg-[#111111] shrink-0 mb-4">
        <form method="GET" action="/">
            <button type="button"
                onclick="konfirmasi(this, 'Kembali ke Website', 'Anda masih dalam sesi Admin. Yakin ingin membuka halaman utama website?', 'bg-red-600 hover:bg-red-700')"
                :class="sidebarOpen ? 'px-3 justify-start' : 'justify-center px-0'"
                class="w-full flex items-center py-3 text-gray-500 hover:text-[#d4af37] hover:bg-[#151515] transition-all group rounded-xl cursor-pointer text-left">

                <i :class="sidebarOpen ? '' : 'mx-auto'"
                    class="fas fa-arrow-left text-base w-5 text-center shrink-0 transition-transform group-hover:-translate-x-1"></i>

                <span :class="sidebarOpen ? 'sm:block' : 'sm:hidden'"
                    class="ml-4 text-[11px] tracking-widest uppercase transition-all whitespace-nowrap sm:block"
                    x-show="sidebarOpen">
                    Website Utama
                </span>
            </button>
        </form>
    </div>

</aside>
