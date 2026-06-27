<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Barang;
use App\Models\Kategori;


class BarangController extends Controller {
    
    public function index()
    {
        $barangs = Barang::with(['kategori', 'admin'])
                         ->latest('updated_at')
                         ->get(); 
        $categories = Kategori::all(); 
        
        return view('admin.kelola_barang', compact('barangs', 'categories'));
    }

    public function create() {
        $categories = Kategori::all(); 
        return view('admin.tambah_barang', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_barang'  => 'required|string',
            'id_kategori'  => 'required',
            'tahun_barang' => 'required',
            'bahan_barang' => 'required',
            'asal_barang'  => 'required',
        ]);

        $barang = new Barang();
        $barang->nama_barang = $request->nama_barang;
        $barang->id_kategori = $request->id_kategori;
        $barang->tahun_barang = $request->tahun_barang;
        $barang->bahan_barang = $request->bahan_barang;
        $barang->asal_barang = $request->asal_barang;

        $kategori = \App\Models\Kategori::where('id_kategori', $request->id_kategori)->first();
        $barang->kategori_barang = $kategori ? $kategori->nama_kategori : '-';

        $barang->deskripsi_barang = $request->deskripsi_barang;
        $barang->id_admin = session('id_admin');
        $barang->deskripsi_barang = $request->deskripsi_barang;
        
        $barang->id_admin = session('id_admin');

        // 2. Proses upload gambar (Kita pakai cara temenmu yang rapi namanya pake slug, tapi path foldernya tetap aman)
        if ($request->hasFile('gambar_barang')) {
            $cleanName = Str::slug($request->nama_barang);
            $imageName = $cleanName . '-' . time() . '.' . $request->gambar_barang->extension();
            $request->gambar_barang->move(public_path('images/koleksi'), $imageName);
            
            $barang->gambar_barang = $imageName;
            
        }
            $barang->save(); 

            return redirect('/kelola_barang')->with('success', 'Barang berhasil disimpan!');
        }

    public function edit($id)
    {
        $barang = Barang::where('id_barang', $id)->firstOrFail();
        $categories = Kategori::all(); 
        
        return view('admin.edit_barang', compact('barang', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang'  => 'required|string',
            'id_kategori'  => 'required',
            'tahun_barang' => 'required',
            'bahan_barang' => 'required',
            'asal_barang'  => 'required',
        ]);

        $barang = Barang::where('id_barang', $id)->firstOrFail();
        
        $barang->nama_barang = $request->nama_barang;
        $barang->id_kategori = $request->id_kategori;
        $barang->tahun_barang = $request->tahun_barang;
        $barang->bahan_barang = $request->bahan_barang;
        $barang->asal_barang = $request->asal_barang;

        $kategori = \App\Models\Kategori::where('id_kategori', $request->id_kategori)->first();
        $barang->kategori_barang = $kategori ? $kategori->nama_kategori : '-';

        $barang->deskripsi_barang = $request->deskripsi_barang;
        $barang->id_admin = session('id_admin');

        $barang->deskripsi_barang = $request->deskripsi_barang;
        
        $barang->id_admin = session('id_admin');

        // 2. Proses upload gambar (Kita pakai cara temenmu yang rapi namanya pake slug, tapi path foldernya tetap aman)
        if ($request->hasFile('gambar_barang')) {
            $cleanName = \Illuminate\Support\Str::slug($request->nama_barang);
            $imageName = $cleanName . '-' . time() . '.' . $request->gambar_barang->extension();
            $request->gambar_barang->move(public_path('images/koleksi'), $imageName);
            
            $barang->gambar_barang = $imageName;
        }

        $barang->save(); 

        return redirect('/kelola_barang')->with('success', 'Data barang berhasil diubah!');
    }

    public function cetakPdf()
    {
        // Ambil semua data barang beserta kategorinya
        $barangs = Barang::with('kategori')->get();
        
        // Load view khusus cetak dan lempar data koleksinya
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.cetak_koleksi_pdf', compact('barangs'));
        
        // Set ukuran kertas ke A4 Landscape biar tabelnya muat lebar
        $pdf->setPaper('a4', 'landscape');
        
        // Download otomatis dengan nama file berikut
        return $pdf->download('Laporan_Koleksi_Museum_KASAD_' . date('Ymd') . '.pdf');
    }

}
