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
            $table->string('tipo', 30);

            //Datos UANL
            $table->string('matricula')->nullable()->index();
            $table->string('dependencia')->nullable();
            $table->string('carrera')->nullable();
            $table->string('semestre')->nullable();

            //Datos Externos
            $table->string('genero', 5)->nullable();
            $table->string('rango-edad', 10)->nullable();
 
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
