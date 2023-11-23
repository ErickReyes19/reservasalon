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
        Schema::create('asistente_reservas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idAsistente');
            $table->foreign(['idAsistente'])->references(['id'])->on('asistentes')->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::dropIfExists('asistente_reservas');
    }
};
