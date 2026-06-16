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
        Schema::table('pemesanan', function (Blueprint $table) {
            // Menambahkan kolom kode_tiket setelah kolom id_tiket (atau id)
            $table->string('kode_tiket', 20)->unique()->after('id_tiket'); 
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropColumn('kode_tiket');
        });
    }
};
