<?php

declare(strict_types=1);

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

    /**
     * Eventos a los que asistio
     */
    public function eventos(): BelongsToMany
    {
        return $this->belongsToMany(Evento::class,
                                    'tbl_asistencias_evento',
                                    'visitante_id', 'evento_id'
        )
        ->withPivot(['asistencia', 'fecha_asistencia'])
        ->withTimestamps();
    }

    /**
     * Patrocinadores a los que representa
     */
    public function patrocinios(): BelongsToMany
    {
        return $this->belongsToMany(Patrocinador::class,
                                    'tbl_representantes_patrocinador',
                                    'visitante_id', 'patrocinador_id'
        )
        ->withPivot(['cargo', 'deleted_at'])
        ->withTimestamps()
        ->wherePivotNull('deleted_at');
    }

    /**
     * LÓGICA DE NEGOCIO:
     * Intenta encontrar al estudiante oficial en el padrón usando la matrícula.
     * Útil para validar AFI.
     */
    public function obtenerEstudianteOficial(): ?Estudiante
    {
        if (!$this->matricula || $this->tipo !== 'estudiante') {
            return null;
        }
        return Estudiante::where('matricula', $this->matricula)->first();
    }
}
