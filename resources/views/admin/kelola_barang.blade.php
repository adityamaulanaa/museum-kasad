@extends('admin.layouts.admin')
@section('title', 'Kelola Barang - Museum KASAD')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-white">
            Kelola Barang
        </h1>

        <a href="/tambah_barang"
            class="bg-[#e2ca52] hover:bg-[#8f7626] text-black text-xs font-bold px-4 py-2.5 rounded-xl transition-all uppercase tracking-wider flex items-center space-x-2 shrink-0">
            <i class="fas fa-plus text-[10px]"></i>
            <span>Tambah Barang</span>
        </a>
    </div>

    <div class="bg-[#111111] border border-gray-800 rounded-2xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead
                    class="bg-[#1c1a12] text-[#e2ca52] text-xs uppercase font-bold tracking-wider border-b border-gray-800">
                    <tr>
                        <th class="px-6 py-4 w-20 text-center">ID</th>
                        <th class="px-6 py-4">Nama Barang</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Diubah Oleh</th>
                        <th class="px-6 py-4 w-32 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50 text-sm">
                    @foreach ($barangs as $index => $b)
                        <tr class="hover:bg-[#141414] transition-colors">
                            <td class="px-6 py-5 font-bold text-gray-500 text-center">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-5 font-medium text-gray-200">
                                {{ $b->nama_barang }}
                            </td>
                            <td class="px-6 py-5 text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                                {{ $b->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                            </td>

                            <td class="px-6 py-5 text-xs text-gray-400 font-medium">
                                <div class="flex items-center space-x-1.5">
                                    <i class="fa-solid fa-user-shield text-[10px] text-[#e2ca52]"></i>
                                    <span>{{ $b->admin->username ?? 'System' }}</span>
                                </div>
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex items-center justify-center space-x-2">

                                    <a href="/barang/{{ $b->id_barang }}/edit"
                                        class="bg-[#e2ca52] hover:bg-[#8f7626] text-black text-[10px] font-bold px-3 py-2 rounded-lg transition-all uppercase tracking-tighter flex items-center space-x-1 shrink-0">
                                        <i class="fa-solid fa-pen"></i>
                                        <span>Edit</span>
                                    </a>

                                    <form action="/barang/{{ $b->id_barang }}/delete" method="POST"
                                        onsubmit="return confirm('Yakin mau hapus barang {{ $b->nama_barang }} dari museum?')"
                                        class="inline m-0 p-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-950/40 hover:bg-red-900 border border-red-900/60 text-red-400 text-[10px] font-bold px-3 py-2 rounded-lg transition-all uppercase tracking-tighter flex items-center space-x-1 shrink-0 cursor-pointer">
                                            <i class="fa-solid fa-trash-can"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach

                    @if ($barangs->isEmpty())
                        <tr>
                            <td colspan="7" class="p-8 text-center text-xs text-gray-500 italic">
                                Belum ada koleksi.
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>
@endsection
