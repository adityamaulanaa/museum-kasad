@extends('admin.layouts.admin')
@section('title', 'Manajemen Tiket - Museum KASAD')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-white">
            Manajemen Tiket
        </h1>

        <button onclick="window.print()"
            class="bg-[#e2ca52] hover:bg-[#8f7626] text-black text-xs font-bold px-4 py-2.5 rounded-xl transition-all uppercase tracking-wider flex items-center space-x-2 shrink-0 cursor-pointer">
            <i class="fas fa-print text-[10px]"></i>
            <span>Cetak Laporan</span>
        </button>
    </div>

    <div class="bg-[#111111] border border-gray-800 rounded-2xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left table-auto">
                <thead
                    class="bg-[#1c1a12] text-[#e2ca52] text-xs uppercase font-bold tracking-wider border-b border-gray-800">
                    <tr>
                        <th class="px-4 py-4 text-center w-12">No</th>
                        <th class="px-4 py-4">Nama Pengunjung</th>
                        <th class="px-4 py-4">Kontak</th>
                        <th class="px-4 py-4 text-center">Jumlah Tiket (D/A/M)</th>
                        <th class="px-4 py-4 text-center">Bayar via</th>
                        <th class="px-4 py-4 text-center">Tgl Kunjungan</th>
                        <th class="px-4 py-4 text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50 text-sm">
                    @foreach ($tikets as $index => $t)
                        <tr class="hover:bg-[#141414] transition-colors text-xs">
                            <td class="px-4 py-5 font-bold text-gray-500 text-center">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-4 py-5 font-medium text-gray-200">
                                {{ $t->nama_pengunjung }}
                            </td>

                            <td class="px-4 py-5 text-gray-400">
                                <div class="font-medium text-gray-300">{{ $t->email }}</div>
                                <div class="text-[10px] text-gray-500 mt-0.5">{{ $t->no_telp }}</div>
                            </td>

                            <td class="px-4 py-5 text-center">
                                <span
                                    class="bg-gray-900 border border-gray-800 text-gray-300 px-2 py-1 rounded-md font-bold">
                                    {{ $t->jumlah_dewasa }}D / {{ $t->jumlah_anak }}A / {{ $t->jumlah_mahasiswa }}M
                                </span>
                            </td>

                            <td class="px-4 py-5 text-center font-bold tracking-wider text-[#e2ca52] uppercase">
                                {{ $t->metode_pembayaran }}
                            </td>

                            <td class="px-4 py-5 text-center text-gray-400 font-medium">
                                {{ date('d-m-Y', strtotime($t->tgl_kunjungan)) }}
                            </td>

                            <td class="px-4 py-5 text-center">
                                <form action="/tiket/{{ $t->id_tiket }}/delete" method="POST"
                                    onsubmit="return confirm('Yakin mau hapus tiket ini gess?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-950/40 hover:bg-red-900 border border-red-900 text-red-400 text-[10px] font-bold px-3 py-1.5 rounded-lg transition-all uppercase tracking-tighter flex items-center justify-center mx-auto cursor-pointer">
                                        <i class="fa-solid fa-trash-can mr-1"></i>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
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
@endsection
