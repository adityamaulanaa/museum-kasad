@extends('admin.layouts.admin')
@section('title', 'Kelola Koleksi - Museum KASAD')

@section('content')
    <div class="flex flex-col sm:flex-row gap-4 sm:items-center sm:justify-between mb-6">

        <h1 class="text-2xl sm:text-3xl font-bold text-white">
            Kelola Koleksi Museum
        </h1>

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
                                {{ $b->id_barang }}
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
                                    <span>{{ $b->admin->username ?? 'Admin' }}</span>
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
                                        onsubmit="return confirm('Yakin mau hapus?')" class="inline m-0 p-0">
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
    </div>
    <div class="px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-4 font-montserrat">

        <div class="text-xs text-gray-500 order-2 sm:order-1">
            Menampilkan <span class="font-bold text-gray-300">{{ $barangs->firstItem() ?? 0 }}</span>
            sampai <span class="font-bold text-gray-300">{{ $barangs->lastItem() ?? 0 }}</span>
            dari <span class="font-bold text-[#e2ca52]">{{ $barangs->total() }}</span> koleksi
        </div>

        <nav aria-label="Page navigation example" class="flex items-center space-x-4 order-1 sm:order-2">
            <ul class="flex -space-x-px text-sm">

                <li>
                    @if ($barangs->onFirstPage())
                        <span
                            class="flex items-center justify-center text-gray-600 bg-[#161616] border border-gray-800 rounded-s-xl text-sm px-3 h-9 cursor-not-allowed select-none">Previous</span>
                    @else
                        <a href="{{ $barangs->previousPageUrl() }}"
                            class="flex items-center justify-center text-gray-300 bg-[#161616] border border-gray-800 hover:bg-[#1c1a12] hover:text-[#e2ca52] shadow-xs font-medium rounded-s-xl text-sm px-3 h-9 focus:outline-none transition-colors">Previous</a>
                    @endif
                </li>

                @foreach ($barangs->getUrlRange(1, $barangs->lastPage()) as $page => $url)
                    <li>
                        @if ($page == $barangs->currentPage())
                            <span aria-current="page"
                                class="flex items-center justify-center text-black bg-[#e2ca52] border border-[#e2ca52] font-bold text-sm w-9 h-9 select-none rounded-md mx-0.5">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                                class="flex items-center justify-center text-gray-400 bg-[#161616] border border-gray-800 hover:bg-[#1c1a12] hover:text-[#e2ca52] shadow-xs font-medium text-sm w-9 h-9 focus:outline-none transition-colors rounded-md mx-0.5">{{ $page }}</a>
                        @endif
                @endforeach

                <li>
                    @if ($barangs->hasMorePages())
                        <a href="{{ $barangs->nextPageUrl() }}"
                            class="flex items-center justify-center text-gray-300 bg-[#161616] border border-gray-800 hover:bg-[#1c1a12] hover:text-[#e2ca52] shadow-xs font-medium rounded-e-xl text-sm px-3 h-9 focus:outline-none transition-colors">Next</a>
                    @else
                        <span
                            class="flex items-center justify-center text-gray-600 bg-[#161616] border border-gray-800 rounded-e-xl text-sm px-3 h-9 cursor-not-allowed select-none">Next</span>
                    @endif
                </li>
            </ul>

            <div class="w-32">
                <select id="perPageSelect" onchange="changePerPage(this.value)"
                    class="block w-full px-3 py-2 bg-[#161616] border border-gray-800 text-gray-300 text-xs rounded-xl focus:border-[#e2ca52] focus:outline-none shadow-xs cursor-pointer">
                    <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 per halaman</option>
                    <option value="10" {{ request('per_page') == 10 || !request('per_page') ? 'selected' : '' }}>10 per
                        halaman</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per halaman</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per halaman</option>
                </select>
            </div>
        </nav>

    </div>

    </div>
    <script>
        function changePerPage(value) {
            let url = new URL(window.location.href);
            url.searchParams.set('per_page', value);
            url.searchParams.set('page', 1);
            window.location.href = url.href;
        }
    </script>
    <a href="/tambah_barang"
        class="fixed bottom-6 right-6 z-50 bg-[#e2ca52] hover:bg-[#c9b347] text-black px-5 py-4 rounded-full 
        shadow-2xl shadow-black/50 flex items-center gap-2 font-bold text-sm transition-all hover:scale-105">

        <i class="fas fa-plus"></i>
        <span>Tambah Barang</span>
    </a>
@endsection
