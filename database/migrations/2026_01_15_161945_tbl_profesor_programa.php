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
        Schema::create('tbl_profesor_programa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profesor_id')->constrained('tbl_profesores')->onDelete('cascade');
            $table->foreignId('programa_academico_id')->constrained('tbl_programas_academicos')->onDelete('restrict');
            $table->unique(['profesor_id', 'programa_academico_id'], 'unique_profesor_programa');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_profesor_programa');
    }
};
