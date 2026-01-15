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
        Schema::create('tbl_estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('matricula', 20)->unique();
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();
            $table->unsignedTinyInteger('semestre');
            $table->foreignId('usuario_id')->nullable()->unique()->constrained('tbl_usuarios')->nullOnDelete();
            $table->string('email')->unique()->nullable(); //<- Revisar si es algo que nos pueden proporcionar, espero y creo que si
            $table->foreignId('programa_academico_id')->constrained('tbl_programas_academicos')->onDelete('restrict');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_estudiantes');
    }
};
