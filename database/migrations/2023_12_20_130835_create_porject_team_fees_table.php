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
        Schema::create('porject_team_fees', function (Blueprint $table) {
            $table->id();
            $table->string('project_teams_id');
            $table->bigInteger('fee');
            $table->bigInteger('total_fee');
            $table->date('tanggal_pembayaran');
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('porject_team_fees');
    }
};