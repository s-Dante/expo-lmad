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
        Schema::table('tbl_visitantes', function (Blueprint $table) {
            $table->string('nombre_completo')->nullable()->after('uuid');
            $table->string('nombre')->nullable()->change();
            $table->string('apellido_paterno')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('tbl_visitantes', function (Blueprint $table) {
            $table->dropColumn('nombre_completo');
            $table->string('nombre')->nullable(false)->change();
            $table->string('apellido_paterno')->nullable(false)->change();
        });
    }
};
