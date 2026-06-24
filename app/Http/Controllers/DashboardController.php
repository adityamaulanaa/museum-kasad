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

        if (!session()->has('admin_login')) {
            return redirect('/login');
        }

        $totalKoleksi = Barang::count(); 
        
        $awalBulan = date('Y-m-01');
        $hariIni = date('Y-m-d');
        
        // Ganti 15000, 10000, 12000 dengan harga tiket asli kamu ya
        $totalPenghasilanBulanIni = Tiket::whereBetween('tgl_kunjungan', [$awalBulan, $hariIni])
                            ->where('status_tiket', 'Sudah Dipakai')
                            ->sum('total_harga');

        $totalTiketBulanIni = \App\Models\Tiket::whereBetween('tgl_kunjungan', [$awalBulan, $hariIni])
                        ->where('status_tiket', 'Sudah Dipakai')
                        ->sum(DB::raw('jumlah_dewasa + jumlah_anak + jumlah_mahasiswa'));

        // 3. LOGIC GRAFIK: Buat data 7 hari terakhir (Tetap hitung jumlah orang per hari)
        $grafikLabels = [];
        $grafikData = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = date('Y-m-d', strtotime("-$i days"));
            $grafikLabels[] = date('d M', strtotime($tanggal)); 
            
            $totalPengunjung = Tiket::whereDate('tgl_kunjungan', $tanggal)
                                ->where('status_tiket', 'Sudah Dipakai')
                                ->sum(DB::raw('jumlah_dewasa + jumlah_anak + jumlah_mahasiswa'));
                                
            $grafikData[] = $totalPengunjung;
        }

        // 4. Kirim variabel $totalPenghasilanBulanIni ke view dashboard
        return view('admin.dashboard', compact('totalKoleksi', 'totalPenghasilanBulanIni', 'totalTiketBulanIni', 'grafikLabels', 'grafikData'));
    }
}
