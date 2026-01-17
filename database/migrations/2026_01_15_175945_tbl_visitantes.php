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
        Schema::create('tbl_visitantes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->enum('tipo', ['externo', 'estudiante', 'sponsor', 'staff', 'profesor', 'directivos']);

            //Datos UANL
            $table->string('matricula')->nullable()->index();
            $table->string('dependencia')->nullable();
            $table->string('carrera')->nullable();
            $table->string('semestre')->nullable();

            //Datos Externos
            $table->enum('genero', ['M', 'F', 'O'])->nullable();
            $table->enum('rango-edad', ['<15', '15-25', '26-35', '36-45', '46-55', '56+'])->nullable();
 
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_visitantes');
    }
};
