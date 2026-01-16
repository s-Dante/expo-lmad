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
        Schema::create('tbl_autores_proyecto', function (Blueprint $table) {
            $table->foreignId('proyecto_id')->constrained('tbl_proyectos')->onDelete('cascade');
            $table->foreignId('estudiante_id')->constrained('tbl_estudiantes')->onDelete('cascade');
            $table->boolean('es_lider')->default(false);
            $table->primary(['proyecto_id', 'estudiante_id'], 'primary_proyecto_estudiante');
            $table->softDeletes();
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_autores_proyecto');
    }
};
