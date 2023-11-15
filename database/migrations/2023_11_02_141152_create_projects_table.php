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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug');
            $table->foreignId('client_id');
            $table->foreignId('project_type_id');
            $table->string('description');
            $table->enum('status', ['penawaran', 'deal', 'finish', 'cancel'])->default('penawaran');
            $table->date('start_date')->nullable();
            $table->date('deadline_date')->nullable();
            $table->integer('harga_penawaran')->nullable();
            $table->integer('harga_deal')->nullable();
            $table->enum('status_server', ['mahir', 'mandiri'])->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};