<nav class="h-20 bg-[#0a0a0a] border-b border-gray-800 flex items-center justify-between px-8 shrink-0">
    <div class="flex items-center space-x-3">

        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-400 hover:text-[#d4af37] sm:hidden">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <div class="hidden sm:inline-block w-1.5 h-6 bg-[#d4af37] rounded-full"></div>

        <h1 class="block md:hidden text-xs font-bold text-gray-400 uppercase">
            Manajemen Museum
        </h1>

        <h1 class="hidden md:block text-xs xl:text-lg font-bold tracking-widest text-gray-400 uppercase">
            Sistem Manajemen Museum
        </h1>

    </div>

    <div class="relative" x-data="{ dropdownOpen: false }">
        <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false"
            class="flex items-center space-x-2 bg-[#111111] border border-gray-800 rounded-full py-1.5 px-2 hover:border-[#d4af37] transition-all focus:outline-none">

            <div
                class="w-8 h-8 rounded-full bg-[#d4af37]/10 flex items-center justify-center text-[#d4af37] border border-[#d4af37]/30 shrink-0">
                <i class="fas fa-user text-sm"></i>
            </div>

            <span class="hidden sm:inline text-xs font-bold text-gray-300 tracking-tighter">
                {{ session('username', 'Admin Museum') }}
            </span>

            <i :class="dropdownOpen ? 'rotate-180' : ''"
                class="hidden sm:inline-block fas fa-chevron-down text-[10px] text-gray-500 transition-transform duration-200"></i>

        </button>

        <div x-show="dropdownOpen"
            class="absolute right-0 mt-3 w-56 bg-[#111111] border border-gray-800 rounded-xl py-2 z-50 font-medium"
            style="display: none;">
            <div class="px-4 py-3">
                <p class="text-sm text-gray-300 font-medium">
                    {{ session('username', 'Admin Museum') }}
                </p>
                <p class="text-xs text-gray-500">
                    ID: {{ session('id_admin', '-') }}
                </p>
            </div>
            <div class="border-t border-gray-800 my-2"></div>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit"
                    class="w-full flex items-center px-4 py-3 text-sm text-red-500 hover:bg-red-500/10 transition-colors">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</nav>
