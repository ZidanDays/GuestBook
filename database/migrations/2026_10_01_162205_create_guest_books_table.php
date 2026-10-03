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
        Schema::create('guest_books', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('nama');
            $table->string('nik_nip')->nullable();
            $table->text('alamat');
            $table->string('jabatan')->nullable();
            $table->text('maksud_tujuan');
            $table->text('keterangan')->nullable();
            $table->string('foto')->nullable(); //hanya menyimpan path file dari foto
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_books');
    }
};
