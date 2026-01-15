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
        Schema::create('tbl_planes_academicos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->boolean('estatus')->default(true);
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
        Schema::dropIfExists('tbl_planes_academicos');
    }
};
