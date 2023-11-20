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
        Schema::create('equipo_reservas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idEquipo');
            $table->foreign(['idEquipo'])->references(['id'])->on('equipos')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('idReserva');
            $table->foreign(['idReserva'])->references(['id'])->on('reservas')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipo_reservas');
    }
};
