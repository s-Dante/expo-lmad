<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Models\Evento;

class Visitante extends Model
{
    /** @use HasFactory<\Database\Factories\VisitanteFactory> */
    use HasFactory;
    use SoftDeletes;
    use HasUuids;

    protected $table = 'tbl_visitantes';

    // Columna 'uuid' usa el trato de UUIDs
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    protected $fillable = [
        'tipo',
        'matricula',
        'dependencia',
        'carrera',
        'semestre',
        'genero',
        'rango-edad',
    ];

    protected $casts = [
        //Podriamos castear 'tipo' por un enum en un futuro
    ];

    // Relaciones
    public function eventos(): BelongsToMany
    {
        return $this->belongsToMany(
            Evento::class,
            'tbl_asistencias_evento',
            'visitantes_id', // Nota: En tu migración pusiste 'visitantes_id' (plural)
            'evento_id'
        )
        ->withPivot(['asistencia', 'fecha_asistencia'])
        ->withTimestamps();
    }

    // Viitantes que son patrocinadores
    public function patrocinios(): BelongsToMany
    {
        return $this->belongsToMany(
            Patrocinador::class,
            'tbl_representantes_patrocinador',
            'visitante_id',
            'patrocinador_id'
        )
        ->withPivot(['cargo', 'deleted_at'])
        ->withTimestamps()
        ->wherePivotNull('deleted_at');
    }
}
