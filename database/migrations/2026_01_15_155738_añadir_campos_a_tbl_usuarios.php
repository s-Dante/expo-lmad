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
        Schema::table('tbl_usuarios', function (Blueprint $table) {
            $table->string('nombre')->after('name');
            $table->string('apellido_paterno')->after('nombre');
            $table->string('apellido_materno')->after('apellido_paterno')->nullable();
            $table->string('llave_acceso')->unique()->nullable()->after('password');
            $table->enum('rol', ['estudiante', 'profesor', 'admin', 'super_admin', 'staff'])->default('estudiante')->index()->after('llave_acceso');
            $table->boolean('estatus')->default(true)->after('rol');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_usuarios', function (Blueprint $table) {
            $table->dropColumn([
                'nombre', 
                'apellido_paterno', 
                'apellido_materno', 
                'llave_acceso',
                'rol', 
                'estatus'
            ]);
        });
    }
};
