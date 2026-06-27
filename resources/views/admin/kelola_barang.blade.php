@extends('admin.layouts.admin')
@section('title', 'Kelola Koleksi - Museum KASAD')

@section('content')
    <script>
        window.dataBarangAdmin = @json($barangs);
    </script>

    <div x-data="{
        search: '',
        selectedCategory: 'Semua',
        dropdownOpen: false, // Untuk buka-tutup dropdown custom
        items: window.dataBarangAdmin,
        currentPage: 1,
        itemsPerPage: 10,
        modalDetailOpen: false,
        selectedBarang: null,
    
        get filteredItems() {
            return this.items.filter(item => {
                    const keyword = this.search.toLowerCase();
                    const nama = item.nama_barang ? item.nama_barang.toLowerCase() : '';
                    const namaAdmin = (item.admin && item.admin.username) ? item.admin.username.toLowerCase() : '';
    
                    const cocokSearch = nama.includes(keyword) || namaAdmin.includes(keyword);
                    const cocokKategori = this.selectedCategory === 'Semua' || item.kategori_barang === this.selectedCategory;
    
                    return cocokSearch && cocokKategori;
                })
                .sort((a, b) => {
                    // 1. Urutkan berdasarkan waktu updated_at terbaru (ubah ke format milidetik)
                    const waktuB = a.updated_at ? new Date(b.updated_at).getTime() : 0;
                    const waktuA = a.updated_at ? new Date(a.updated_at).getTime() : 0;
    
                    if (waktuB !== waktuA) {
                        return waktuB - waktuA; // Yang barusan di-update langsung melesat ke atas
                    }
    
                    // 2. Kalau waktu updated_at-nya sama (efek data lama hasil import), paksa urutkan dari ID terbesar
                    return b.id_barang - a.id_barang;
                });
        },
    
        get pagedItems() {
            if (this.currentPage > this.totalPages) this.currentPage = 1;
            const start = (this.currentPage - 1) * parseInt(this.itemsPerPage);
            return this.filteredItems.slice(start, start + parseInt(this.itemsPerPage));
        },
    
        get totalPages() {
            return Math.ceil(this.filteredItems.length / parseInt(this.itemsPerPage)) || 1;
        },
    
        get indexStart() {
            return this.filteredItems.length === 0 ? 0 : (this.currentPage - 1) * parseInt(this.itemsPerPage) + 1;
        },
        get indexEnd() {
            const end = this.currentPage * parseInt(this.itemsPerPage);
            return end > this.filteredItems.length ? this.filteredItems.length : end;
        },
        bukaDetailBarang(barang) {
            this.selectedBarang = barang;
            this.modalDetailOpen = true;
        }
    }" class="space-y-6 font-montserrat text-white">

        <div class="space-y-3 mb-6">
            <div class="mb-4">
                <h1 class="text-2xl sm:text-3xl font-bold tracking-wide text-white">
                    Kelola Koleksi Museum
                </h1>
            </div>

            <div class="flex flex-col lg:flex-row gap-3 justify-between items-stretch lg:items-center mb-6 font-montserrat">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-3.5 flex items-center text-gray-600 text-xs">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" x-model="search" @input="currentPage = 1"
                        placeholder="Cari berdasarkan nama koleksi atau kategori..."
                        class="w-full bg-[#111111] border border-gray-800 rounded-xl py-3 pl-10 pr-4 text-xs font-medium focus:border-[#e2ca52] focus:outline-none transition-all placeholder-gray-700 text-white">
                </div>

                <div class="shrink-0 flex flex-row flex-wrap lg:flex-nowrap items-center gap-2.5 mt-2 lg:mt-0">
                    <div class="w-full sm:w-44 shrink-0 relative">
                        <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false" type="button"
                            class="w-full bg-[#111111] border border-gray-800 text-gray-300 hover:text-white rounded-xl px-4 py-3 text-xs font-semibold flex items-center justify-between transition focus:outline-none cursor-pointer">

                            <span x-text="selectedCategory === 'Semua' ? 'Semua Kategori' : selectedCategory"></span>

                            <i class="fa-solid fa-chevron-down text-[#e2ca52] text-xs transition-transform duration-300"
                                :class="{ 'rotate-180': dropdownOpen }">
                            </i>
                        </button>

                        <div x-show="dropdownOpen" x-transition.opacity
                            class="absolute left-0 top-full mt-2 bg-[#111111] border border-gray-800 rounded-xl shadow-2xl py-1.5 w-full z-30 text-xs font-medium"
                            style="display: none;">
                            <button @click="selectedCategory = 'Semua'; currentPage = 1; dropdownOpen = false"
                                type="button"
                                class="w-full text-left px-4 py-2.5 text-gray-400 hover:bg-[#161616] hover:text-[#e2ca52] transition">Semua
                                Kategori</button>
                            <button @click="selectedCategory = 'Arkeologika'; currentPage = 1; dropdownOpen = false"
                                type="button"
                                class="w-full text-left px-4 py-2.5 text-gray-400 hover:bg-[#161616] hover:text-[#e2ca52] transition">Arkeologika</button>
                            <button @click="selectedCategory = 'Seni Rupa'; currentPage = 1; dropdownOpen = false"
                                type="button"
                                class="w-full text-left px-4 py-2.5 text-gray-400 hover:bg-[#161616] hover:text-[#e2ca52] transition">Seni
                                Rupa</button>
                            <button @click="selectedCategory = 'Historika'; currentPage = 1; dropdownOpen = false"
                                type="button"
                                class="w-full text-left px-4 py-2.5 text-gray-400 hover:bg-[#161616] hover:text-[#e2ca52] transition">Historika</button>
                            <button @click="selectedCategory = 'Keramologika'; currentPage = 1; dropdownOpen = false"
                                type="button"
                                class="w-full text-left px-4 py-2.5 text-gray-400 hover:bg-[#161616] hover:text-[#e2ca52] transition">Keramologika</button>
                            <button @click="selectedCategory = 'Geologika'; currentPage = 1; dropdownOpen = false"
                                type="button"
                                class="w-full text-left px-4 py-2.5 text-gray-400 hover:bg-[#161616] hover:text-[#e2ca52] transition">Geologika</button>
                        </div>
                    </div>

                    <div class="shrink-0 flex flex-row items-center gap-2 mt-2 lg:mt-0 ml-auto lg:ml-0">
                        <a href="/kelola_barang/cetak_pdf"
                            class="bg-blue-400 hover:bg-blue-500 text-black rounded-xl transition-all flex items-center justify-center min-w-[42px] min-h-[42px] p-2.5 shadow-lg shadow-blue-300/5">
                            <i class="fas fa-file-pdf text-lg"></i>
                        </a>
                        <a href="/tambah_barang"
                            class="bg-[#e2ca52] hover:bg-[#8f7626] text-black rounded-xl transition-all flex items-center justify-center min-w-[42px] min-h-[42px] p-2.5 shadow-lg shadow-[#e2ca52]/5">
                            <i class="fas fa-plus text-lg"></i>
                        </a>
                    </div>

                </div>

            </div>
        </div>

        <div class="bg-[#111111] border border-gray-800 rounded-2xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead
                        class="bg-[#1c1a12] text-[#e2ca52] text-sm uppercase font-bold tracking-wider border-b border-gray-800">
                        <tr>
                            <th class="px-6 py-4 w-20 text-center">No</th>
                            <th class="px-6 py-4 w-20 text-center">ID</th>
                            <th class="px-6 py-4">Nama Barang</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4 text-center">Diubah Oleh</th>
                            <th class="px-6 py-4 text-center">Tanggal Ditambah</th>
                            <th class="px-6 py-4 text-center">Tanggal Diubah</th>
                            <th class="px-6 py-4 w-32 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/50 text-sm">
                        <template x-for="(b, index) in pagedItems" :key="b.id_barang">
                            <tr class="hover:bg-[#141414] transition-colors">
                                <td class="px-6 py-5 font-medium text-gray-500 text-center"
                                    x-text="(currentPage - 1) * itemsPerPage + index + 1"></td>
                                <td class="px-6 py-5 font-mono font-bold text-[#e2ca52] text-center" x-text="b.id_barang">
                                </td>
                                <td class="px-6 py-5 font-medium text-gray-200" x-text="b.nama_barang"></td>
                                <td class="px-6 py-5 font-medium text-gray-400 text-center"
                                    x-text="b.kategori_barang || '-'"></td>
                                <td class="px-6 py-5 text-gray-400 font-medium text-center">
                                    <div class="flex items-center justify-center space-x-1.5">
                                        <i class="fa-solid fa-user text-[#e2ca52]"></i>
                                        <span x-text="b.admin ? b.admin.username : 'Admin'"></span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center text-gray-400 font-medium">
                                    <div x-text="b.created_at ? b.created_at.split(' ')[0] : '-'"></div>
                                    <div x-text="b.created_at ? b.created_at.split(' ')[1] : '-'"></div>
                                </td>

                                <td class="px-6 py-5 text-center text-gray-400 font-medium">
                                    <div x-text="b.updated_at ? b.updated_at.split(' ')[0] : '-'"></div>
                                    <div x-text="b.updated_at ? b.updated_at.split(' ')[1] : '-'"></div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-2">

                                        <button type="button" @click="bukaDetailBarang(b)"
                                            class="bg-gray-800 hover:bg-gray-700 border border-gray-700 text-gray-200 text-xs font-bold h-8 w-8 rounded-lg transition-all flex items-center justify-center shrink-0 cursor-pointer">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <a :href="'/barang/' + b.id_barang + '/edit'"
                                            class="bg-[#e2ca52] hover:bg-[#bfa032] text-black text-xs font-bold h-8 w-8 rounded-lg transition-all flex items-center justify-center shrink-0">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        <form :action="'/barang/' + b.id_barang + '/delete'" method="POST"
                                            class="inline m-0 p-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                @click="konfirmasi($el, 'Hapus Koleksi', 'Apakah Anda yakin ingin menghapus barang ' + b.nama_barang + ' dari database museum?', 'bg-red-600 hover:bg-red-700')"
                                                class="bg-red-950/40 hover:bg-red-900 border border-red-900/60 text-red-400 text-xs font-bold h-8 w-8 rounded-lg transition-all flex items-center justify-center shrink-0 cursor-pointer">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        </template>

                        <tr x-show="filteredItems.length === 0">
                            <td colspan="5" class="p-8 text-center text-xs text-gray-500 italic">
                                Koleksi barang tidak ditemukan atau belum terdaftar.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="px-2 py-4 flex flex-col sm:flex-row items-start gap-4 relative">

            <nav class="flex items-center gap-4">
                <div class="flex items-center gap-2 bg-[#161616] border border-gray-800 p-1 rounded-xl">

                    <button type="button" @click="if(currentPage > 1) currentPage--" :disabled="currentPage === 1"
                        :class="currentPage === 1 ? 'text-gray-700 cursor-not-allowed' : 'text-gray-400 hover:text-yellow-500'"
                        class="p-2 transition focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </button>

                    <template x-for="page in totalPages" :key="page">
                        <button type="button"
                            x-show="page === 1 || page === totalPages || Math.abs(page - currentPage) <= 1"
                            @click="currentPage = page" x-text="page"
                            :class="currentPage === page ? 'bg-yellow-500 text-black font-bold' :
                                'text-gray-400 hover:text-white'"
                            class="px-3 py-1 text-xs font-semibold rounded-lg transition focus:outline-none">
                        </button>
                    </template>

                    <button type="button" @click="if(currentPage < totalPages) currentPage++"
                        :disabled="currentPage === totalPages"
                        :class="currentPage === totalPages ? 'text-gray-700 cursor-not-allowed' :
                            'text-gray-400 hover:text-yellow-500'"
                        class="p-2 transition focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                </div>

                <div class="w-28">
                    <select x-model.number="itemsPerPage" @change="currentPage = 1"
                        class="block w-full px-2.5 py-2 bg-[#161616] border border-gray-800 text-gray-400 text-xs rounded-xl focus:border-[#e2ca52] focus:outline-none shadow-xs cursor-pointer">
                        <option value="5">5 data</option>
                        <option value="10">10 data</option>
                        <option value="25">25 data</option>
                        <option value="50">50 data</option>
                    </select>
                </div>
            </nav>
        </div>

        <div x-show="modalDetailOpen" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="display: none;">
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" @click="modalDetailOpen = false"></div>

            <div @click.away="modalDetailOpen = false"
                class="bg-[#111111] border border-gray-800 w-full max-w-4xl rounded-2xl overflow-hidden shadow-2xl relative z-10 flex flex-col md:flex-row text-left min-h-[400px]">

                <div
                    class="w-full md:w-2/5 bg-white border-b md:border-b-0 md:border-r border-gray-800 flex items-center justify-center p-4 relative min-h-[250px] md:h-auto md:self-stretch overflow-hidden rounded-t-xl md:rounded-tr-none md:rounded-l-xl">

                    <template x-if="selectedBarang && selectedBarang.gambar_barang">
                        <img :src="`/images/koleksi/${selectedBarang.gambar_barang}`" alt="Foto Koleksi"
                            class="max-h-full max-w-full object-contain filter">
                    </template>

                    <template x-if="!selectedBarang || !selectedBarang.gambar_barang">
                        <div class="text-gray-400 flex flex-col items-center gap-2">
                            <i class="fa-regular fa-image text-4xl text-gray-300"></i>
                            <span class="text-xs font-medium">Tidak ada gambar</span>
                        </div>
                    </template>

                </div>

                <div class="w-full md:w-3/5 p-6 flex flex-col justify-between space-y-5 relative">

                    <button type="button" @click="modalDetailOpen = false"
                        class="absolute top-4 right-4 bg-gray-900 hover:bg-gray-800 text-gray-400 h-7 w-7 rounded-full flex items-center justify-center cursor-pointer transition-colors z-20">
                        <i class="fas fa-times text-xs"></i>
                    </button>

                    <div class="space-y-4 pr-6">
                        <div>
                            <h3 class="text-xl sm:text-2xl font-bold text-[#e2ca52] tracking-wide"
                                x-text="selectedBarang?.nama_barang || '-'"></h3>
                        </div>

                        <div
                            class="grid grid-cols-2 gap-x-4 gap-y-3 border-t border-b border-gray-800/60 py-3.5 text-gray-300">
                            <div>
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">Tahun /
                                    Abad</label>
                                <p class="text-xs font-bold text-gray-200 mt-0.5"
                                    x-text="selectedBarang?.tahun_barang || '-'"></p>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">Asal
                                    Wilayah</label>
                                <p class="text-xs font-semibold text-gray-200 mt-0.5 truncate"
                                    x-text="selectedBarang?.asal_barang || '-'"></p>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">Bahan
                                    Baku</label>
                                <p class="text-xs font-semibold text-gray-200 mt-0.5 truncate"
                                    x-text="selectedBarang?.bahan_barang || '-'"></p>
                            </div>
                            <div>
                                <label
                                    class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">Kategori</label>
                                <p class="text-xs font-semibold text-gray-200 mt-0.5 truncate"
                                    x-text="selectedBarang?.kategori_barang || '-'"></p>
                            </div>
                        </div>

                        <div class="max-h-[160px] overflow-y-auto pr-1 custom-scrollbar">
                            <p class="text-xs text-gray-400 leading-relaxed text-justify break-words"
                                x-text="selectedBarang?.deskripsi_barang || 'Tidak ada deskripsi tambahan untuk barang ini.'">
                            </p>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="button" @click="modalDetailOpen = false"
                            class="block w-full text-center bg-gray-900 border border-gray-800 hover:bg-gray-800 text-gray-300 text-xs font-bold py-2.5 rounded-xl transition-all cursor-pointer uppercase tracking-wider">
                            Tutup Rincian Koleksi
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
