@extends('layouts.app')

@section('content')
<div x-data="{
        // Data Pemesan
        pemesan: {
            nama: '',
            telepon: '',
            email: ''
        },
        
        // Harga dan Jumlah Tiket
        tiket: {
            dewasa: { harga: 25000, jumlah: 0 },
            pelajar: { harga: 15000, jumlah: 0 },
            anak: { harga: 10000, jumlah: 0 }
        },
        tanggal: '',
        errorHari: false,
        metodeBayar: 'transfer',
        
        // Fungsi Validasi Hari (Hanya Senin=1, Selasa=2, Rabu=3)
        validasiHari(e) {
            if (!e.target.value) return;
            const date = new Date(e.target.value);
            const day = date.getDay();
            
            if(day !== 1 && day !== 2 && day !== 3) {
                this.errorHari = true;
                this.tanggal = ''; 
            } else {
                this.errorHari = false;
            }
        },

        // Kalkulasi Total Harga Secara Real-time
        get totalHarga() {
            return (this.tiket.dewasa.jumlah * this.tiket.dewasa.harga) +
                   (this.tiket.pelajar.jumlah * this.tiket.pelajar.harga) +
                   (this.tiket.anak.jumlah * this.tiket.anak.harga);
        },

        // Cek apakah semua form wajib sudah terisi
        get isFormValid() {
            return this.pemesan.nama !== '' && 
                   this.pemesan.telepon !== '' && 
                   this.pemesan.email !== '' && 
                   this.tanggal !== '' && 
                   this.totalHarga > 0;
        },

        // Format angka ke Rupiah
        formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
        }
    }" 
    class="relative min-h-screen text-white pt-32 pb-16 font-sans bg-cover bg-center bg-fixed bg-no-repeat"
    style="background-image: linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.9)), url('{{ asset('images/bg-tiket.png') }}');">

    <div class="container mx-auto px-6 md:px-12 relative z-10">
        <h1 class="text-3xl md:text-4xl font-serif text-yellow-500 tracking-widest mb-10 text-center">PEMESANAN TIKET</h1>

        <div class="flex flex-col lg:flex-row gap-10">
            
            <div class="w-full lg:w-2/3 space-y-10">
                
                <div class="bg-[#111111]/90 backdrop-blur-sm border border-gray-800 p-8 rounded-xl shadow-lg">
                    <h2 class="text-xl font-serif text-yellow-500 tracking-wider mb-6 flex items-center gap-3">
                        <span class="bg-yellow-500 text-black w-8 h-8 flex items-center justify-center rounded-full font-bold text-sm">1</span>
                        DATA PEMESANAN
                    </h2>
                    
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm text-gray-400 mb-2 tracking-wide">Nama Lengkap</label>
                            <input type="text" x-model="pemesan.nama" placeholder="Masukkan nama lengkap sesuai identitas" class="w-full bg-[#1A1A1A] border border-gray-800 p-4 rounded-lg text-white focus:outline-none focus:border-yellow-500 transition">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm text-gray-400 mb-2 tracking-wide">Nomor Telepon / WA</label>
                                <input type="number" x-model="pemesan.telepon" placeholder="Contoh: 08123456789" class="w-full bg-[#1A1A1A] border border-gray-800 p-4 rounded-lg text-white focus:outline-none focus:border-yellow-500 transition">
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-2 tracking-wide">Alamat Email</label>
                                <input type="email" x-model="pemesan.email" placeholder="Contoh: email@domain.com" class="w-full bg-[#1A1A1A] border border-gray-800 p-4 rounded-lg text-white focus:outline-none focus:border-yellow-500 transition">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-[#111111]/90 backdrop-blur-sm border border-gray-800 p-8 rounded-xl shadow-lg">
                    <h2 class="text-xl font-serif text-yellow-500 tracking-wider mb-6 flex items-center gap-3">
                        <span class="bg-yellow-500 text-black w-8 h-8 flex items-center justify-center rounded-full font-bold text-sm">2</span>
                        PILIH TIKET
                    </h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center bg-[#1A1A1A] p-5 rounded-lg border border-gray-800">
                            <div>
                                <h3 class="font-bold text-lg tracking-wide">Tiket Dewasa</h3>
                                <p class="text-gray-400 text-sm">IDR 25.000 / orang</p>
                            </div>
                            <div class="flex items-center gap-5">
                                <button @click="if(tiket.dewasa.jumlah > 0) tiket.dewasa.jumlah--" class="w-10 h-10 rounded-full bg-gray-800 hover:bg-yellow-500 hover:text-black transition flex items-center justify-center text-xl font-bold focus:outline-none">&minus;</button>
                                <span x-text="tiket.dewasa.jumlah" class="text-xl font-bold w-6 text-center"></span>
                                <button @click="tiket.dewasa.jumlah++" class="w-10 h-10 rounded-full bg-gray-800 hover:bg-yellow-500 hover:text-black transition flex items-center justify-center text-xl font-bold focus:outline-none">&plus;</button>
                            </div>
                        </div>

                        <div class="flex justify-between items-center bg-[#1A1A1A] p-5 rounded-lg border border-gray-800">
                            <div>
                                <h3 class="font-bold text-lg tracking-wide">Tiket Pelajar / Mahasiswa</h3>
                                <p class="text-gray-400 text-sm">IDR 15.000 / orang</p>
                            </div>
                            <div class="flex items-center gap-5">
                                <button @click="if(tiket.pelajar.jumlah > 0) tiket.pelajar.jumlah--" class="w-10 h-10 rounded-full bg-gray-800 hover:bg-yellow-500 hover:text-black transition flex items-center justify-center text-xl font-bold focus:outline-none">&minus;</button>
                                <span x-text="tiket.pelajar.jumlah" class="text-xl font-bold w-6 text-center"></span>
                                <button @click="tiket.pelajar.jumlah++" class="w-10 h-10 rounded-full bg-gray-800 hover:bg-yellow-500 hover:text-black transition flex items-center justify-center text-xl font-bold focus:outline-none">&plus;</button>
                            </div>
                        </div>

                        <div class="flex justify-between items-center bg-[#1A1A1A] p-5 rounded-lg border border-gray-800">
                            <div>
                                <h3 class="font-bold text-lg tracking-wide">Tiket Anak-anak</h3>
                                <p class="text-gray-400 text-sm">IDR 10.000 / orang</p>
                            </div>
                            <div class="flex items-center gap-5">
                                <button @click="if(tiket.anak.jumlah > 0) tiket.anak.jumlah--" class="w-10 h-10 rounded-full bg-gray-800 hover:bg-yellow-500 hover:text-black transition flex items-center justify-center text-xl font-bold focus:outline-none">&minus;</button>
                                <span x-text="tiket.anak.jumlah" class="text-xl font-bold w-6 text-center"></span>
                                <button @click="tiket.anak.jumlah++" class="w-10 h-10 rounded-full bg-gray-800 hover:bg-yellow-500 hover:text-black transition flex items-center justify-center text-xl font-bold focus:outline-none">&plus;</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-[#111111]/90 backdrop-blur-sm border border-gray-800 p-8 rounded-xl shadow-lg">
                    <h2 class="text-xl font-serif text-yellow-500 tracking-wider mb-6 flex items-center gap-3">
                        <span class="bg-yellow-500 text-black w-8 h-8 flex items-center justify-center rounded-full font-bold text-sm">3</span>
                        TANGGAL KUNJUNGAN
                    </h2>
                    
                    <div class="relative">
                        <input type="date" x-model="tanggal" @change="validasiHari($event)" class="w-full bg-[#1A1A1A] border border-gray-800 p-4 rounded-lg text-white focus:outline-none focus:border-yellow-500 transition cursor-pointer [color-scheme:dark]">
                        
                        <div x-show="errorHari" x-transition class="mt-3 flex items-center gap-2 text-red-500 bg-red-500/10 p-3 rounded border border-red-500/20" style="display: none;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <span class="text-sm">Mohon maaf, museum hanya beroperasi pada hari <strong>Senin, Selasa, dan Rabu</strong>.</span>
                        </div>
                    </div>
                </div>

                <div class="bg-[#111111]/90 backdrop-blur-sm border border-gray-800 p-8 rounded-xl shadow-lg">
                    <h2 class="text-xl font-serif text-yellow-500 tracking-wider mb-6 flex items-center gap-3">
                        <span class="bg-yellow-500 text-black w-8 h-8 flex items-center justify-center rounded-full font-bold text-sm">4</span>
                        METODE PEMBAYARAN
                    </h2>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="relative w-full sm:w-1/2">
                            <select x-model="metodeBayar" class="w-full bg-[#1A1A1A] border border-gray-800 p-4 rounded-lg text-white appearance-none focus:outline-none focus:border-yellow-500 cursor-pointer">
                                <option value="transfer">Bank Transfer</option>
                                <option value="qris">QRIS</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        <div x-show="metodeBayar === 'transfer'" class="w-full sm:w-1/2">
                            <input type="text" placeholder="Masukkan Nomor Rekening" class="w-full bg-[#1A1A1A] border border-gray-800 p-4 rounded-lg text-white focus:outline-none focus:border-yellow-500 transition">
                        </div>
                    </div>
                </div>

            </div>

            <div class="w-full lg:w-1/3">
                <div class="bg-[#1C1C1C]/95 backdrop-blur-md border border-gray-800 p-8 rounded-xl shadow-2xl sticky top-32">
                    <h2 class="text-xl font-serif text-yellow-500 tracking-wider border-b border-gray-800 pb-4 mb-6">RINGKASAN TIKET</h2>
                    
                    <div class="mb-6 pb-6 border-b border-gray-800">
                        <span class="text-xs text-gray-500 uppercase tracking-wider block mb-1">Pemesan</span>
                        <span x-text="pemesan.nama ? pemesan.nama : '-'" class="font-medium text-gray-200"></span>
                    </div>

                    <div class="space-y-4 mb-6 text-sm">
                        <div x-show="tiket.dewasa.jumlah > 0" class="flex justify-between" style="display: none;">
                            <span class="text-gray-300"><span x-text="tiket.dewasa.jumlah"></span>x Dewasa</span>
                            <span x-text="formatRupiah(tiket.dewasa.jumlah * tiket.dewasa.harga)" class="font-medium"></span>
                        </div>
                        <div x-show="tiket.pelajar.jumlah > 0" class="flex justify-between" style="display: none;">
                            <span class="text-gray-300"><span x-text="tiket.pelajar.jumlah"></span>x Pelajar</span>
                            <span x-text="formatRupiah(tiket.pelajar.jumlah * tiket.pelajar.harga)" class="font-medium"></span>
                        </div>
                        <div x-show="tiket.anak.jumlah > 0" class="flex justify-between" style="display: none;">
                            <span class="text-gray-300"><span x-text="tiket.anak.jumlah"></span>x Anak</span>
                            <span x-text="formatRupiah(tiket.anak.jumlah * tiket.anak.harga)" class="font-medium"></span>
                        </div>
                        
                        <div x-show="totalHarga === 0" class="text-gray-600 text-center italic py-4">
                            Belum ada tiket yang dipilih.
                        </div>
                    </div>

                    <div class="border-t border-gray-800 pt-4 mb-6">
                        <span class="text-xs text-gray-500 uppercase tracking-wider block mb-1">Tanggal Kunjungan</span>
                        <span x-text="tanggal ? new Date(tanggal).toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) : '-'" class="font-medium text-yellow-500"></span>
                    </div>

                    <div class="border-t border-gray-800 pt-4 mb-8 flex justify-between items-end">
                        <span class="text-gray-400 font-bold tracking-wider">TOTAL</span>
                        <span x-text="formatRupiah(totalHarga)" class="text-3xl font-bold text-white tracking-wide"></span>
                    </div>

                    <button 
                        :disabled="!isFormValid"
                        :class="!isFormValid ? 'bg-gray-800 text-gray-500 cursor-not-allowed' : 'bg-yellow-500 hover:bg-yellow-400 text-black hover:-translate-y-1 shadow-lg shadow-yellow-500/20'"
                        class="w-full py-4 rounded-lg font-bold tracking-widest transition-all duration-300"
                    >
                        BAYAR SEKARANG
                    </button>
                    
                    <p x-show="!isFormValid" class="text-xs text-red-500 mt-4 text-center">
                        *Lengkapi data pemesanan, tiket, dan tanggal kunjungan untuk melanjutkan pembayaran.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

@include('components.footer')
@endsection