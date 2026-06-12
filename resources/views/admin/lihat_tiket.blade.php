@extends('admin.layouts.admin')
@section('title', 'Kelola Tiket - Museum KASAD')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white">
                    Kelola Tiket 
                </h1>
            </div>

            <button onclick="window.print()"
                class="bg-[#d4af37] hover:bg-[#bfa032] text-black text-xs font-bold px-5 py-3 rounded-xl transition-all uppercase tracking-wider flex items-center justify-center space-x-2 shrink-0 cursor-pointer font-montserrat">
                <i class="fas fa-print text-xs"></i>
                <span>Cetak Laporan</span>
            </button>
        </div>

        <div class="bg-[#111111] border border-gray-800 rounded-2xl shadow-2xl overflow-hidden w-full font-montserrat">
            <div class="overflow-x-auto">
                <table class="w-full text-left table-auto">
                    <thead class="bg-[#1c1a12] text-[#e2ca52] text-xs uppercase font-bold tracking-wider border-b border-gray-800">
                        <tr>
                            <th class="px-5 py-4 text-center w-12">No</th>
                            <th class="px-5 py-4">Nama Pengunjung</th>
                            <th class="px-5 py-4">Kontak</th>
                            <th class="px-5 py-4 text-center">Jumlah Tiket (D/A/M)</th>
                            <th class="px-5 py-4 text-center">Bayar via</th>
                            <th class="px-5 py-4 text-center">Tgl Kunjungan</th>
                            <th class="px-5 py-4 text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/50 text-sm">
                        @foreach ($tikets as $index => $t)
                            <tr class="hover:bg-[#141414] transition-colors text-xs">
                                <td class="px-5 py-4 font-bold text-gray-500 text-center">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-5 py-4 font-medium text-gray-200">
                                    {{ $t->nama_pengunjung }}
                                </td>

                                <td class="px-5 py-4 text-gray-400">
                                    <div class="font-medium text-gray-300">{{ $t->email }}</div>
                                    <div class="text-[10px] text-gray-500 mt-0.5">{{ $t->no_telp }}</div>
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <span class="bg-gray-950 border border-gray-800 text-gray-300 px-2.5 py-1 rounded-md font-mono font-bold text-[11px]">
                                        {{ $t->jumlah_dewasa }}D / {{ $t->jumlah_anak }}A / {{ $t->jumlah_mahasiswa }}M
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-center font-bold tracking-wider text-[#e2ca52] uppercase text-[11px]">
                                    {{ $t->metode_pembayaran }}
                                </td>

                                <td class="px-5 py-4 text-center text-gray-400 font-medium">
                                    {{ date('d-m-Y', strtotime($t->tgl_kunjungan)) }}
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center space-x-2">
                                        <label for="ticket-modal-{{ $t->id_tiket }}" 
                                            class="bg-gray-800 hover:bg-gray-700 text-gray-200 text-[10px] font-bold px-3 py-2 rounded-lg transition-all uppercase tracking-tighter flex items-center space-x-1 shrink-0 cursor-pointer select-none">
                                            <i class="fa-solid fa-eye"></i>
                                            <span>Detail</span>
                                        </label>

                                        <form action="/tiket/{{ $t->id_tiket }}/delete" method="POST"
                                            onsubmit="return confirm('Yakin mau hapus tiket ini?')" class="m-0 p-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-950/40 hover:bg-red-900 border border-red-900 text-red-400 text-[10px] font-bold px-3 py-2 rounded-lg transition-all uppercase tracking-tighter flex items-center justify-center cursor-pointer">
                                                <i class="fa-solid fa-trash-can mr-1"></i>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <input type="checkbox" id="ticket-modal-{{ $t->id_tiket }}" class="hidden peer/tiket">

                            <div class="fixed inset-0 z-50 hidden peer-checked/tiket:flex items-center justify-center p-4">
                                <label for="ticket-modal-{{ $t->id_tiket }}" class="fixed inset-0 bg-black/80 backdrop-blur-sm cursor-pointer"></label>

                                <div class="bg-[#111111] border border-gray-800 w-full max-w-md rounded-2xl overflow-hidden shadow-2xl relative z-10 font-montserrat p-6 space-y-5 text-left">
                                    
                                    <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                                        <div>
                                            <h3 class="text-lg font-bold text-white tracking-wide">Detail Tiket Masuk</h3>
                                            <p class="text-[10px] text-gray-500 font-mono mt-0.5">ID Tiket: #TK-00{{ $t->id_tiket }}</p>
                                        </div>
                                        <label for="ticket-modal-{{ $t->id_tiket }}" class="bg-gray-900 hover:bg-gray-800 text-gray-400 hover:text-white h-7 w-7 rounded-full flex items-center justify-center transition-colors cursor-pointer">
                                            <i class="fas fa-times text-xs"></i>
                                        </label>
                                    </div>

                                    <div class="space-y-3">
                                        <div>
                                            <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">Nama Pengunjung</label>
                                            <p class="text-sm font-semibold text-gray-200 mt-0.5">{{ $t->nama_pengunjung }}</p>
                                        </div>

                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">Email</label>
                                                <p class="text-xs text-gray-300 mt-0.5 font-medium truncate">{{ $t->email }}</p>
                                            </div>
                                            <div>
                                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">No. Telepon</label>
                                                <p class="text-xs text-gray-300 mt-0.5 font-mono">{{ $t->no_telp }}</p>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-3 pt-2 border-t border-gray-800/40">
                                            <div>
                                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">Metode Pembayaran</label>
                                                <p class="text-xs font-bold text-[#e2ca52] uppercase mt-0.5">{{ $t->metode_pembayaran }}</p>
                                            </div>
                                            <div>
                                                <label class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">Tanggal Kunjungan</label>
                                                <p class="text-xs text-gray-300 font-medium mt-0.5">{{ date('d-m-Y', strtotime($t->tgl_kunjungan)) }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-[#161616] border border-gray-800/60 rounded-xl p-3 space-y-2">
                                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Rincian Kuota Tiket</label>
                                        
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-gray-400">Tiket Dewasa (D)</span>
                                            <span class="font-bold text-gray-200 font-mono">{{ $t->jumlah_dewasa }} Pax</span>
                                        </div>
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-gray-400">Tiket Anak-Anak (A)</span>
                                            <span class="font-bold text-gray-200 font-mono">{{ $t->jumlah_anak }} Pax</span>
                                        </div>
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-gray-400">Tiket Mahasiswa (M)</span>
                                            <span class="font-bold text-gray-200 font-mono">{{ $t->jumlah_mahasiswa }} Pax</span>
                                        </div>
                                    </div>

                                    <div class="pt-1">
                                        <label for="ticket-modal-{{ $t->id_tiket }}" 
                                            class="block w-full text-center bg-gray-900 hover:bg-gray-800 border border-gray-800 text-gray-300 text-xs font-bold py-2.5 rounded-xl transition-all uppercase tracking-wider cursor-pointer select-none">
                                            Tutup Rincian
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if ($tikets->isEmpty())
                            <tr>
                                <td colspan="7" class="p-8 text-center text-xs text-gray-500 italic">
                                    Belum ada pemesanan tiket masuk.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection