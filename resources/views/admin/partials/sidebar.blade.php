<aside :class="sidebarOpen ? 'translate-x-0 sm:w-64' : '-translate-x-full sm:translate-x-0 sm:w-20'"
    class="fixed top-0 left-0 z-50 h-full w-64 bg-[#111111] border-r border-gray-800 transition-transform duration-300 ease-in-out shrink-0">

    <div class="flex items-center h-20 relative shrink-0 pl-6 pr-4 justify-between">
        <div x-show="sidebarOpen" x-transition.opacity
            class="flex items-center justify-start transition-all duration-200">
            <img src="images/kasad-logo.png" alt="Museum Kasad Logo" class="h-7 w-auto object-contain">
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
            {{ Request::is('dashboard') ? 'text-[#d4af37] bg-[#1a1a1a]/50 border-b-2 border-[#d4af37] rounded-t-lg' : 'text-gray-400 hover:text-[#d4af37] hover:bg-[#151515]' }}">
            <i :class="sidebarOpen ? '' : 'mx-auto'" class="fas fa-home text-base w-5 text-center shrink-0"></i>
            <span class="ml-4 font-medium text-xs tracking-widest uppercase transition-all" x-show="sidebarOpen">
                Dashboard
            </span>
        </a>

        <a href="/kelola_barang" :class="sidebarOpen ? 'px-3' : 'justify-center px-0'"
            class="flex items-center py-3 transition-all group
            {{ Request::is('kelola_barang*') ? 'text-[#d4af37] bg-[#1a1a1a]/50 border-b-2 border-[#d4af37] rounded-t-lg' : 'text-gray-400 hover:text-[#d4af37] hover:bg-[#151515]' }}">
            <i :class="sidebarOpen ? '' : 'mx-auto'"
                class="fas fa-solid fa-boxes text-base w-5 text-center shrink-0"></i>
            <span class="ml-4 font-medium text-xs tracking-widest uppercase transition-all" x-show="sidebarOpen">
                Kelola Barang
            </span>
        </a>

        <a href="/lihat_tiket" :class="sidebarOpen ? 'px-3' : 'justify-center px-0'"
            class="flex items-center py-3 transition-all group
            {{ Request::is('lihat_tiket*') ? 'text-[#d4af37] bg-[#1a1a1a]/50 border-b-2 border-[#d4af37] rounded-t-lg' : 'text-gray-400 hover:text-[#d4af37] hover:bg-[#151515]' }}">
            <i :class="sidebarOpen ? '' : 'mx-auto'" class="fas fa-ticket-alt text-base w-5 text-center shrink-0"></i>
            <span class="ml-4 font-medium text-xs tracking-widest uppercase transition-all" x-show="sidebarOpen">
                Pemesanan Tiket
            </span>
        </a>

    </nav>
</aside>
