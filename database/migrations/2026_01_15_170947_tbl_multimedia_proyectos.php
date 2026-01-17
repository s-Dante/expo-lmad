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
        Schema::create('tbl_multimedia_proyectos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained('tbl_proyectos')->onDelete('cascade');
            $table->enum('tipo', ['imagen', 'video', 'documento', 'youtube', 'drive', 'github']);
            $table->string('url');
            $table->string('titulo')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('es_portada')->default(false);
            
            // $table->unique(
            //     ['proyecto_id'],
            //     'unique_portada_por_proyecto'
            // )->where('es_portada', true);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_multimedia_proyectos');
    }
};
