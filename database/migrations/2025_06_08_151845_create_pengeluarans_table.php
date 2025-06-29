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
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('kode_akun');
            $table->string('keterangan');
            $table->decimal('gaji', 15, 2)->default(0)->nullable();
            $table->decimal('biaya_kirim', 15, 2)->default(0)->nullable();
            $table->decimal('transportasi', 15, 2)->default(0)->nullable();
            $table->decimal('lpti', 15, 2)->default(0)->nullable();
            $table->decimal('atk', 15, 2)->default(0)->nullable();
            $table->decimal('bahan', 15, 2)->default(0)->nullable();
            $table->decimal('peralatan', 15, 2)->default(0)->nullable();
            $table->decimal('lain_lain', 15, 2)->default(0)->nullable();
            $table->decimal('invest', 15, 2)->default(0)->nullable();
            $table->decimal('vendor', 15, 2)->default(0)->nullable();
            $table->decimal('profit', 15, 2)->default(0)->nullable();
            $table->decimal('cicilan', 15, 2)->default(0)->nullable();
            $table->decimal('pajak', 15, 2)->default(0)->nullable();
            $table->decimal('pemindahan', 15, 2)->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
