@extends('layouts.app')

@section('content')

<script>
    window.dataKoleksi = @json($koleksi);
</script>

<div x-data="{ 
        search: '', 
        // Mengambil kategori dari URL. Jika tidak ada, default ke 'Semua'
        selectedCategory: new URLSearchParams(window.location.search).get('kategori') || 'Semua', 
        dropdownOpen: false,
        modalOpen: false,
        selectedItem: null,
        
        items: window.dataKoleksi,
        
        currentPage: 1,
        itemsPerPage: 8,

        get filteredItems() {
            return this.items.filter(item => {
                const namaBarang = item.nama_barang ? item.nama_barang.toLowerCase() : '';
                const cocokSearch = namaBarang.includes(this.search.toLowerCase());
                const cocokKategori = this.selectedCategory === 'Semua' || item.kategori_barang === this.selectedCategory;
                return cocokSearch && cocokKategori;
            });
        },

        get pagedItems() {
            if (this.currentPage > this.totalPages) this.currentPage = 1;
            const start = (this.currentPage - 1) * this.itemsPerPage;
            return this.filteredItems.slice(start, start + this.itemsPerPage);
        },

        get totalPages() {
            return Math.ceil(this.filteredItems.length / this.itemsPerPage) || 1;
        }
    }" 
    class="bg-black min-h-screen text-white pt-28 pb-12 font-sans selection:bg-yellow-500 selection:text-black">

    <div class="container mx-auto px-6 md:px-12">
        
        <div class="flex justify-center mb-16">
            <div class="flex items-center bg-[#1C1C1C] border border-gray-800 rounded-full px-5 py-3 w-full max-w-xl shadow-lg">
                <input type="text" x-model="search" placeholder="Cari koleksi berdasarkan nama..." class="bg-transparent w-full text-sm focus:outline-none placeholder:text-gray-500 pr-4">
                <div class="relative flex items-center border-l border-gray-800 pl-4">
                    <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false" class="flex items-center gap-2 text-sm text-gray-300 hover:text-yellow-500 transition focus:outline-none whitespace-nowrap">
                        <span x-text="selectedCategory"></span>
                        <svg :class="{'rotate-180': dropdownOpen}" class="w-4 h-4 text-yellow-500 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="dropdownOpen" x-transition.opacity class="absolute right-0 top-full mt-3 bg-[#1C1C1C] border border-gray-800 rounded-lg shadow-2xl py-2 w-48 z-30" style="display: none;">
                        <button @click="selectedCategory = 'Semua'; dropdownOpen = false" class="w-full text-left px-4 py-2 text-sm hover:bg-yellow-500 hover:text-black transition">Semua</button>
                        <button @click="selectedCategory = 'Arkeologika'; dropdownOpen = false" class="w-full text-left px-4 py-2 text-sm hover:bg-yellow-500 hover:text-black transition">Arkeologika</button>
                        <button @click="selectedCategory = 'Seni Rupa'; dropdownOpen = false" class="w-full text-left px-4 py-2 text-sm hover:bg-yellow-500 hover:text-black transition">Seni Rupa</button>
                        <button @click="selectedCategory = 'Historika'; dropdownOpen = false" class="w-full text-left px-4 py-2 text-sm hover:bg-yellow-500 hover:text-black transition">Historika</button>
                        <button @click="selectedCategory = 'Keramologika'; dropdownOpen = false" class="w-full text-left px-4 py-2 text-sm hover:bg-yellow-500 hover:text-black transition">Keramologika</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
            <template x-for="item in pagedItems" :key="item.id_barang">
                <div @click="selectedItem = item; modalOpen = true" class="group bg-[#493D0E] border border-gray-900 rounded-xl overflow-hidden cursor-pointer shadow-md hover:border-yellow-500/50 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="bg-white p-6 h-48 flex items-center justify-center relative overflow-hidden">
                        <img :src="'/images/koleksi/' + item.gambar_barang" :alt="item.nama_barang" class="max-h-full max-w-full object-contain filter drop-shadow-md group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4 bg-[#493D0E]">
                        <h3 x-text="item.nama_barang" class="font-bold text-white tracking-wide group-hover:text-yellow-500"></h3>
                        <p x-text="item.kategori_barang" class="text-xs text-white uppercase tracking-widest mt-0.5"></p>
                    </div>
                </div>
            </template>
        </div>

        <div class="flex justify-center items-center gap-2 mt-16 border-t border-gray-900 pt-8">
            <button @click="if(currentPage > 1) currentPage--" :class="currentPage === 1 ? 'text-gray-700 cursor-not-allowed' : 'text-gray-400 hover:text-yellow-500'" class="p-2 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
            <template x-for="page in totalPages" :key="page">
                <button @click="currentPage = page" x-text="page" :class="currentPage === page ? 'bg-yellow-500 text-black' : 'text-gray-400'" class="px-3 py-1 text-sm font-semibold rounded"></button>
            </template>
            <button @click="if(currentPage < totalPages) currentPage++" :class="currentPage === totalPages ? 'text-gray-700 cursor-not-allowed' : 'text-gray-400 hover:text-yellow-500'" class="p-2 transition"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
        </div>
    </div>

    <div x-show="modalOpen" class="fixed inset-0 z-50 bg-black/85 flex items-center justify-center p-4" style="display: none;">
        <div @click.away="modalOpen = false" class="bg-[#111111] border border-gray-800 rounded-2xl w-full max-w-6xl flex flex-col md:flex-row overflow-hidden relative">
            <button @click="modalOpen = false" class="absolute top-4 right-5 text-3xl z-10 text-white">&times;</button>
            <div class="w-full md:w-2/5 bg-white p-8 flex items-center justify-center">
                <img :src="selectedItem ? '/images/koleksi/' + selectedItem.gambar_barang : ''" class="max-h-[500px] object-contain">
            </div>
            <div class="w-full md:w-3/5 p-12 overflow-y-auto">
                <h2 x-text="selectedItem?.nama_barang" class="text-4xl font-bold text-yellow-500 mb-6"></h2>
                
                <div class="grid grid-cols-2 gap-y-4 mb-8 text-sm">
                    <div><p class="text-gray-500">Tahun / Abad</p><p class="text-white font-medium" x-text="selectedItem?.tahun_barang || '-'"></p></div>
                    <div><p class="text-gray-500">Asal Wilayah</p><p class="text-white font-medium" x-text="selectedItem?.asal_barang || '-'"></p></div>
                    <div><p class="text-gray-500">Bahan Baku</p><p class="text-white font-medium" x-text="selectedItem?.bahan_barang || '-'"></p></div>
                    <div><p class="text-gray-500">Kategori</p><p class="text-white font-medium" x-text="selectedItem?.kategori_barang || '-'"></p></div>
                </div>

                <p x-text="selectedItem?.deskripsi_barang" class="text-gray-300 leading-relaxed text-justify"></p>
            </div>
        </div>
    </div>
</div>

@include('components.footer')
@endsection