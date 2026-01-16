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
        Schema::create('tbl_softwares_por_proyectos', function (Blueprint $table) {
            $table->foreignId('proyecto_id')->constrained('tbl_proyectos')->onDelete('cascade');
            $table->foreignId('software_id')->constrained('tbl_softwares')->onDelete('cascade');

            $table->primary(['proyecto_id', 'software_id'], 'primary_proyecto_software');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_softwares_por_proyectos');
    }
};
