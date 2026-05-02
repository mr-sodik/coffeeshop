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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();

            $table->string('nama_menu');
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');

            $table->integer('harga');
            $table->text('deskripsi')->nullable();
            $table->string('foto')->nullable();

            $table->tinyInteger('status')->default(1); // 1 = tampil, 0 = tidak tampil

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};