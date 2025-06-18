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
        Schema::create('data_point_pelanggarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggaran', 255)->unique();
            $table->integer('point_pelanggaran');
            $table->foreignId('tata_tertib_id')->constrained('tata_tertibs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_point_pelanggarans');
    }
};
