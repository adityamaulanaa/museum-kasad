<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;

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

Route::get('/kelola_barang', function () {
    if (!session()->has('admin_login')) {
        return redirect('/login');
    }
    return app(BarangController::class)->index(); 
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
    return back()->with('success', 'Barang berhasil dihapus dari koleksi!');
});

Route::get('/lihat_tiket', function () {
    if (!session()->has('admin_login')) { 
        return redirect('/login'); 
    }
    
    $tikets = \App\Models\Tiket::all();
    return view('admin.lihat_tiket', compact('tikets'));
});

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

Route::get('/tiket', function () { return view('tiket'); })->name('tiket');
Route::get('/tiket/berhasil', function () { return view('tiket-berhasil'); })->name('tiket.berhasil');