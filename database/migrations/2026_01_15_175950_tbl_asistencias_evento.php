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
        Schema::create('tbl_asistencias_evento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->constrained('tbl_eventos')->onDelete('cascade');
            $table->foreignId('visitantes_id')->constrained('tbl_visitantes')->onDelete('cascade');
            $table->boolean('asistencia')->default(false);
            $table->dateTime('fecha_asistencia');
            $table->unique(['evento_id', 'visitantes_id'], 'unique_evento_visitante');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_asistencias_evento');
    }
};
