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
        Schema::create('pengeluarans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id');
            $table->foreignId('project_team_fee_id')->nullable();
            $table->foreignId('tagihan_id')->nullable();
            $table->foreignId('bank_id')->nullable();
            $table->string('title');
            $table->string('description')->nullable();
            $table->bigInteger('price');
            $table->date('date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};