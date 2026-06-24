@extends('admin.layouts.admin')
@section('title', 'Kelola Tiket - Museum KASAD')

@section('content')
    <div x-data="kontrolTiketUtama()" class="space-y-6 font-montserrat text-white">
        <div class="space-y-3 mb-6">
            <div class="mb-4">
                <h1 class="text-2xl sm:text-3xl font-bold tracking-wide text-white">Kelola Tiket Pengunjung</h1>
            </div>

            <div class="flex flex-col lg:flex-row gap-3 justify-between items-stretch lg:items-center mb-6 w-full">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-3.5 flex items-center text-gray-600 text-xs">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" x-model="search" @input="currentPage = 1"
                        placeholder="Cari berdasarkan kode tiket atau nama..."
                        class="w-full bg-[#111111] border border-gray-800 rounded-xl py-3 pl-10 pr-4 text-xs font-medium focus:border-[#e2ca52] focus:outline-none transition-all placeholder-gray-700 text-white">
                </div>

                <div class="shrink-0 flex flex-row flex-wrap lg:flex-nowrap items-center gap-2.5 mt-2 lg:mt-0">

                    <div class="w-full sm:w-44 shrink-0 relative">
                        <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false" type="button"
                            class="w-full bg-[#111111] border border-gray-800 text-gray-300 hover:text-white rounded-xl px-4 py-3 text-xs font-semibold flex items-center justify-between transition focus:outline-none cursor-pointer">

                            <span x-text="filterStatus === 'Semua' ? 'Semua Status' : filterStatus"></span>

                            <i class="fa-solid fa-chevron-down text-[#e2ca52] text-xs transition-transform duration-300"
                                :class="{ 'rotate-180': dropdownOpen }"></i>
                        </button>

                        <div x-show="dropdownOpen" x-transition.opacity
                            class="absolute right-0 top-full mt-2 bg-[#111111] border border-gray-800 rounded-xl shadow-2xl py-1.5 w-full z-50 text-xs font-medium"
                            style="display: none;">
                            <button @click="filterStatus = 'Semua'; currentPage = 1; dropdownOpen = false" type="button"
                                class="w-full text-left px-4 py-2.5 text-gray-400 hover:bg-[#161616] hover:text-[#e2ca52] transition-colors">
                                Semua Status
                            </button>
                            <button @click="filterStatus = 'Belum Dipakai'; currentPage = 1; dropdownOpen = false"
                                type="button"
                                class="w-full text-left px-4 py-2.5 text-gray-400 hover:bg-[#161616] hover:text-[#e2ca52] transition-colors">
                                Belum Dipakai
                            </button>
                            <button @click="filterStatus = 'Sudah Dipakai'; currentPage = 1; dropdownOpen = false"
                                type="button"
                                class="w-full text-left px-4 py-2.5 text-gray-400 hover:bg-[#161616] hover:text-[#e2ca52] transition-colors">
                                Sudah Dipakai
                            </button>
                            <button @click="filterStatus = 'Expired'; currentPage = 1; dropdownOpen = false" type="button"
                                class="w-full text-left px-4 py-2.5 text-gray-400 hover:bg-[#161616] hover:text-[#e2ca52] transition-colors">
                                Expired
                            </button>
                        </div>
                    </div>

                    <div class="relative w-full sm:w-44 shrink-0">
                        <input type="date" x-model="filterTanggal" @change="currentPage = 1"
                            title="Filter Tanggal Kunjungan"
                            class="w-full bg-[#111111] border border-gray-800 text-gray-400 hover:text-white rounded-xl px-3 py-3 text-xs font-semibold focus:border-[#e2ca52] focus:outline-none cursor-pointer uppercase tracking-wider transition-all [color-scheme:dark]">
                    </div>

                    <div class="shrink-0 flex items-center mt-2 lg:mt-0 ml-auto lg:ml-0">
                    <a href="/kelola_tiket/cetak_pdf"
                        class="bg-blue-400 hover:bg-blue-500 text-black rounded-xl transition-all flex items-center justify-center min-w-[42px] min-h-[42px] p-2.5 shadow-lg shadow-blue-300/5">
                        <i class="fas fa-file-pdf text-lg"></i>
                    </a>
                </div>
                </div>
            </div>
        </div>

        <div class="bg-[#111111] border border-gray-800 rounded-2xl shadow-2xl overflow-hidden w-full">
            <div class="overflow-x-auto">
                <table class="w-full text-left table-auto">
                    <thead
                        class="bg-[#1c1a12] text-[#e2ca52] text-sm text-center uppercase font-bold tracking-wider border-b border-gray-800">
                        <tr>
                            <th class="px-5 py-4 w-12">No</th>
                            <th class="px-5 py-4">Kode Tiket</th>
                            <th class="px-5 py-4">Nama Pengunjung</th>
                            <th class="px-5 py-4 w-36 text-wrap">Kontak</th>
                            <th class="px-5 py-4">Jumlah Tiket</th>
                            <th class="px-5 py-4">Total Harga</th>
                            <th class="px-5 py-4">Tgl Beli</th>
                            <th class="px-5 py-4">Tgl Kunjungan</th>
                            <th class="px-5 py-4">Sesi</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4 w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/50 text-sm">
                        <template x-for="(t, index) in pagedItems" :key="t.unique_id">
                            <tr class="hover:bg-[#141414] transition-colors"
                                :class="t.status_tiket === 'Sudah Dipakai' || t.status_tiket === 'Expired' ? 'text-gray-500' :
                                    'text-gray-200'">
                                <td class="px-5 py-4 font-bold text-gray-600 text-center"
                                    x-text="(currentPage - 1) * itemsPerPage + index + 1"></td>
                                <td class="px-5 py-4 font-mono font-bold"
                                    :class="t.status_tiket === 'Sudah Dipakai' || t.status_tiket === 'Expired' ?
                                        'line-through text-gray-600' : 'text-[#e2ca52]'"
                                    x-text="t.kode_tiket || '-'"></td>
                                <td class="px-5 py-4 max-w-[200px] font-medium" x-text="t.nama_pengunjung"></td>
                                <td class="px-5 py-4 max-w-[200px]">
                                    <div class="flex flex-col gap-0.5 break-words">
                                        <div class="font-medium" x-text="t.email"></div>
                                        <div class=" text-gray-500 dynamic-telp" x-text="t.no_telp"></div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-left space-y-0.5 whitespace-nowrap">
                                    <template x-if="parseInt(t.jumlah_dewasa) > 0">
                                        <div x-text="t.jumlah_dewasa + 'x Dewasa'"></div>
                                    </template>
                                    <template x-if="parseInt(t.jumlah_anak) > 0">
                                        <div x-text="t.jumlah_anak + 'x Anak'"></div>
                                    </template>
                                    <template x-if="parseInt(t.jumlah_mahasiswa) > 0">
                                        <div x-text="t.jumlah_mahasiswa + 'x Mahasiswa'"></div>
                                    </template>
                                </td>
                                <td class="px-5 py-4 text-center font-bold whitespace-nowrap">Rp <span
                                        x-text="new Intl.NumberFormat('id-ID').format(t.total_harga)"></span></td>
                                <td class="px-5 py-4 text-center font-medium whitespace-nowrap"
                                    x-text="t.tgl_beli ? t.tgl_beli.split(' ')[0] : '-'"></td>
                                <td class="px-5 py-4 text-center font-medium whitespace-nowrap"
                                    x-text="t.tgl_kunjungan ? t.tgl_kunjungan.split(' ')[0] : '-'"></td>
                                
                                <td class="px-5 py-4 text-center font-medium text-[10px] uppercase text-gray-400"
                                    x-text="t.sesi || '-'"></td>

                                <td class="px-5 py-4 text-center font-medium uppercase whitespace-nowrap"
                                    x-text="t.sesi || '-'"></td>

                                <td class="px-5 py-4 text-center">
                                    <span
                                        class="inline-block whitespace-nowrap px-2.5 py-1 rounded-full text-[12px] font-bold uppercase tracking-tighter"
                                        :class="{
                                            'bg-green-950/40 border border-green-800 text-green-400': t
                                                .status_tiket === 'Sudah Dipakai',
                                            'bg-yellow-950/40 border border-yellow-800 text-yellow-400': t
                                                .status_tiket === 'Belum Dipakai',
                                            'bg-red-950/40 border border-red-800 text-red-400': t
                                                .status_tiket === 'Expired'
                                        }">
                                        <span x-text="t.status_tiket"></span>
                                    </span>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" @click="bukaDetail(t)"
                                            class="bg-gray-800 hover:bg-gray-700 border border-gray-700 text-gray-200 text-xs font-bold h-8 w-8 rounded-lg transition-all flex items-center justify-center cursor-pointer">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <template x-if="t.status_tiket === 'Belum Dipakai'">
                                            <form :action="'/tiket/' + t.id_tiket + '/checkin'" method="POST"
                                                class="m-0 p-0">
                                                @csrf @method('PATCH')
                                                <button type="button"
                                                    @click="konfirmasi($el, 'Konfirmasi Check-in', 'Apakah Anda yakin ingin melakukan check-in untuk kode tiket ' + t.kode_tiket + '?', 'bg-green-700 hover:bg-green-600')"
                                                    class="bg-green-700 hover:bg-green-600 text-white text-xs font-bold h-8 w-8 rounded-lg transition-all flex items-center justify-center cursor-pointer">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        </template>
                                    </div>
                                </td>
                            </tr>
                        </template>

                        <tr x-show="pagedItems.length === 0">
                            <td colspan="10" class="p-8 text-center text-xs text-gray-500 italic">Tidak ada data tiket
                                pengunjung yang cocok dengan filter.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div x-show="totalPages > 1" class="px-2 py-2 flex flex-col sm:flex-row items-start gap-4 relative">
            <nav class="flex items-center gap-4">
                <div class="flex items-center gap-2 bg-[#161616] border border-gray-800 p-1 rounded-xl">
                    <button type="button" @click="if(currentPage > 1) currentPage--" :disabled="currentPage === 1"
                        :class="currentPage === 1 ? 'text-gray-700 cursor-not-allowed' : 'text-gray-400 hover:text-yellow-500'"
                        class="p-2 transition focus:outline-none"><svg class="w-5 h-5" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg></button>
                    <template x-for="page in totalPages" :key="page">
                        <button type="button"
                            x-show="page === 1 || page === totalPages || Math.abs(page - currentPage) <= 1"
                            @click="currentPage = page" x-text="page"
                            :class="currentPage === page ? 'bg-yellow-500 text-black font-bold' : 'text-gray-400 hover:text-white'"
                            class="px-3 py-1 text-xs font-semibold rounded-lg transition focus:outline-none"></button>
                    </template>
                    <button type="button" @click="if(currentPage < totalPages) currentPage++"
                        :disabled="currentPage === totalPages"
                        :class="currentPage === totalPages ? 'text-gray-700 cursor-not-allowed' : 'text-gray-400 hover:text-yellow-500'"
                        class="p-2 transition focus:outline-none"><svg class="w-5 h-5" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg></button>
                </div>
                <div class="w-28">
                    <select x-model="itemsPerPage" @change="currentPage = 1"
                        class="block w-full px-2.5 py-2 bg-[#161616] border border-gray-800 text-gray-400 text-xs rounded-xl focus:border-[#e2ca52] focus:outline-none shadow-xs cursor-pointer">
                        <option value="5">5 rows</option>
                        <option value="10">10 rows</option>
                        <option value="25">25 rows</option>
                    </select>
                </div>
            </nav>
        </div>

        <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="display: none;">
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" @click="modalOpen = false"></div>
            <div @click.away="modalOpen = false"
                class="bg-[#111111] border border-gray-800 w-full max-w-md rounded-2xl overflow-hidden shadow-2xl relative z-10 p-6 space-y-5 text-left">
                <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                    <div>
                        <h3 class="text-lg font-bold text-white tracking-wide">Detail Tiket Masuk</h3>
                        <p class="text-[14px] font-bold mt-0.5"
                            :class="{
                                'text-green-500': selectedTiket?.status_tiket === 'Sudah Dipakai',
                                'text-yellow-500': selectedTiket?.status_tiket === 'Belum Dipakai',
                                'text-red-500': selectedTiket?.status_tiket === 'Expired'
                            }">
                            Status: Tiket <span x-text="selectedTiket?.status_tiket"></span>
                        </p>
                    </div>
                    <button type="button" @click="modalOpen = false"
                        class="bg-gray-900 hover:bg-gray-800 text-gray-400 h-7 w-7 rounded-full flex items-center justify-center cursor-pointer"><i
                            class="fas fa-times text-xs"></i></button>
                </div>
                <div class="space-y-3 text-gray-300">
                    <div><label class="text-[12px] font-bold text-gray-500 uppercase block">Nama Pengunjung</label>
                        <p class="text-sm font-semibold text-gray-200" x-text="selectedTiket?.nama_pengunjung || '-'"></p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div><label class="text-[12px] font-bold text-gray-500 uppercase block">Email</label>
                            <p class="text-xs font-medium break-words" x-text="selectedTiket?.email || '-'"></p>
                        </div>
                        <div><label class="text-[12px] font-bold text-gray-500 uppercase block">No. Telepon</label>
                            <p class="text-xs font-medium" x-text="selectedTiket?.no_telp || '-'"></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 pt-2 border-t border-gray-800/40">
                        <div><label class="text-[12px] font-bold text-gray-500 uppercase block">Tanggal Kunjungan</label>
                            <p class="text-xs font-medium"
                                x-text="selectedTiket?.tgl_kunjungan ? selectedTiket.tgl_kunjungan.split(' ')[0] : '-'">
                            </p>
                        </div>
                        <div><label class="text-[12px] font-bold text-gray-500 uppercase block">Sesi Kunjungan</label>
                            <p class="text-xs font-bold text-[#e2ca52]" x-text="selectedTiket?.sesi || '-'"></p>
                        </div>
                    </div>
                    <div class="pt-2">
                        <label class="text-[12px] font-bold text-gray-500 uppercase block">Metode Pembayaran</label>
                        <p class="text-xs font-medium text-white uppercase"
                            x-text="selectedTiket?.metode_pembayaran || '-'"></p>
                    </div>

                </div>
                <div class="bg-[#161616] border border-gray-800/60 rounded-xl p-3 space-y-2 text-gray-300 font-medium">
                    <template x-if="selectedTiket && parseInt(selectedTiket.jumlah_dewasa) > 0">
                        <div class="grid grid-cols-2 text-xs py-0.5"><span
                                x-text="selectedTiket.jumlah_dewasa + 'x Tiket Dewasa'"></span><span
                                class="text-right font-mono"
                                x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(selectedTiket.jumlah_dewasa * 25000)"></span>
                        </div>
                    </template>
                    <template x-if="selectedTiket && parseInt(selectedTiket.jumlah_anak) > 0">
                        <div class="grid grid-cols-2 text-xs py-0.5"><span
                                x-text="selectedTiket.jumlah_anak + 'x Tiket Anak'"></span><span
                                class="text-right font-mono"
                                x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(selectedTiket.jumlah_anak * 10000)"></span>
                        </div>
                    </template>
                    <template x-if="selectedTiket && parseInt(selectedTiket.jumlah_mahasiswa) > 0">
                        <div class="grid grid-cols-2 text-xs py-0.5"><span
                                x-text="selectedTiket.jumlah_mahasiswa + 'x Tiket Mahasiswa'"></span><span
                                class="text-right font-mono"
                                x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(selectedTiket.jumlah_mahasiswa * 15000)"></span>
                        </div>
                    </template>
                    <div class="flex justify-between items-center text-xs pt-2 border-t border-gray-800/80 font-bold"><span
                            class="text-gray-300">Total Bayar</span><span class="text-white text-sm font-mono">Rp <span
                                x-text="selectedTiket ? new Intl.NumberFormat('id-ID').format(selectedTiket.total_harga) : '0'"></span></span>
                    </div>
                </div>
                <button type="button" @click="modalOpen = false"
                    class="block w-full text-center bg-gray-900 border border-gray-800 text-gray-300 text-xs font-bold py-2.5 rounded-xl cursor-pointer uppercase">Tutup
                    Rincian</button>
            </div>
        </div>
    </div>

    <script>
        function kontrolTiketUtama() {
            const hariIni = new Date().toISOString().split('T')[0];

            const dataBelum = (@json($tiketBelumDipakai) || []).map(i => {
                const tglExpired = i.expired_at ? i.expired_at.split(' ')[0] : '';
                const expired = tglExpired && tglExpired < hariIni;

                return {
                    ...i,
                    // Jika lewat tanggal, status_tiket diubah jadi 'Expired' di frontend
                    status_tiket: expired ? 'Expired' : i.status_tiket,
                    unique_id: 'b-' + i.id_tiket
                };
            });

            const dataSudah = (@json($tiketSudahDipakai) || []).map(i => ({
                ...i,
                // dataSudah tetap pakai status_tiket asli ('Sudah Dipakai')
                unique_id: 's-' + i.id_tiket
            }));

            return {
                search: '',
                filterTanggal: '',
                filterStatus: 'Semua',
                dropdownOpen: false,
                modalOpen: false,
                selectedTiket: null,
                currentPage: 1,
                itemsPerPage: 10,
                allItems: [...dataBelum, ...dataSudah],

                get filteredItems() {
                    return this.allItems.filter(item => {
                        const keyword = this.search.toLowerCase();
                        const kode = item.kode_tiket ? item.kode_tiket.toLowerCase() : '';
                        const nama = item.nama_pengunjung ? item.nama_pengunjung.toLowerCase() : '';
                        const cocokSearch = kode.includes(keyword) || nama.includes(keyword);

                        // Filter status sekarang langsung mengecek item.status_tiket
                        const cocokStatus = this.filterStatus === 'Semua' || item.status_tiket === this
                            .filterStatus;

                        const tglData = item.tgl_kunjungan ? item.tgl_kunjungan.split(' ')[0] : '';
                        const cocokTanggal = !this.filterTanggal || tglData === this.filterTanggal;
                        return cocokSearch && cocokStatus && cocokTanggal;
                    });
                },

                get pagedItems() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    return this.filteredItems.slice(start, start + this.itemsPerPage);
                },

                get totalPages() {
                    return Math.ceil(this.filteredItems.length / this.itemsPerPage) || 1;
                },

                bukaDetail(tiket) {
                    this.selectedTiket = tiket;
                    this.modalOpen = true;
                }
            }
        }
    </script>
@endsection