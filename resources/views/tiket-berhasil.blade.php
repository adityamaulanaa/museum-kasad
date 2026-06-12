@extends('layouts.app')

@section('content')
<!-- Background menggunakan gambar interior museum yang digelapkan -->
<div class="relative min-h-screen text-white pt-32 pb-24 font-sans bg-cover bg-center bg-fixed bg-no-repeat flex flex-col items-center"
     style="background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.95)), url('{{ asset('images/bg-1.jpg') }}');">

    <div class="container mx-auto px-6 relative z-10 flex flex-col items-center w-full max-w-3xl">
        
        <!-- Ikon Centang Berhasil -->
        <div class="w-20 h-20 rounded-full border border-yellow-500 flex items-center justify-center mb-6 shadow-[0_0_15px_rgba(234,179,8,0.2)]">
            <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <!-- Judul Berhasil -->
        <h1 class="text-3xl md:text-4xl font-bold tracking-widest text-white mb-2 uppercase text-center">PEMBAYARAN BERHASIL</h1>
        <p class="text-gray-300 font-serif text-lg tracking-wide text-center mb-12">Terima kasih, Tiket anda telah dipesan</p>

        <!-- Box Tiket Utama -->
        <div class="w-full bg-black/60 backdrop-blur-md border border-yellow-600 rounded-2xl flex flex-col md:flex-row overflow-hidden shadow-2xl">
            
            <!-- Sisi Kiri: Detail Pameran -->
            <div class="w-full md:w-2/3 p-8 md:p-10 flex flex-col justify-center">
                <h2 class="text-xl md:text-2xl font-serif tracking-widest text-white mb-8">Pameran Museum KASAD</h2>
                
                <div class="space-y-5 text-sm md:text-base font-medium tracking-wide text-gray-200">
                    <!-- Tanggal -->
                    <div class="flex items-center gap-4">
                        <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Senin, 11 Mei 2026</span>
                    </div>
                    
                    <!-- Waktu -->
                    <div class="flex items-center gap-4">
                        <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>10.00 - 16.00 WIB</span>
                    </div>
                    
                    <!-- Lokasi -->
                    <div class="flex items-center gap-4">
                        <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Museum KASAD</span>
                    </div>
                    
                    <!-- Jumlah Pengunjung -->
                    <div class="flex items-center gap-4">
                        <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span>2x Dewasa, 1x Anak-anak</span>
                    </div>
                </div>
            </div>

            <!-- Sisi Kanan: QR Code & Kode Tiket -->
            <!-- Diberi border kiri untuk layar besar, dan border atas untuk layar HP -->
            <div class="w-full md:w-1/3 p-8 border-t md:border-t-0 md:border-l border-yellow-600/50 flex flex-col items-center justify-center bg-black/40">
                
                <!-- Kotak QR Code berlatar putih agar mudah di-scan -->
                <div class="bg-white p-3 rounded-xl mb-4 w-40 h-40 flex items-center justify-center">
                    <!-- Pastikan Anda menyimpan gambar QR dummy di folder public/images -->
                    <img src="{{ asset('images/qr-dummy.png') }}" alt="QR Code" class="w-full h-full object-contain">
                </div>
                
                <p class="text-xs text-gray-400 font-serif tracking-widest mb-1">Kode Tiket</p>
                <p class="text-yellow-500 font-bold tracking-wider text-sm md:text-base text-center break-all">
                    KASAD121123131133150
                </p>
            </div>
            
        </div>
        
        <!-- Tombol Kembali ke Beranda -->
        <a href="{{ route('home') }}" class="mt-12 text-sm text-gray-400 hover:text-yellow-500 transition border-b border-transparent hover:border-yellow-500 pb-1 tracking-widest">
            KEMBALI KE BERANDA
        </a>

    </div>
</div>

<!-- ================== FOOTER ================== -->
@include('components.footer')
@endsection