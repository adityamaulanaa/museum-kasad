<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;

class BarangController extends Controller {
    
    public function index()
    {
        $barangs = Barang::with('kategori')->get(); 
        $categories = Kategori::all(); 
        
        return view('admin.kelola_barang', compact('barangs'));
    }

    public function create() {
        $categories = Kategori::all(); 
        return view('admin.tambah_barang', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_barang'        => 'required|string',
            'id_kategori'        => 'required',
            'tahun_barang'       => 'required',
            'bahan_barang'       => 'required',
            'asal_barang'        => 'required',

        ]);

        $barang = new Barang();
        $barang->nama_barang = $request->nama_barang;
        $barang->id_kategori = $request->id_kategori;
        $barang->tahun_barang = $request->tahun_barang;
        $barang->bahan_barang = $request->bahan_barang;
        $barang->asal_barang = $request->asal_barang;
        $barang->kategori_barang = $request->kategori_barang;
        $barang->deskripsi_barang = $request->deskripsi_barang;
        
        $barang->id_admin = session('id_admin');

        if ($request->hasFile('gambar_barang')) {
            $imageName = time() . '.' . $request->gambar_barang->extension();
            $request->gambar_barang->move(public_path('images/barang'), $imageName);
            $barang->gambar_barang = 'images/barang/' . $imageName;
        }

        $barang->save(); 

        return redirect('/kelola_barang')->with('success', 'Barang berhasil disimpan!');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $categories = Kategori::all(); 
        
        return view('admin.edit_barang', compact('barang', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string',
            'id_kategori' => 'required',
            'tahun_barang'       => 'required',
            'bahan_barang'       => 'required',
            'asal_barang'        => 'required',
        ]);

        $barang = Barang::findOrFail($id);
        
        $barang->nama_barang = $request->nama_barang;
        $barang->id_kategori = $request->id_kategori;
        $barang->tahun_barang = $request->tahun_barang;
        $barang->bahan_barang = $request->bahan_barang;
        $barang->asal_barang = $request->asal_barang;
        $barang->kategori_barang = $request->kategori_barang;
        $barang->deskripsi_barang = $request->deskripsi_barang;
        
        $barang->id_admin = session('id_admin');

        if ($request->hasFile('gambar_barang')) {
            $imageName = time() . '.' . $request->gambar_barang->extension();
            $request->gambar_barang->move(public_path('images/barang'), $imageName);
            $barang->gambar_barang = 'images/barang/' . $imageName;
        }

        $barang->save(); 

        return redirect('/kelola_barang')->with('success', 'Data barang berhasil diubah!');
    }
}