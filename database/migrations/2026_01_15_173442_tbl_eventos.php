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
        Schema::create('tbl_eventos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->enum('tipo', ['conferencia', 'taller', 'seminario', 'webinar']);
            $table->text('descripcion_evento')->nullable();
            $table->dateTime('fecha_inicio_evento');
            $table->dateTime('fecha_fin_evento');
            $table->string('ubicacion_evento')->nullable();
            $table->unsignedInteger('capacidad')->nullable();
            $table->string('poster_evento')->nullable();
            $table->enum('estatus_evento', ['programado', 'en_curso', 'finalizado', 'cancelado'])->default('programado');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_eventos');
    }
};
