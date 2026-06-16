<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $table = 'pemesanan'; 
    protected $primaryKey = 'id_tiket';

    // TAMBAHKAN BARIS INI UNTUK NONAKTIFKAN CREATED_AT & UPDATED_AT
    public $timestamps = false;

    protected $fillable = [
        'kode_tiket', 
        'nama_pengunjung', 
        'no_telp', 
        'email', 
        'jumlah_dewasa', 
        'jumlah_mahasiswa', 
        'jumlah_anak', 
        'tgl_kunjungan', 
        'metode_pembayaran', 
        'total_harga',
        'status_tiket',
    ];
}