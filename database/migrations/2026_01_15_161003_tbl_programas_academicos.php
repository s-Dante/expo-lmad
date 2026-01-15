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
        Schema::create('tbl_programas_academicos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('abreviatura', 10)->unique();
            $table->text('descripcion')->nullable();
            $table->boolean('estatus')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_programas_academicos');
    }
};
