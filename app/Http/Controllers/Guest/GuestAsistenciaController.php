<?php

declare(strict_types=1);

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Mail\AsistenciaToken;
use App\Models\AsistenciaEvento;
use App\Models\Evento;
use App\Models\Visitante;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

/**
 * Controlador público para el flujo de registro y confirmación de asistencia
 * a eventos (AFI) de la Expo LMAD.
 *
 * Flujo:
 *  1. QR de entrada  → GET  /Registro   → vista registro.blade.php
 *  2. POST /api/registro-asistencia      → registra visitante + asistencia (asistencia=false)
 *  3. QR de salida   → GET  /Asistencia  → vista asistencia.blade.php
 *  4a. POST /api/confirmar-matricula     → Opción 1: confirma por matrícula
 *  4b. POST /api/confirmar-token         → Opción 2: confirma por token de correo
 */
class GuestAsistenciaController extends Controller
{
    // ─── API: Eventos activos ────────────────────────────────────────────────

    /**
     * Retorna los eventos activos/programados para poblar el select
     * de conferencias en el formulario de /Registro.
     */
    public function getEventos(): JsonResponse
    {
        $eventos = Evento::whereIn('estatus_evento', ['programado', 'en_curso'])
            ->whereNull('deleted_at')
            ->select('id', 'titulo', 'tipo', 'fecha_inicio_evento', 'ubicacion_evento')
            ->orderBy('fecha_inicio_evento')
            ->get();

        return response()->json(['eventos' => $eventos]);
    }

    // ─── API: Registro de asistencia ─────────────────────────────────────────

    /**
     * Registra al visitante en un evento.
     * Crea (o reutiliza) su registro en tbl_visitantes y crea un registro
     * en tbl_asistencias_evento con asistencia = false.
     *
     * Si el visitante ya estaba registrado en ese evento, devuelve 200
     * informándole (no duplica).
     *
     * Opción 2 (token): si se proporciona un correo válido, genera un token
     * y lo envía por correo.
     */
    public function registrar(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nombre'     => 'required|string|max:120',
            'matricula'  => 'nullable|string|max:20',
            'correo'     => 'nullable|email|max:120',
            'facultad'   => 'nullable|string|max:60',
            'carrera'    => 'nullable|string|max:60',
            'dependencia'=> 'nullable|string|max:120',
            'evento_id'  => 'required|exists:tbl_eventos,id',
        ]);

        // Determinar tipo de visitante
        $tipo = $validated['matricula'] ? 'estudiante' : 'externo';

        // ── Buscar o crear visitante ─────────────────────────────────────
        // Prioridad: buscar por matrícula si es estudiante, si no por correo
        $visitante = null;

        if (!empty($validated['matricula'])) {
            $visitante = Visitante::where('matricula', $validated['matricula'])->first();
        }

        if (!$visitante && !empty($validated['correo'])) {
            $visitante = Visitante::where('email', $validated['correo'])->first();
        }

        if (!$visitante) {
            $visitante = Visitante::create([
                'tipo'             => $tipo === 'estudiante' ? \App\Enums\TipoVisitante::Estudiante : \App\Enums\TipoVisitante::Externo,
                'nombre_completo'  => $validated['nombre'],
                'matricula'        => $validated['matricula'] ?? null,
                'email'            => $validated['correo'] ?? null,
                'dependencia'      => $validated['dependencia'] ?? $validated['facultad'] ?? null,
                'carrera'          => $validated['carrera'] ?? null,
            ]);
        } else {
            $visitante->update([
                'nombre_completo' => $validated['nombre'],
                'dependencia'     => $validated['dependencia'] ?? $validated['facultad'] ?? $visitante->dependencia,
                'carrera'         => $validated['carrera'] ?? $visitante->carrera,
            ]);
        }

        // Crear registro en Asistencia General si es estudiante y no existe hoy
        if ($tipo === 'estudiante' && !empty($validated['matricula'])) {
            $estudianteOficial = \App\Models\Estudiante::where('matricula', $validated['matricula'])->first();
            if ($estudianteOficial) {
                $asistenciaGeneralHoy = \App\Models\AsistenciaGeneral::where('estudiante_id', $estudianteOficial->id)
                    ->whereDate('created_at', now()->toDateString())
                    ->first();
                if (!$asistenciaGeneralHoy) {
                    \App\Models\AsistenciaGeneral::create([
                        'estudiante_id' => $estudianteOficial->id,
                        'hora_entrada'  => now(),
                    ]);
                }
            }
        }

        // ── Verificar si ya está registrado en este evento ───────────────
        $eventoId = $validated['evento_id'];

        $yaRegistrado = AsistenciaEvento::where('evento_id', $eventoId)
            ->where('visitante_id', $visitante->id)
            ->exists();

        if ($yaRegistrado) {
            return response()->json([
                'mensaje' => 'Ya estás registrado en este evento. ¡Hasta pronto!',
                'ya_registrado' => true,
            ], 200);
        }

        // ── Generar token (Opción 2) ─────────────────────────────────────
        $token = Str::upper(Str::random(8)); // e.g. "A3X9KP2Q"
        $tokenExpira = now()->addHours(8);

        // ── Crear registro de asistencia ─────────────────────────────────
        AsistenciaEvento::create([
            'evento_id'      => $eventoId,
            'visitante_id'   => $visitante->id,
            'asistencia'     => false,
            'fecha_registro' => now(),
            'token'          => $token,
            'token_expira_at'=> $tokenExpira,
        ]);

        // ── Enviar correo con token si hay correo disponible (Opción 2) ──
        $correoEnviado = false;
        $correoDestino = $validated['correo'] ?? $visitante->email ?? null;

        if ($correoDestino) {
            $evento = Evento::find($eventoId);
            try {
                Mail::to($correoDestino)->send(
                    new AsistenciaToken(
                        nombreVisitante: $validated['nombre'],
                        tituloEvento: $evento->titulo ?? 'Expo LMAD',
                        token: $token
                    )
                );
                $correoEnviado = true;
            } catch (\Exception $e) {
                // El registro se guarda igual; solo el correo falló
            }
        }

        $mensaje = '¡Registro exitoso!';
        if ($correoEnviado) {
            $mensaje .= ' Te enviamos tu token de confirmación al correo.';
        } else {
            $mensaje .= ' Tu token de salida es: ' . $token . ' — guárdalo para confirmar tu asistencia.';
        }

        return response()->json([
            'mensaje'        => $mensaje,
            'correo_enviado' => $correoEnviado,
            // Solo exponemos el token si NO se pudo enviar el correo
            'token'          => $correoEnviado ? null : $token,
        ], 201);
    }

    // ─── API: Confirmación Opción 1 — por matrícula ──────────────────────────

    /**
     * Confirma la asistencia usando la matrícula.
     * El visitante simplemente ingresa su matrícula y el evento en /Asistencia.
     */
    public function confirmarPorMatricula(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'matricula' => 'required|string|max:20',
            'evento_id' => 'required|exists:tbl_eventos,id',
        ]);

        $visitante = Visitante::where('matricula', $validated['matricula'])->first();

        if (!$visitante) {
            return response()->json([
                'mensaje' => 'No se encontró ningún registro con esa matrícula. ¿Te registraste al inicio del evento?',
            ], 404);
        }

        $asistencia = AsistenciaEvento::where('evento_id', $validated['evento_id'])
            ->where('visitante_id', $visitante->id)
            ->first();

        if (!$asistencia) {
            return response()->json([
                'mensaje' => 'No encontramos tu registro en este evento. Asegúrate de haberte registrado al entrar.',
            ], 404);
        }

        if ($asistencia->asistencia) {
            return response()->json([
                'mensaje' => '¡Tu asistencia ya fue confirmada anteriormente!',
                'ya_confirmado' => true,
            ], 200);
        }

        $asistencia->update([
            'asistencia'  => true,
            'fecha_salida'=> now(),
        ]);

        return response()->json([
            'mensaje' => '¡Asistencia confirmada! Gracias por participar en la Expo LMAD. 🎉',
        ], 200);
    }

    // ─── API: Confirmación Opción 2 — por token ──────────────────────────────

    /**
     * Confirma la asistencia usando el token enviado por correo.
     */
    public function confirmarPorToken(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'correo' => 'required|email|max:120',
            'token'  => 'required|string|max:64',
        ]);

        $visitante = Visitante::where('email', $validated['correo'])->first();

        if (!$visitante) {
            return response()->json([
                'mensaje' => 'No se encontró ningún registro con ese correo.',
            ], 404);
        }

        $asistencia = AsistenciaEvento::where('visitante_id', $visitante->id)
            ->where('token', strtoupper($validated['token']))
            ->first();

        if (!$asistencia) {
            return response()->json([
                'mensaje' => 'Token incorrecto. Revisa el correo que recibiste al registrarte.',
            ], 404);
        }

        // Verificar expiración
        if ($asistencia->token_expira_at && now()->isAfter($asistencia->token_expira_at)) {
            return response()->json([
                'mensaje' => 'El token ha expirado. Acércate con el staff para confirmar tu asistencia manualmente.',
            ], 422);
        }

        if ($asistencia->asistencia) {
            return response()->json([
                'mensaje' => '¡Tu asistencia ya fue confirmada anteriormente!',
                'ya_confirmado' => true,
            ], 200);
        }

        $asistencia->update([
            'asistencia'  => true,
            'fecha_salida'=> now(),
            'token'       => null, // Invalidamos el token una vez usado
        ]);

        return response()->json([
            'mensaje' => '¡Asistencia confirmada con éxito! Gracias por participar en la Expo LMAD. 🎉',
        ], 200);
    }
}
