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
        Schema::create('tbl_representantes_patrocinador', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patrocinador_id')->constrained('tbl_patrocinadores')->onDelete('cascade');
            $table->foreignId('visitante_id')->constrained('tbl_visitantes')->onDelete('cascade');
            $table->string('cargo')->nullable();
            $table->unique(['patrocinador_id', 'visitante_id']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_representantes_patrocinador');
    }
};
