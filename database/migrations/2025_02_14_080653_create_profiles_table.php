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
    Schema::create('profiles', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_user');
        $table->string('nik', 16)->nullable();
        $table->string('npwp', 16)->nullable();
        $table->string('gender')->nullable();
        $table->date('tanggal_lahir')->nullable();
        $table->string('foto')->nullable();
        $table->timestamps();
    
        $table->foreign('id_user')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
    });
    
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
