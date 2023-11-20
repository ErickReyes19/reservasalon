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
        Schema::create('extra_reservas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idReserva');
            $table->foreign(['idReserva'])->references(['id'])->on('reservas')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('idExtra');
            $table->foreign(['idExtra'])->references(['id'])->on('extras')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extras_reservas');
    }
};
