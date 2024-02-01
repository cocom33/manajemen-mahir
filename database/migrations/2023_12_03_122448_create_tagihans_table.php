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

            $table->foreignId('project_id')->nullable();
            $table->foreignId('client_id')->nullable();
            $table->foreignId('supplier_id')->nullable();
            $table->foreignId('bank_id')->nullable();
            $table->string('title');
            $table->text('description');
            $table->bigInteger('harga_beli');
            $table->bigInteger('harga_jual');
            $table->bigInteger('total');
            $table->date('date_start');
            $table->date('date_end');
            $table->boolean('is_active')->default(1);
            $table->boolean('is_lunas')->default(0);
            $table->boolean('is_with_project')->default(0);
            $table->boolean('is_finish')->default(0);

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