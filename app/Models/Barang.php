<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'id_barang'; 
    public $timestamps = false; 

    protected $fillable = [
        'nama_barang',
        'id_kategori',
        'tahun_barang',
        'bahan_barang',
        'asal_barang',
        'kategori_barang',
        'deskripsi_barang',
        'gambar_barang',
        'id_admin'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }
}