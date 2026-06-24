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

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
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
                Total Penjualan Tiket Bulan ini
            </p>
            <h2 class="mt-3 text-3xl font-bold text-[#e2ca52]">
                {{ $totalTiketBulanIni }} Tiket
            </h2>
        </div>
        <div class="bg-[#181818] border border-gray-800 rounded-2xl p-6 hover:border-[#e2ca52]/50 transition">
            <p class="text-sm text-gray-400">
                Penghasilan Bulan Ini </p>
            <h2 class="mt-3 text-3xl font-bold text-[#e2ca52]">
                Rp {{ number_format($totalPenghasilanBulanIni, 0, ',', '.') }}
            </h2>
        </div>
    </div>
    <div class="bg-[#181818] border border-gray-800 rounded-2xl p-6">
        <div class="mb-4">
            <h3 class="text-lg font-bold text-white tracking-wide">Tren Kunjungan Museum</h3>
            <p class="text-xs text-gray-500">Statistik total pengunjung selama 7 hari terakhir</p>
        </div>
        <div class="relative w-full h-64 sm:h-80">
            <canvas id="chartKunjungan"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('chartKunjungan').getContext('2d');

            // Konfigurasi Gradasi Warna Emas di Bawah Grafik Line
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(226, 202, 82, 0.3)');
            gradient.addColorStop(1, 'rgba(226, 202, 82, 0.0)');

            new Chart(ctx, {
                type: 'line', // Jenis grafik garis (bisa diganti 'bar' jika mau grafik batang)
                data: {
                    labels: @json($grafikLabels),
                    datasets: [{
                        label: 'Jumlah Pengunjung',
                        data: @json($grafikData),
                        borderColor: '#e2ca52', // Warna emas senada tema kamu
                        borderWidth: 3,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.3, // Efek melengkung halus pada garis grafik
                        pointBackgroundColor: '#e2ca52',
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Sembunyikan label kotak bawaan di atas biar clean
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)' // Garis grid horizontal tipis
                            },
                            ticks: {
                                color: '#9ca3af', // Warna teks angka koordinat Y
                                font: {
                                    size: 11
                                },
                                stepSize: 1 // Memastikan angka yang tampil bulat/bukan desimal
                            }
                        },
                        x: {
                            grid: {
                                display: false // Sembunyikan garis grid vertikal biar rapi
                            },
                            ticks: {
                                color: '#9ca3af', // Warna teks tanggal koordinat X
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>

@endsection
