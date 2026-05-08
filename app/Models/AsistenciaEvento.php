<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsistenciaEvento extends Model
{
    /** @use HasFactory<\Database\Factories\AsistenciaEventoFactory> */
    use HasFactory;

    protected $table = 'tbl_asistencias_evento';

    protected $fillable = [
        'evento_id',
        'visitante_id',
        'asistencia',
        'fecha_registro',
        'fecha_salida',
        'token',
        'token_expira_at',
    ];

    protected $casts = [
        'asistencia'      => 'boolean',
        'fecha_registro'  => 'datetime',
        'fecha_salida'    => 'datetime',
        'token_expira_at' => 'datetime',
    ];

    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class, 'evento_id');
    }

    public function visitante(): BelongsTo
    {
        return $this->belongsTo(Visitante::class, 'visitante_id');
    }
}
