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
        Schema::create('dokumen_surat', function (Blueprint $table) {
            $table->id();
            $table->string('kode_surat');
            $table->string('jenis_surat');
            $table->date('tanggal_pembuatan');
            $table->text('keterangan')->nullable();
            $table->integer('status')->default(0); // 0: menunggu, 1: acc, 2: tolak
            $table->string('link_file')->nullable();
            $table->string('ttd_kepsek')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_surat');
    }
};
