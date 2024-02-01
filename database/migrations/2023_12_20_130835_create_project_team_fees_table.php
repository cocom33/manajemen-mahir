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
        Schema::create('project_team_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_team_id');
            $table->bigInteger('bank_id')->nullable();
            $table->bigInteger('bank')->nullable();
            $table->bigInteger('fee');
            $table->string('photo')->nullable();
            $table->date('tenggat');
            $table->boolean('status')->default(0);
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