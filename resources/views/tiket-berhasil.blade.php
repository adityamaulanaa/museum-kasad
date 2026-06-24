@extends('layouts.app')

@section('content')
<div class="relative min-h-screen text-white pt-32 pb-24 font-sans bg-cover bg-center bg-fixed bg-no-repeat flex flex-col items-center"
     style="background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.95)), url('{{ asset('images/bg-1.jpg') }}');">

    <div class="container mx-auto px-6 relative z-10 flex flex-col items-center w-full max-w-3xl">
        
        <div class="w-20 h-20 rounded-full border border-yellow-500 flex items-center justify-center mb-6 shadow-[0_0_15px_rgba(234,179,8,0.2)]">
            <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <h1 class="text-3xl md:text-4xl font-bold tracking-widest text-white mb-2 uppercase text-center">PEMBAYARAN BERHASIL</h1>
        <p class="text-gray-300 font-serif text-lg tracking-wide text-center mb-12">Terima kasih, Tiket anda telah dipesan</p>

        <div id="tiket-card" class="w-full bg-[#111111] border border-yellow-600 rounded-2xl flex flex-col md:flex-row overflow-hidden shadow-2xl">
            
            <div class="w-full md:w-2/3 p-8 md:p-10 flex flex-col justify-center">
                <h2 class="text-xl md:text-2xl font-serif tracking-widest text-yellow-500 mb-8">Pameran Museum KASAD</h2>
                
                <div class="space-y-5 text-sm md:text-base font-medium tracking-wide text-gray-200">
                    <div class="flex items-center gap-4">
                        <svg class="w-6 h-6 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="whitespace-nowrap">{{ \Carbon\Carbon::parse($tiket->tgl_kunjungan)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <svg class="w-6 h-6 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>{{ $tiket->sesi }}</span>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <svg class="w-6 h-6 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Museum KASAD</span>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <svg class="w-6 h-6 text-yellow-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="whitespace-nowrap">
                            @if($tiket->jumlah_dewasa > 0) {{ $tiket->jumlah_dewasa }}x Dewasa @endif
                            @if($tiket->jumlah_mahasiswa > 0) | {{ $tiket->jumlah_mahasiswa }}x Mahasiswa @endif
                            @if($tiket->jumlah_anak > 0) | {{ $tiket->jumlah_anak }}x Anak @endif
                        </span>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/3 p-8 border-t md:border-t-0 md:border-l border-yellow-600/50 flex flex-col items-center justify-center bg-black/40">
                <div class="bg-white p-3 rounded-xl mb-5 w-40 h-40 flex items-center justify-center flex-shrink-0">
                    @php
                        $rincian = [];
                        if($tiket->jumlah_dewasa > 0) $rincian[] = $tiket->jumlah_dewasa . ' Dewasa';
                        if($tiket->jumlah_mahasiswa > 0) $rincian[] = $tiket->jumlah_mahasiswa . ' Pelajar';
                        if($tiket->jumlah_anak > 0) $rincian[] = $tiket->jumlah_anak . ' Anak';
                        $rincian_tiket = implode(', ', $rincian);

                        $dataQr = json_encode([
                            'Kode' => $tiket->kode_tiket,
                            'Nama' => $tiket->nama_pengunjung,
                            'Sesi' => $tiket->sesi,
                            'Tanggal' => \Carbon\Carbon::parse($tiket->tgl_kunjungan)->format('d-m-Y'),
                            'Tiket' => $rincian_tiket,
                            'Total' => 'Rp ' . number_format($tiket->total_harga, 0, ',', '.')
                        ]);
                    @endphp
                    {!! QrCode::size(130)->generate($dataQr) !!}
                </div>
                
                <div class="text-center w-full">
                    <p class="text-xs text-gray-400 font-serif tracking-widest mb-2 whitespace-nowrap block">Kode Tiket</p>
                    <p class="text-yellow-500 font-bold tracking-wider text-sm md:text-base break-all leading-normal">
                        {{ $tiket->kode_tiket }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="mt-12 w-full flex flex-col items-center">
            <p class="text-gray-400 text-sm mb-4">Pilih format unduhan tiket Anda:</p>
            
            <div class="flex flex-col sm:flex-row flex-wrap justify-center gap-4 w-full">
                <a href="{{ route('tiket.pdf', $tiket->id_tiket) }}" class="bg-black border-2 border-yellow-500 text-yellow-500 hover:bg-yellow-500 hover:text-black font-bold tracking-widest px-6 py-3 rounded-xl transition-all flex items-center justify-center gap-2 text-sm w-full sm:w-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    UNDUH PDF
                </a>
                
                <button type="button" onclick="unduhGambar('png')" class="bg-black border-2 border-yellow-500 text-yellow-500 hover:bg-yellow-500 hover:text-black font-bold tracking-widest px-6 py-3 rounded-xl transition-all flex items-center justify-center gap-2 text-sm w-full sm:w-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    UNDUH PNG
                </button>

                <button type="button" onclick="unduhGambar('jpg')" class="bg-black border-2 border-yellow-500 text-yellow-500 hover:bg-yellow-500 hover:text-black font-bold tracking-widest px-6 py-3 rounded-xl transition-all flex items-center justify-center gap-2 text-sm w-full sm:w-auto">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    UNDUH JPG
                </button>
            </div>

            <a href="{{ route('home') }}" class="mt-8 text-sm text-gray-400 hover:text-yellow-500 transition border-b border-transparent hover:border-yellow-500 pb-1 tracking-widest">
                KEMBALI KE BERANDA
            </a>
        </div>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html-to-image/1.11.11/html-to-image.min.js"></script>
<script>
    function unduhGambar(format) {
        const tiketCard = document.getElementById('tiket-card');
        
        const config = {
            pixelRatio: 2, 
            backgroundColor: '#111111' 
        };

        let prosesUnduh;
        
        if (format === 'png') {
            prosesUnduh = htmlToImage.toPng(tiketCard, config);
        } else {
            prosesUnduh = htmlToImage.toJpeg(tiketCard, Object.assign({}, config, { quality: 0.95 }));
        }

        prosesUnduh.then(function (dataUrl) {
            let link = document.createElement('a');
            link.download = 'Tiket-Museum-KASAD-{{ $tiket->kode_tiket }}.' + format;
            link.href = dataUrl;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }).catch(function (error) {
            alert('Gagal mengunduh gambar. Silakan coba lagi.');
            console.error('Error html-to-image:', error);
        });
    }
</script>

@include('components.footer')
@endsection