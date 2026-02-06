<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Models\Profesor;
use App\Models\Materia;
use App\Models\Estudiante;
use App\Models\AutorProyecto;
use App\Models\MultimediaProyecto;


class Proyecto extends Model
{
    /** @use HasFactory<\Database\Factories\ProyectoFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_proyectos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'slug',
        'estatus',
        'retroalimentacion',
        'codigo_acceso',
        'profesor_id',
        'materia_id',
        'periodo_semestral',
    ];

    protected $casts = [
        'estatus' => 'string',
    ];


    /**
     * Permitir busqueda de rutas
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Que profesor creo el "asiento" 
     */
    public function profesor(): BelongsTo
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }


    /**
     * A que materia pertenece el proyecto
     */
    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    /**
     * Relacion con estudiantes
     */
    public function autores(): BelongsToMany
    {
        /*return $this->belongsToMany(Estudiante::class, 'tbl_autores_proyecto', 
                                    'proyecto_id', 'estudiante_id')
                    ->using(AutorProyecto::class)
                    ->withPivot('es_lider')
                    ->withTimestamps()
        */

        return $this->belongsToMany(Estudiante::class, 'tbl_autores_proyecto', 'proyecto_id', 'estudiante_id')
            // ->using(AutorProyecto::class) // Comenta esto para probar
            ->withPivot('es_lider')
            ->withTimestamps();
    }

    /**
     * Relacion con los archivos multimedia
     */
    public function multimedia(): HasMany
    {
        return $this->hasMany(MultimediaProyecto::class, 'proyecto_id');
    }

    /**
     * Helper para obtener solamente la portada
     */
    public function portada(): HasOne
    {
        return $this->hasOne(MultimediaProyecto::class, 'proyecto_id')
            ->where('es_portada', true);
    }

    /**
     * Relacion con los softwares utilizados
     */
    public function softwares(): BelongsToMany
    {
        return $this->belongsToMany(
            Software::class,
            'tbl_softwares_por_proyectos',
            'proyecto_id',
            'software_id'
        )
            ->withTimestamps();
    }

    /**
     * Accesor para obtener la categoria del proyecto
     */
    public function getNombreCategoriaAttribute(): string
    {
        return $this->materia?->categoria?->nombre ?? 'Sin Categoría';
    }

    /**
     * Para accdder a todo el objeto categoria
     */
    public function getCategoriaAttribute()
    {
        return $this->materia?->categoria;
    }
}
