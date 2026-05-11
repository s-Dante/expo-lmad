<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Añade el campo 'token' a tbl_asistencias_evento para la confirmación
 * de asistencia por correo electrónico (Opción 2).
 *
 * El token se genera al momento del registro y se envía al correo del
 * visitante; se ingresa en /Asistencia para confirmar la salida del evento.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_asistencias_evento', function (Blueprint $table) {
            // Token único enviado por correo para confirmar asistencia
            $table->string('token', 64)->nullable()->unique()->after('asistencia');
            // Fecha de expiración del token (opcional, para seguridad)
            $table->dateTime('token_expira_at')->nullable()->after('token');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_asistencias_evento', function (Blueprint $table) {
            $table->dropColumn(['token', 'token_expira_at']);
        });
    }
};
