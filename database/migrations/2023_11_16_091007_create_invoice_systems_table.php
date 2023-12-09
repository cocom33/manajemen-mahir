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
        Schema::create('invoice_systems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id');
            $table->string('description');
            $table->bigInteger('price');
            $table->integer('date');
            $table->enum('date_type', ['year', 'month', 'week', 'day']);
            $table->integer('total');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_systems');
    }
};