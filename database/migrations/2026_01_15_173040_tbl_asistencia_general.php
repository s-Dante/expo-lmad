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
        Schema::create('tbl_asistencias_general', function (Blueprint $table) {
        $table->id();
        $table->foreignId('estudiante_id')->constrained('tbl_estudiantes')->onDelete('cascade');
        $table->timestamp('hora_entrada')->useCurrent();
        $table->unique('estudiante_id'); 
        $table->softDeletes();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_asistencias_general');
    }
};
