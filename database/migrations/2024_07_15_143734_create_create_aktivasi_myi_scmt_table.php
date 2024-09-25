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
        Schema::create('create_aktivasi_myi_scmt', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('username');
            $table->string('myiscmt_type');
            $table->string('email');
            $table->string('id_tele');
            $table->string('no_hp');
            $table->string('sto');
            $table->string('kode_wh');
            $table->string('capture_hcmbot');
            $table->string('capture_tactical');
            $table->boolean('status_myi')->default(false);
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
        Schema::dropIfExists('aktivasi_scmt');
    }
};
