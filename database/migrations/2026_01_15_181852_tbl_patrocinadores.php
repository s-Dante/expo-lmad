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
        Schema::create('tbl_patrocinadores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('tier', ['Bronce', 'Plata', 'Oro', 'Platino']);
            $table->string('logo_url')->nullable();
            $table->string('website_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_patrocinadores');
    }
};
