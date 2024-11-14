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
        Schema::create('aktivasi_nik', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('user_id');
            $table->string('surat_keterangan_aktif');
            $table->string('scan_bpjs');
            $table->string('scan_ktp');
            $table->string('sertifikat_brevet');
            $table->boolean('status_aktivasi_nik')->default(false);
            $table->text('komentar')->nullable(); // Add this line
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('mitra_manajemen')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aktivasi_nik');
    }
};
