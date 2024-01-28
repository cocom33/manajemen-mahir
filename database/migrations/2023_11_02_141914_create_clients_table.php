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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('wa');
            $table->string('email');
            $table->string('alamat');
            $table->enum('sumber', ['iklan', 'teman', 'wa'])->nullable();
            $table->string('nama_rekening');
            $table->string('nomor_rekening');
            $table->string('nasabah_bank');
            $table->string('nama_perusahaan')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
