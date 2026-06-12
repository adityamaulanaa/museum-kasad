<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $table = 'pemesanan'; 

    protected $primaryKey = 'id_tiket'; 

    public $timestamps = false; 

    protected $fillable = [
        'nama_pengunjung', 
        'email', 
        'no_telp', 
        'jumlah_dewasa', 
        'jumlah_anak', 
        'jumlah_mahasiswa', 
        'metode_pembayaran', 
        'tgl_kunjungan', 
        'tgl_beli'
    ];
}
