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
        Schema::create('tbl_materias', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 20)->nullable(); //<- Para tener la clave propia de la materia segun siase
            $table->string('nombre');
            $table->string('abreviatura', 10)->nullable();
            $table->text('descripcion')->nullable();
            $table->unsignedTinyInteger('creditos');
            $table->unsignedTinyInteger('semestre');
            $table->foreignId('plan_academico_id')->constrained('tbl_planes_academicos')->onDelete('restrict');
            $table->unique(['clave', 'plan_academico_id'], 'unique_clave_plan');
            $table->index('semestre');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_materias');
    }
};
