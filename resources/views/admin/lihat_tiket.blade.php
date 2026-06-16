@extends('admin.layouts.admin')
@section('title', 'Kelola Tiket - Museum KASAD')

@section('content')
    <div class="space-y-10 font-montserrat">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white">
                    Kelola Tiket Pengunjung
                </h1>
            </div>

            <button onclick="window.print()"
                class="bg-[#d4af37] hover:bg-[#bfa032] text-black text-xs font-bold px-5 py-3 rounded-xl transition-all uppercase tracking-wider flex items-center justify-center space-x-2 shrink-0 cursor-pointer">
                <i class="fas fa-print text-xs"></i>
                <span>Cetak Laporan</span>
            </button>
        </div>

        <div class="space-y-4">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold text-yellow-500 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span>
                    Antrean Kedatangan (Belum Check-in)
                </h2>
                <span class="bg-yellow-950/40 border border-yellow-800 text-yellow-400 text-xs px-3 py-1 rounded-full font-mono font-bold">
                    {{ $tiketBelumDipakai->count() }} Antrean
                </span>
            </div>

            <div class="bg-[#111111] border border-gray-800 rounded-2xl shadow-2xl overflow-hidden w-full">
                <div class="overflow-x-auto">
                    <table class="w-full text-left table-auto">
                        <thead class="bg-[#1c1a12] text-[#e2ca52] text-xs uppercase font-bold tracking-wider border-b border-gray-800">
                            <tr>
                                <th class="px-5 py-4 text-center w-12">No</th>
                                <th class="px-5 py-4">Kode Tiket</th>
                                <th class="px-5 py-4">Nama Pengunjung</th>
                                <th class="px-5 py-4">Kontak</th>
                                <th class="px-5 py-4 text-center">Jumlah Tiket</th>
                                <th class="px-5 py-4 text-center">Total Harga</th>
                                <th class="px-5 py-4 text-center">Tgl Kunjungan</th>
                                <th class="px-5 py-4 text-center w-36">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800/50 text-sm">
                            @foreach ($tiketBelumDipakai as $index => $t)
                                <tr class="hover:bg-[#141414] transition-colors text-xs">
                                    <td class="px-5 py-4 font-bold text-gray-500 text-center">{{ $index + 1 }}</td>
                                    <td class="px-5 py-4 font-mono font-bold text-[#e2ca52]">{{ $t->kode_tiket ?? '-' }}</td>
                                    <td class="px-5 py-4 font-medium text-gray-200">{{ $t->nama_pengunjung }}</td>
                                    <td class="px-5 py-4 text-gray-400">
                                        <div class="font-medium text-gray-300">{{ $t->email }}</div>
                                        <div class="text-[10px] text-gray-500 mt-0.5">{{ $t->no_telp }}</div>
                                    </td>
                                    <td class="px-5 py-4 text-left text-gray-400 space-y-0.5">
                                        @if ($t->jumlah_dewasa > 0) <div>{{ $t->jumlah_dewasa }}x Dewasa</div> @endif
                                        @if ($t->jumlah_anak > 0) <div>{{ $t->jumlah_anak }}x Anak</div> @endif
                                        @if ($t->jumlah_mahasiswa > 0) <div>{{ $t->jumlah_mahasiswa }}x Mahasiswa</div> @endif
                                    </td>
                                    <td class="px-5 py-4 text-center font-bold text-gray-200">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                                    <td class="px-5 py-4 text-center text-gray-400 font-medium">{{ date('d-m-Y', strtotime($t->tgl_kunjungan)) }}</td>
                                    <td class="px-5 py-4">
                                        <div class="flex flex-col items-center justify-center space-y-2">
                                            <div class="flex items-center justify-center space-x-2">
                                                <label for="modal-belum-{{ $t->id_tiket }}" class="bg-gray-800 hover:bg-gray-700 text-gray-200 text-[10px] font-bold px-3 py-2 rounded-lg transition-all uppercase cursor-pointer"><i class="fa-solid fa-eye"></i> Detail</label>
                                                <form action="/tiket/{{ $t->id_tiket }}/delete" method="POST" onsubmit="return confirm('Yakin mau hapus tiket ini?')" class="m-0 p-0">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="bg-red-950/40 hover:bg-red-900 border border-red-900 text-red-400 text-[10px] font-bold px-3 py-2 rounded-lg transition-all uppercase"><i class="fa-solid fa-trash-can"></i></button>
                                                </form>
                                            </div>
                                            <form action="{{ route('tiket.checkin', $t->id_tiket) }}" method="POST" class="w-full m-0 p-0 flex justify-center">
                                                @csrf @method('PATCH')
                                                <button type="submit" onclick="return confirm('Konfirmasi check-in untuk kode {{ $t->kode_tiket }}?')" class="w-full max-w-[115px] bg-green-700 hover:bg-green-600 text-white text-[10px] font-bold px-3 py-2 rounded-lg transition-all uppercase tracking-tighter flex items-center justify-center cursor-pointer">
                                                    <i class="fa-solid fa-square-check mr-1"></i> Check-in
                                                </button>
                                            </form>
                                        </div>

                                        <input type="checkbox" id="modal-belum-{{ $t->id_tiket }}" class="hidden peer/modal">
                                        <div class="fixed inset-0 z-50 hidden peer-checked/modal:flex items-center justify-center p-4">
                                            <label for="modal-belum-{{ $t->id_tiket }}" class="fixed inset-0 bg-black/80 backdrop-blur-sm cursor-pointer"></label>
                                            <div class="bg-[#111111] border border-gray-800 w-full max-w-md rounded-2xl overflow-hidden shadow-2xl relative z-10 p-6 space-y-5 text-left">
                                                <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                                                    <div>
                                                        <h3 class="text-lg font-bold text-white tracking-wide">Detail Tiket Masuk</h3>
                                                        <p class="text-[10px] text-yellow-500 font-mono mt-0.5">Status: {{ $t->status_tiket }}</p>
                                                    </div>
                                                    <label for="modal-belum-{{ $t->id_tiket }}" class="bg-gray-900 hover:bg-gray-800 text-gray-400 h-7 w-7 rounded-full flex items-center justify-center cursor-pointer"><i class="fas fa-times text-xs"></i></label>
                                                </div>
                                                <div class="space-y-3 text-gray-300">
                                                    <div><label class="text-[10px] font-bold text-gray-500 uppercase block">Nama Pengunjung</label><p class="text-sm font-semibold text-gray-200">{{ $t->nama_pengunjung }}</p></div>
                                                    <div class="grid grid-cols-2 gap-3">
                                                        <div><label class="text-[10px] font-bold text-gray-500 uppercase block">Email</label><p class="text-xs truncate">{{ $t->email }}</p></div>
                                                        <div><label class="text-[10px] font-bold text-gray-500 uppercase block">No. Telepon</label><p class="text-xs font-mono">{{ $t->no_telp }}</p></div>
                                                    </div>
                                                    <div class="grid grid-cols-2 gap-3 pt-2 border-t border-gray-800/40">
                                                        <div><label class="text-[10px] font-bold text-gray-500 uppercase block">Metode Pembayaran</label><p class="text-xs font-bold text-[#e2ca52] uppercase">{{ $t->metode_pembayaran }}</p></div>
                                                        <div><label class="text-[10px] font-bold text-gray-500 uppercase block">Tanggal Kunjungan</label><p class="text-xs font-medium">{{ date('d-m-Y', strtotime($t->tgl_kunjungan)) }}</p></div>
                                                    </div>
                                                </div>
                                                <div class="bg-[#161616] border border-gray-800/60 rounded-xl p-3 space-y-2">
                                                    <div class="flex justify-between text-xs"><span>Tiket Dewasa</span><span class="font-mono">{{ $t->jumlah_dewasa }} Pax</span></div>
                                                    <div class="flex justify-between text-xs"><span>Tiket Anak</span><span class="font-mono">{{ $t->jumlah_anak }} Pax</span></div>
                                                    <div class="flex justify-between text-xs"><span>Tiket Mahasiswa</span><span class="font-mono">{{ $t->jumlah_mahasiswa }} Pax</span></div>
                                                    <div class="flex justify-between items-center text-xs pt-2 border-t border-gray-800/80 font-bold"><span class="text-[#e2ca52]">Total Bayar</span><span class="text-white text-sm font-mono">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</span></div>
                                                </div>
                                                <label for="modal-belum-{{ $t->id_tiket }}" class="block w-full text-center bg-gray-900 border border-gray-800 text-gray-300 text-xs font-bold py-2.5 rounded-xl cursor-pointer uppercase">Tutup Rincian</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($tiketBelumDipakai->isEmpty())
                                <tr><td colspan="8" class="p-8 text-center text-xs text-gray-500 italic">Tidak ada antrean pengunjung hari ini.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-4 pt-4">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-bold text-green-500 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                    Riwayat Kunjungan (Sudah Check-in)
                </h2>
                <span class="bg-green-950/40 border border-green-800 text-green-400 text-xs px-3 py-1 rounded-full font-mono font-bold">
                    {{ $tiketSudahDipakai->count() }} Terpakai
                </span>
            </div>

            <div class="bg-[#111111] border border-gray-800 rounded-2xl shadow-2xl overflow-hidden w-full opacity-90">
                <div class="overflow-x-auto">
                    <table class="w-full text-left table-auto">
                        <thead class="bg-[#141d17] text-[#52e27c] text-xs uppercase font-bold tracking-wider border-b border-gray-800">
                            <tr>
                                <th class="px-5 py-4 text-center w-12">No</th>
                                <th class="px-5 py-4">Kode Tiket</th>
                                <th class="px-5 py-4">Nama Pengunjung</th>
                                <th class="px-5 py-4">Kontak</th>
                                <th class="px-5 py-4 text-center">Jumlah Tiket</th>
                                <th class="px-5 py-4 text-center">Total Harga</th>
                                <th class="px-5 py-4 text-center">Tgl Kunjungan</th>
                                <th class="px-5 py-4 text-center w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800/50 text-sm">
                            @foreach ($tiketSudahDipakai as $index => $t)
                                <tr class="hover:bg-[#121613] transition-colors text-xs text-gray-400">
                                    <td class="px-5 py-4 font-bold text-gray-600 text-center">{{ $index + 1 }}</td>
                                    <td class="px-5 py-4 font-mono font-bold text-gray-500 line-through">{{ $t->kode_tiket ?? '-' }}</td>
                                    <td class="px-5 py-4 font-medium text-gray-400">{{ $t->nama_pengunjung }}</td>
                                    <td class="px-5 py-4 text-gray-500">
                                        <div>{{ $t->email }}</div>
                                        <div class="text-[10px] mt-0.5 font-mono">{{ $t->no_telp }}</div>
                                    </td>
                                    <td class="px-5 py-4 text-left text-gray-500 space-y-0.5">
                                        @if ($t->jumlah_dewasa > 0) <div>{{ $t->jumlah_dewasa }}x Dewasa</div> @endif
                                        @if ($t->jumlah_anak > 0) <div>{{ $t->jumlah_anak }}x Anak</div> @endif
                                        @if ($t->jumlah_mahasiswa > 0) <div>{{ $t->jumlah_mahasiswa }}x Mahasiswa</div> @endif
                                    </td>
                                    <td class="px-5 py-4 text-center font-bold text-gray-400">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                                    <td class="px-5 py-4 text-center text-gray-500 font-medium">{{ date('d-m-Y', strtotime($t->tgl_kunjungan)) }}</td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            <label for="modal-sudah-{{ $t->id_tiket }}" class="bg-gray-900 hover:bg-gray-800 border border-gray-800 text-gray-400 text-[10px] font-bold px-3 py-2 rounded-lg transition-all uppercase cursor-pointer"><i class="fa-solid fa-eye"></i> Detail</label>
                                            <form action="/tiket/{{ $t->id_tiket }}/delete" method="POST" onsubmit="return confirm('Yakin mau hapus riwayat ini?')" class="m-0 p-0">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="bg-red-950/20 hover:bg-red-950 border border-red-950 hover:border-red-900 text-red-500 text-[10px] font-bold px-3 py-2 rounded-lg transition-all uppercase"><i class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                        </div>

                                        <input type="checkbox" id="modal-sudah-{{ $t->id_tiket }}" class="hidden peer/modal">
                                        <div class="fixed inset-0 z-50 hidden peer-checked/modal:flex items-center justify-center p-4">
                                            <label for="modal-sudah-{{ $t->id_tiket }}" class="fixed inset-0 bg-black/80 backdrop-blur-sm cursor-pointer"></label>
                                            <div class="bg-[#111111] border border-gray-800 w-full max-w-md rounded-2xl overflow-hidden shadow-2xl relative z-10 p-6 space-y-5 text-left">
                                                <div class="flex items-center justify-between border-b border-gray-800 pb-3">
                                                    <div>
                                                        <h3 class="text-lg font-bold text-white tracking-wide">Detail Tiket Masuk</h3>
                                                        <p class="text-[10px] text-green-500 font-mono mt-0.5">Status: {{ $t->status_tiket }}</p>
                                                    </div>
                                                    <label for="modal-sudah-{{ $t->id_tiket }}" class="bg-gray-900 hover:bg-gray-800 text-gray-400 h-7 w-7 rounded-full flex items-center justify-center cursor-pointer"><i class="fas fa-times text-xs"></i></label>
                                                </div>
                                                <div class="space-y-3 text-gray-300">
                                                    <div><label class="text-[10px] font-bold text-gray-500 uppercase block">Nama Pengunjung</label><p class="text-sm font-semibold text-gray-400">{{ $t->nama_pengunjung }}</p></div>
                                                    <div class="grid grid-cols-2 gap-3">
                                                        <div><label class="text-[10px] font-bold text-gray-500 uppercase block">Email</label><p class="text-xs truncate text-gray-400">{{ $t->email }}</p></div>
                                                        <div><label class="text-[10px] font-bold text-gray-500 uppercase block">No. Telepon</label><p class="text-xs font-mono text-gray-400">{{ $t->no_telp }}</p></div>
                                                    </div>
                                                    <div class="grid grid-cols-2 gap-3 pt-2 border-t border-gray-800/40">
                                                        <div><label class="text-[10px] font-bold text-gray-500 uppercase block">Metode Pembayaran</label><p class="text-xs font-bold text-gray-400 uppercase">{{ $t->metode_pembayaran }}</p></div>
                                                        <div><label class="text-[10px] font-bold text-gray-500 uppercase block">Tanggal Kunjungan</label><p class="text-xs font-medium text-gray-400">{{ date('d-m-Y', strtotime($t->tgl_kunjungan)) }}</p></div>
                                                    </div>
                                                </div>
                                                <div class="bg-[#161616] border border-gray-800/60 rounded-xl p-3 space-y-2 text-gray-400">
                                                    <div class="flex justify-between text-xs"><span>Tiket Dewasa</span><span>{{ $t->jumlah_dewasa }} Pax</span></div>
                                                    <div class="flex justify-between text-xs"><span>Tiket Anak</span><span>{{ $t->jumlah_anak }} Pax</span></div>
                                                    <div class="flex justify-between text-xs"><span>Tiket Mahasiswa</span><span>{{ $t->jumlah_mahasiswa }} Pax</span></div>
                                                    <div class="flex justify-between items-center text-xs pt-2 border-t border-gray-800/80 font-bold"><span class="text-green-500">Total Bayar</span><span class="text-gray-200 text-sm font-mono">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</span></div>
                                                </div>
                                                <label for="modal-sudah-{{ $t->id_tiket }}" class="block w-full text-center bg-gray-900 border border-gray-800 text-gray-300 text-xs font-bold py-2.5 rounded-xl cursor-pointer uppercase">Tutup Rincian</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($tiketSudahDipakai->isEmpty())
                                <tr><td colspan="8" class="p-8 text-center text-xs text-gray-500 italic">Belum ada riwayat kunjungan pengunjung.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection