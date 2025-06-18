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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->char('nis',10)->unique();
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->char('no_hp', 13)->nullable();
            $table->text('alamat');
            $table->integer('status')->default(0);
            $table->timestamps();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kelas_jurusan_id')->constrained('kelas_jurusans')->onDelete('cascade');
            $table->foreignId('orang_tuas_id')->nullable()->constrained('orang_tuas')->onDelete('cascade');



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
