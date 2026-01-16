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
        Schema::create('tbl_proyectos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('slug')->unique();

            $table->enum('estatus', [
                'borrador',
                'enviado',
                'aprobado',
                'rechazado',
                'eliminado'
            ])
            ->default('borrador');

            $table->string('codigo_acceso')->index();
            $table->foreignId('profesor_id')->constrained('tbl_profesores')->onDelete('restrict');
            $table->foreignId('materia_id')->constrained('tbl_materias')->onDelete('restrict');
            $table->string('periodo_semestral');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_proyectos');
    }
};
