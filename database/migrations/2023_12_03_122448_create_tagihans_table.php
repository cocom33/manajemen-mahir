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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id');
            $table->string('title');
            $table->text('description');
            $table->integer('harga_awal');
            $table->integer('harga_asli');
            $table->integer('total');
            $table->date('date_start');
            $table->integer('date');
            $table->string('date_type');
            $table->boolean('is_active')->default(1);
            $table->boolean('is_lunas')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};