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
        Schema::create('keuangan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keuangan_perusahaan_id');
            $table->foreignId('tagihan_id')->nullable();
            $table->foreignId('project_team_fee_id')->nullable();
            $table->foreignId('termin_id')->nullable();
            $table->foreignId('langsung_id')->nullable();
            $table->foreignId('supplier_id')->nullable();
            $table->foreignId('bank_id')->nullable();
            $table->string('tanggal');
            $table->string('description');
            $table->enum('status', ['pemasukan', 'pengeluaran']);
            $table->bigInteger('total');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan_details');
    }
};