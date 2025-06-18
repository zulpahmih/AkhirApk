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
        Schema::create('walikelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_jurusan_id')->constrained('kelas_jurusans')->onDelete('cascade')->nullable();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade')->nullable();
            $table->timestamps();

            $table->unique('kelas_jurusan_id');
            $table->unique('guru_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('walikelas');
    }
};
