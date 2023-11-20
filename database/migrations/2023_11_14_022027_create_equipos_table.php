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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion');
            $table->unsignedBigInteger('tipo_equipo_id');
            $table->foreign(['tipo_equipo_id'])->references(['id'])->on('tipo_equipos')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('idUsuario');
            $table->foreign(['idUsuario'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->boolean('estado');
            $table->boolean('disponible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
