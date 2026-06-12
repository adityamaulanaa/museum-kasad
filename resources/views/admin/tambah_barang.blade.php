@extends('admin.layouts.admin')
@section('title', 'Tambah Barang - Museum KASAD')

@section('content')
    <div class="space-y-6">
        <div class="mb-4">
            <h1 class="text-2xl sm:text-3xl font-bold text-white">
                Tambah Koleksi Museum
            </h1>
            <p class="text-xs text-gray-500 mt-1">Masukkan data koleksi atau barang bersejarah baru ke dalam sistem.</p>
        </div>

        <div class="bg-[#111111] border border-gray-800 rounded-2xl shadow-2xl p-6 w-full">

            <form action="/tambah_barang/store" method="POST" enctype="multipart/form-data" class="space-y-5 font-montserrat">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Nama
                            Barang</label>
                        <input type="text" name="nama_barang" required placeholder="Contoh: Arca Buddha"
                            class="w-full bg-[#161616] border border-gray-800 rounded-xl p-3 text-white text-sm focus:border-[#d4af37] focus:outline-none transition-colors">
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Kategori
                            Koleksi</label>
                        <select name="id_kategori" required
                            class="w-full bg-[#161616] border border-gray-800 rounded-xl p-3 text-gray-300 text-sm focus:border-[#d4af37] focus:outline-none transition-colors">
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id_kategori }}">{{ $cat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Tahun Pembuatan /
                            Temuan</label>
                        <input type="number" name="tahun_barang" required placeholder="Contoh: 1945"
                            class="w-full bg-[#161616] border border-gray-800 rounded-xl p-3 text-white text-sm focus:border-[#d4af37] focus:outline-none transition-colors">
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Bahan</label>
                        <input type="text" name="bahan_barang" required placeholder="Contoh: Baja / Perunggu / Kayu"
                            class="w-full bg-[#161616] border border-gray-800 rounded-xl p-3 text-white text-sm focus:border-[#d4af37] focus:outline-none transition-colors">
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Asal</label>
                    <input type="text" name="asal_barang" required
                        placeholder="Contoh: Kerajaan Majapahit / Hibah Kodam Diponegoro"
                        class="w-full bg-[#161616] border border-gray-800 rounded-xl p-3 text-white text-sm focus:border-[#d4af37] focus:outline-none transition-colors">
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">Deskripsi</label>
                    <textarea name="deskripsi_barang" rows="4"
                        placeholder="Tuliskan latar belakang sejarah, fungsi, atau kondisi fisik barang saat ini..."
                        class="w-full bg-[#161616] border border-gray-800 rounded-xl p-3 text-white text-sm focus:border-[#d4af37] focus:outline-none transition-colors resize-none"></textarea>
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-2">
                        Foto / Gambar Koleksi
                    </label>

                    <div id="dropzone"
                        class="bg-[#161616] border border-dashed border-gray-800 rounded-xl p-4 text-center hover:border-[#d4af37]/50 transition-all relative group">

                        <input type="file" name="gambar_barang" id="file-input" required
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">

                        <div id="dropzone-text" class="space-y-2 transition-all relative z-10">
                            <i
                                class="fas fa-cloud-upload-alt text-2xl text-gray-500 group-hover:text-[#d4af37] transition-colors"></i>
                            <p class="text-xs text-gray-400">Klik atau seret file gambar ke sini</p>
                            <p class="text-[10px] text-gray-600 block">PNG, JPG, JPEG (Max. 2MB)</p>
                        </div>

                    </div>
                </div>

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-800/50">
                    <a href="/kelola_barang"
                        class="text-gray-400 hover:text-white text-xs font-bold px-5 py-3 transition-colors uppercase tracking-wider">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-[#d4af37] hover:bg-[#bfa032] text-black text-xs font-bold px-6 py-3 rounded-xl transition-all uppercase tracking-wider shadow-lg shadow-[#d4af37]/10 cursor-pointer">
                        <i class="fas fa-save mr-1.5"></i> Simpan Koleksi
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.getElementById('file-input').addEventListener('change', function(e) {
            const dropzone = document.getElementById('dropzone');
            const textContainer = document.getElementById('dropzone-text');

            if (this.files && this.files[0]) {
                const fileName = this.files[0].name;

                dropzone.classList.remove('border-gray-800', 'hover:border-[#d4af37]/50');
                dropzone.classList.add('border-green-600', 'bg-[#121c14]');

                const reader = new FileReader();
                reader.onload = function(event) {
                    textContainer.innerHTML = `
                        <img src="${event.target.result}" class="h-20 w-auto mx-auto rounded-lg border border-green-700 shadow-md mb-2 object-cover animate-fade-in">
                        <p class="text-xs text-green-400 font-bold">File Siap Diupload!</p>
                        <p class="text-[10px] text-gray-300 bg-[#1a2e20] py-1 px-3 rounded-md inline-block mt-1 border border-green-800/30 font-mono tracking-tight max-w-full truncate">${fileName}</p>
                    `;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
@endsection
