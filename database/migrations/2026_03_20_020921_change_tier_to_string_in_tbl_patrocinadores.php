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
        Schema::table('tbl_patrocinadores', function (Blueprint $table) {
            $table->string('tier')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_patrocinadores', function (Blueprint $table) {
            $table->enum('tier', ['Bronce', 'Plata', 'Oro', 'Platino'])->change();
        });
    }
};
