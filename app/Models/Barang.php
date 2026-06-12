<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model {
    protected $table = 'barang';
    protected $primaryKey = 'id_barang';
    protected $fillable = [
        'nama_barang', 
        'deskripsi_barang', 
        'gambar_barang', 
        'tahun_barang', 
        'bahan_barang', 
        'asal_barang', 
        'id_kategori', 
        'id_admin'];
    public $timestamps = False;

    public function admin()
{
    return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
}

    public function kategori() {
    return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');

    
}
}
