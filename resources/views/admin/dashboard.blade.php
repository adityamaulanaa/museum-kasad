@extends('admin.layouts.admin')
@section('title', 'Dashboard Admin - Museum KASAD')
@section('content')
    <div class="mb-4">
        <h1 class="text-2xl sm:text-3xl font-bold text-white">
            Selamat Datang,
            <span class="block sm:inline text-4xl sm:text-3xl mt-1 sm:mt-0">
                <span class="text-[#e2ca52]">{{ session('username', 'Admin') }}</span>!
            </span>
        </h1>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
        <div class="bg-[#181818] border border-gray-800 rounded-2xl p-6 hover:border-[#e2ca52]/50 transition">
            <p class="text-sm text-gray-400">
                Total Koleksi
            </p>
            <h2 class="mt-3 text-3xl font-bold text-[#e2ca52]">
                {{ $totalKoleksi }} Barang
            </h2>
        </div>
        <div class="bg-[#181818] border border-gray-800 rounded-2xl p-6 hover:border-[#e2ca52]/50 transition">
            <p class="text-sm text-gray-400">
                Tiket Hari Ini
            </p>
            <h2 class="mt-3 text-3xl font-bold text-[#e2ca52]">
                {{ $tiketHariIni }} Pengunjung
            </h2>
        </div>
    </div>

@endsection
