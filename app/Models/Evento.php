<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Conferencista;
use App\Models\Visitante;

class Evento extends Model
{
    /** @use HasFactory<\Database\Factories\EventoFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_eventos';

    protected $fillable = [
        'titulo',
        'slug',
        'tipo',
        'descripcion_evento',
        'fecha_inicio_evento',
        'fecha_fin_evento',
        'ubicacion_evento',
        'capacidad',
        'poster_evento',
        'estatus_evento',
    ];

    protected $casts = [
        'fecha_inicio_evento' => 'datetime',
        'fecha_fin_evento' => 'datetime',
        'capacidad' => 'integer',
    ];

    /**
     * Conferencistas que presentan este evento.
     */
    public function conferencistas(): BelongsToMany
    {
        return $this->belongsToMany(
            Conferencista::class,
            'tbl_conferencista_evento',
            'evento_id',
            'conferencista_id'
        );
    }

    /**
     * Visitantes que asisten a este evento.
     */
    public function visitantes(): BelongsToMany
    {
        return $this->belongsToMany(
            Visitante::class,
            'tbl_asistencias_evento',
            'evento_id',
            'visitantes_id'
        )
        ->withPivot(['asistencia', 'fecha_asistencia'])
        ->withTimestamps();
    }
}
