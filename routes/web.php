<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TiketController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/dashboard', function () {
    if (!session()->has('admin_login')) {
        return redirect('/login');
    }

    $totalKoleksi = \App\Models\Barang::count();
    $tiketHariIni = \App\Models\Tiket::whereDate('tgl_kunjungan', date('Y-m-d'))->count();

    return view('admin.dashboard', compact('totalKoleksi', 'tiketHariIni'));
});

Route::get('/kelola_barang', function (\Illuminate\Http\Request $request) {
    if (!session()->has('admin_login')) {
        return redirect('/login');
    }
        
    $barangs = \App\Models\Barang::with(['kategori', 'admin'])->get();
    
    return view('admin.kelola_barang', compact('barangs'));
});

Route::get('/tambah_barang', function () {
    if (!session()->has('admin_login')) {
        return redirect('/login');
    }
    return app(BarangController::class)->create();
});

Route::post('/tambah_barang/store', [BarangController::class, 'store']);

Route::get('/barang/{id}/edit', function ($id) {
    if (!session()->has('admin_login')) {
        return redirect('/login');
    }
    return app(BarangController::class)->edit($id);
});

Route::put('/barang/{id}/update', [BarangController::class, 'update']);

Route::delete('/barang/{id}/delete', function ($id) {
    \App\Models\Barang::where('id_barang', $id)->delete();
    
    return redirect('/kelola_barang')->with('success', 'Barang berhasil dihapus dari koleksi!');
});

Route::get('/lihat_tiket', function () {
    if (!session()->has('admin_login')) { 
        return redirect('/login'); 
    }
    
    $tiketBelumDipakai = \App\Models\Tiket::where('status_tiket', 'Belum Dipakai')
                            ->orderBy('id_tiket', 'desc')
                            ->get();

    $tiketSudahDipakai = \App\Models\Tiket::where('status_tiket', 'Sudah Dipakai')
                            ->orderBy('id_tiket', 'desc')
                            ->get();
    
    return view('admin.lihat_tiket', compact('tiketBelumDipakai', 'tiketSudahDipakai'));
});

Route::patch('/tiket/{id}/checkin', [App\Http\Controllers\TiketController::class, 'checkIn'])->name('tiket.checkin');

Route::delete('/tiket/{id}/delete', function ($id) {
    \App\Models\Tiket::where('id_tiket', $id)->delete();
    return back()->with('success', 'Tiket berhasil dihapus!');
});

Route::get('/', function () { return view('home'); })->name('home');
Route::get('/about', function () { return view('about'); })->name('about');

// Rute Koleksi (Hanya ada SATU dan mengambil data dari database)
Route::get('/koleksi', function () {
    // Mengambil semua data dari tabel barang
    $koleksi = \App\Models\Barang::all(); 
    
    // Mengirim variabel $koleksi ke tampilan blade
    return view('koleksi', compact('koleksi')); 
})->name('koleksi');

// Rute untuk MENAMPILKAN halaman form pemesanan tiket
Route::get('/tiket', function () { 
    return view('tiket'); 
})->name('tiket');

// Rute untuk menangkap data saat tombol "BAYAR SEKARANG" diklik
Route::post('/tiket/pesan', [TiketController::class, 'store'])->name('tiket.store');

// Rute untuk menampilkan halaman QR Code / Tiket Berhasil
Route::get('/tiket/berhasil/{id}', [TiketController::class, 'sukses'])->name('tiket.sukses');

Route::get('/tiket/{id}/pdf', [\App\Http\Controllers\TiketController::class, 'cetakPDF'])->name('tiket.pdf');