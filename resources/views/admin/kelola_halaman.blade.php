@extends('admin.layouts.admin')
@section('title', 'Kelola Halaman About - Museum KASAD')

@section('content')
    <div class="space-y-3 mb-6">
        <div class="mb-4">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-wide text-white">Kelola Halaman About</h1>
            <p class="text-xs text-gray-400 mt-1">Pantau dan sesuaikan isi konten informasi halaman "Tentang Museum".</p>
        </div>
    </div>

    <div x-data="{ isEdit: false }" class="space-y-6 font-montserrat text-white">

        <div x-show="!isEdit" x-transition.opacity
            class="bg-[#111111] border border-gray-800 rounded-2xl p-6 shadow-2xl space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div>
                    <h3 class="text-xs font-bold uppercase text-gray-500 mb-2 tracking-wide">Gambar / Banner About</h3>
                    <div class="w-full h-56 bg-[#161616] border border-gray-800 rounded-xl overflow-hidden">
                        @if ($dataHalaman && $dataHalaman->gambar_about)
                            <img src="{{ asset('images/about/' . $dataHalaman->gambar_about) }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-600 italic text-xs">Belum
                                ada gambar</div>
                        @endif
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-4">
                    <div>
                        <h3 class="text-xs font-bold uppercase text-gray-500 tracking-wide">Judul Utama</h3>
                        <p class="text-lg font-bold text-white mt-1">{!! $dataHalaman->judul ?? '<span class="text-gray-600 italic">Belum diisi</span>' !!}</p>
                    </div>

                    <div>
                        <h3 class="text-xs font-bold uppercase text-gray-500 tracking-wide">Isi Konten / Deskripsi</h3>
                        <div
                            class="text-sm text-gray-300 mt-1 leading-relaxed bg-[#161616] p-4 rounded-xl border border-gray-800/40 min-h-[120px]">
                            {!! $dataHalaman && $dataHalaman->konten
                                ? nl2br(e($dataHalaman->konten))
                                : '<span class="text-gray-600 italic">Belum diisi</span>' !!}
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="pt-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 border-t border-gray-800/60">
                @if ($dataHalaman && isset($dataHalaman->updated_at))
                    <p class="text-[11px] text-gray-500">
                        <i class="fa-solid fa-clock-rotate-left mr-1"></i> Terakhir Diperbarui:
                        <span
                            class="text-gray-400 font-medium">{{ \Carbon\Carbon::parse($dataHalaman->updated_at)->translatedFormat('d F Y, H:i') }}
                            WIB</span>
                    </p>
                @else
                    <div></div>
                @endif

                <button type="button" @click="isEdit = true"
                    class="w-full sm:w-auto bg-[#e2ca52] hover:bg-yellow-500 text-black font-bold text-xs px-5 py-3 rounded-xl uppercase tracking-wider transition-all flex items-center justify-center gap-1.5 cursor-pointer">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Halaman
                </button>
            </div>
        </div>

        <div x-show="isEdit" x-transition.opacity style="display: none;"
            class="bg-[#111111] border border-gray-800 rounded-2xl p-6 shadow-2xl">
            <form action="{{ route('halaman.update') }}" method="POST" enctype="multipart/form-data"
                class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                @csrf
                @method('PUT')

                <div class="space-y-3">
                    <label class="block text-xs font-bold uppercase text-gray-400 tracking-wide">Gambar Halaman
                        About</label>
                    <div
                        class="w-full h-56 bg-[#161616] border border-gray-800 rounded-xl overflow-hidden flex items-center justify-center">
                        @if ($dataHalaman && $dataHalaman->gambar_about)
                            <img src="{{ asset('images/about/' . $dataHalaman->gambar_about) }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="text-center p-4 text-gray-600 space-y-1">
                                <i class="fa-solid fa-image text-2xl"></i>
                                <p class="text-[10px]">Belum ada gambar</p>
                            </div>
                        @endif
                    </div>
                    <input type="file" name="gambar" accept="image/png, image/jpeg, image/jpg"
                        class="w-full bg-[#161616] border border-gray-800 rounded-xl p-2.5 text-xs text-gray-400 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#e2ca52] file:text-black cursor-pointer">
                </div>

                <div class="lg:col-span-2 space-y-5">
                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-2 tracking-wide">Judul
                            Utama</label>
                        <input type="text" name="judul" value="{{ $dataHalaman->judul ?? '' }}" required
                            class="w-full bg-[#161616] border border-gray-800 rounded-xl p-3.5 text-xs text-white focus:border-[#e2ca52] focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-gray-400 mb-2 tracking-wide">Isi Konten /
                            Deskripsi Tentang Kami</label>
                        <textarea name="konten" rows="10" required
                            class="w-full bg-[#161616] border border-gray-800 rounded-xl p-3.5 text-xs text-white focus:border-[#e2ca52] focus:outline-none leading-relaxed">{{ $dataHalaman->konten ?? '' }}</textarea>
                    </div>

                    <div class="pt-4 flex justify-end gap-2 border-t border-gray-800/50">
                        <button type="button" @click="isEdit = false"
                            class="bg-gray-800 hover:bg-gray-700 text-gray-300 font-bold text-xs px-5 py-3 rounded-xl uppercase tracking-wider cursor-pointer">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-[#e2ca52] hover:bg-yellow-500 text-black font-bold text-xs px-5 py-3 rounded-xl uppercase tracking-wider transition-all">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
