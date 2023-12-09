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
            $table->foreignId('project_team_id');
            $table->bigInteger('fee');

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