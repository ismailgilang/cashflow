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
        Schema::create('pemasukans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('kode_akun');
            $table->string('keterangan');
            $table->decimal('omset_konter', 15, 2)->default(0)->nullable();
            $table->decimal('omset_retail', 15, 2)->default(0)->nullable();
            $table->decimal('investor', 15, 2)->default(0)->nullable();
            $table->decimal('refund', 15, 2)->default(0)->nullable();
            $table->decimal('pemindahan_dana', 15, 2)->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasukans');
    }
};
