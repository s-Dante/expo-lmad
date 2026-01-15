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
        Schema::create('tbl_conferencistas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();
            $table->string('nickname')->unique()->nullable();
            $table->text('biografia')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('telefono')->nullable();
            $table->string('empresa')->nullable();
            $table->string('cargo')->nullable();
            $table->string('foto_url')->nullable();
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
        Schema::dropIfExists('tbl_conferencistas');
    }
};
