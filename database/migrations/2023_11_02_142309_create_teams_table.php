<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('teams', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->enum('status', ['freelance', 'tetap']);
        $table->string('wa');
        $table->string('email');
        $table->string('alamat');

        $table->softDeletes();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
