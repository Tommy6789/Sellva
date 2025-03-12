<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Enum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_user');
        $table->integer('total');
        $table->string('metode_pembayaran')->nullable();
        $table->integer('nominal_pembayaran')->nullable();
        $table->integer('kembalian')->nullable();
        $table->dateTime('waktu_order');
        $table->dateTime('waktu_pembayaran');
        $table->enum('status', ['proses', 'selesai'])->default('proses');
        $table->timestamps();

        $table->foreign('id_user')->references('id')->on('users');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
