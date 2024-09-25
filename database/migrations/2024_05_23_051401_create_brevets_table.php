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
        Schema::create('brevets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('nama');
            $table->string('mitra');
            $table->string('brevet');
            $table->string('surat_keterangan_aktif');
            $table->string('bpjs');
            $table->string('sertifikat_brevet');
            $table->boolean('status_brevet')->default(false);
            $table->text('keterangan')->nullable();
            $table->string('upload_sertifikat')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('mitra_manajemen')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brevets');
    }
};
