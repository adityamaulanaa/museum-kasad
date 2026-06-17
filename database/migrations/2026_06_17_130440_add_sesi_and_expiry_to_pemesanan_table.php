<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->string('sesi')->nullable(); // Menambah kolom sesi
            $table->timestamp('expired_at')->nullable(); // Menambah kolom waktu kedaluwarsa
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropColumn(['sesi', 'expired_at']); // Menghapus kolom jika migrasi dibatalkan
        });
    }
};