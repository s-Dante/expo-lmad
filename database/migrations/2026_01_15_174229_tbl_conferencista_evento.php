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
        Schema::create('tbl_conferencista_evento', function (Blueprint $table) {
            $table->foreignId('conferencista_id')->constrained('tbl_conferencistas')->onDelete('cascade');
            $table->foreignId('evento_id')->constrained('tbl_eventos')->onDelete('cascade');
            $table->primary(['conferencista_id', 'evento_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_conferencista_evento');
    }
};
