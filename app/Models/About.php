<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $table = 'about'; // Mengunci nama tabel agar sesuai di database
    
    protected $fillable = [
        'judul',
        'konten',
        'gambar_about'
    ];
}
