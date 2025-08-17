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
        Schema::table('pemasukans', function (Blueprint $table) {
            $table->dropForeign(['kode_akun']); // hapus dulu FK lama
            $table->foreign('kode_akun')
                ->references('kode_akun')
                ->on('kodes');
        });
        
        Schema::table('pengeluarans', function (Blueprint $table) {
            $table->foreign('kode_akun')
                ->references('kode_akun')
                ->on('kodes');
        });
           
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasukans');
        Schema::dropIfExists('pengeluarans');
    }
};
