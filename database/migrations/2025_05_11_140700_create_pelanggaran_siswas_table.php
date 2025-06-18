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
        Schema::create('pelanggaran_siswas', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->date('tanggal_pelanggaran');
            $table->timestamps();

            $table->foreignId('siswas_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('data_point_pelanggarans_id')->constrained('data_point_pelanggarans')->onDelete('cascade');
            $table->foreignId('kelas_jurusan_id')->constrained('kelas_jurusans')->onDelete('cascade');
            $table->foreignId('tata_tertib_id')->constrained('tata_tertibs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggaran_siswas');
    }
};
