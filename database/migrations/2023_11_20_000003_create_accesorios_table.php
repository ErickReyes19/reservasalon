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
        Schema::create('accesorios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion');
            $table->unsignedBigInteger('tipo_accesorios_id');
            $table->foreign(['tipo_accesorios_id'])->references(['id'])->on('tipo_accesorios')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->unsignedBigInteger('idUsuario');
            $table->foreign(['idUsuario'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->boolean('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accesorios');
    }
};
