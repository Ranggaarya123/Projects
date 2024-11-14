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
        Schema::create('mitra_manajemen', function (Blueprint $table) {
            $table->uuid('id');
            $table->integer('user_id')->primary();
            $table->string('username');
            $table->string('witel')->nullable();
            $table->string('alokasi')->nullable();
            $table->string('mitra')->nullable();
            $table->string('craft')->nullable();
            $table->string('sto')->nullable();
            $table->string('wh')->nullable();
            $table->integer('status_aktivasi_nik')->default(0);
            $table->integer('status_brevet')->default(0);
            $table->integer('status_tactical')->default(0);
            $table->integer('status_labor')->default(0);
            $table->integer('status_myi')->default(0);
            $table->integer('status_scmt')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitra_manajemen');
    }
};
