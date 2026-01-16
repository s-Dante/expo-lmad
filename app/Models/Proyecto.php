<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'codigo_acceso',
        'profesor_id',
        'materia_id',
        'periodo_semestral',
    ];

    protected $casts = [
        'estatus' => 'string',
    ];

    // Relaciones
    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function autores()
    {
        return $this->belongsToMany(Estudiante::class, 'tbl_autores_proyecto', 'proyecto_id', 'estudiante_id')
                    ->using(AutorProyecto::class)
                    ->withPivot('es_lider');
    }

    public function multimedia()
    {
        return $this->hasMany(MultimediaProyecto::class, 'proyecto_id');
    }

    public function portada()
    {
        return $this->hasOne(MultimediaProyecto::class, 'proyecto_id')
            ->where('es_portada', true);
    }

    public function softwares()
    {
        return $this->belongsToMany(
            Software::class,
            'tbl_softwares_por_proyectos',
            'proyecto_id',
            'software_id'
        );
    }
}
