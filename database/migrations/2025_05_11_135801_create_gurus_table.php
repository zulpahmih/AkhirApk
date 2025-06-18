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
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable(); // tambah kolom foto
            $table->char('nip', '20')->unique();
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->string('jabatan')->nullable();
            $table->char('no_hp', 15)->nullable();
            $table->text('alamat');
            $table->timestamps();

            $table->foreignId('user_id')
              ->nullable()
              ->constrained()
              ->nullOnDelete();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
