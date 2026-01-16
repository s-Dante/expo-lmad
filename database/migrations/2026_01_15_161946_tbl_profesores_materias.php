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
        Schema::create('tbl_materia_profesor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profesor_id')->constrained('tbl_profesores')->onDelete('cascade');
            $table->foreignId('materia_id')->constrained('tbl_materias')->onDelete('cascade');
            $table->unique(['profesor_id', 'materia_id'], 'unique_profesor_materia');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_profesor_materia');
    }
};
