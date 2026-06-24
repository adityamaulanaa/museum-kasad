<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tiket;
use App\Models\Barang;

class DashboardController extends Controller
{
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');

        // 1. Proteksi Login bawaan kamu
        if (!session()->has('admin_login')) {
            return redirect('/login');
        }

        // 2. Ambil data statistik card (Tetap pakai Model Eloquent)
        $totalKoleksi = Barang::count(); 
        
        $awalBulan = date('Y-m-01');
        $hariIni = date('Y-m-d');
        
        // 🔥 INI DIA: Tetap pakai Model, di-sum pakai \DB::raw murni untuk rumus nominal uang bulanan!
        // Ganti 15000, 10000, 12000 dengan harga tiket asli kamu ya
        $totalPenghasilanBulanIni = Tiket::whereBetween('tgl_kunjungan', [$awalBulan, $hariIni])
                            ->where('status_tiket', 'Sudah Dipakai')
                            ->sum(DB::raw('(jumlah_dewasa * 15000) + (jumlah_anak * 10000) + (jumlah_mahasiswa * 12000)'));

        $totalTiketBulanIni = \App\Models\Tiket::whereBetween('tgl_kunjungan', [$awalBulan, $hariIni])
                        ->where('status_tiket', 'Sudah Dipakai')
                        ->sum(DB::raw('jumlah_dewasa + jumlah_anak + jumlah_mahasiswa'));

        // 3. LOGIC GRAFIK: Buat data 7 hari terakhir (Tetap hitung jumlah orang per hari)
        $grafikLabels = [];
        $grafikData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = date('Y-m-d', strtotime("-$i days"));
            $grafikLabels[] = date('d M', strtotime($tanggal)); 
            
            // Yang ini tetep hitung jumlah orang pake \DB::raw bawaan awal kamu
            $totalPengunjung = Tiket::whereDate('tgl_kunjungan', $tanggal)
                                ->sum(DB::raw('jumlah_dewasa + jumlah_anak + jumlah_mahasiswa'));
                                
            $grafikData[] = $totalPengunjung;
        }

        // 4. Kirim variabel $totalPenghasilanBulanIni ke view dashboard
        return view('admin.dashboard', compact('totalKoleksi', 'totalPenghasilanBulanIni', 'totalTiketBulanIni', 'grafikLabels', 'grafikData'));
    }
}
