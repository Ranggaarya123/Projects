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
        Schema::create('duplicate_wh', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('sto');
            $table->string('kode_wh');
            $table->boolean('status_duplicate')->default(false);
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
        Schema::dropIfExists('duplicate_wh');
    }
};
