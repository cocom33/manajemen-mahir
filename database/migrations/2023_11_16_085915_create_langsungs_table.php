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
        Schema::create('langsungs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('keuangan_project_id');
            $table->foreignId('bank_id')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('price');
            $table->date('tanggal');
            $table->boolean('status')->default(0);
            $table->string('lampiran')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('langsungs');
    }
};