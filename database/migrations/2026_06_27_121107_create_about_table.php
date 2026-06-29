<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('about', function (Blueprint $table) {
            $table->id(); 
            $table->string('judul');
            $table->longText('konten'); // Pakai longText biar deskripsi museum muat panjang lebar
            $table->string('gambar_about')->nullable(); // nullable biar kalau belum ada foto gak bikin error
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('about');
    }
};
